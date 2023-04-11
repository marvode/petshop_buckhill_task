<?php

namespace App\Services;

use App\Models\User;
use App\Interfaces\JwtServiceInterface;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Validation\Validator;

class JwtService implements JwtServiceInterface
{
    private Lcobucci\JWT\Signer\Key $privateKey;
    private string $issuer;
    private string $audience;
    private string $expiration;
    private Lcobucci\JWT\Signer\Key $publicKey;

    public function __construct()
    {
        $this->privateKey = InMemory::file(base_path('private.pem'));
        $this->publicKey = InMemory::file(base_path('public.pem'));
        $this->issuer = config('jwt.issuer');
        $this->audience = config('jwt.audience');
        $this->expiration = config('jwt.expiration');
    }

    public function generateToken(User $user): string
    {
        $tokenBuilder = new Builder(new JoseEncoder(), ChainedFormatter::default());
        $algorithm = new Sha256();
        $now = new DateTimeImmutable();
        $token = $tokenBuilder
            ->issuedBy($this->issuer)
            ->permittedFor($this->audience)
            ->issuedAt($now)
            ->expiresAt($now->modify($this->expiration . 's'))
            ->withClaim('uuid', $user->uuid)
            ->getToken($algorithm, $this->privateKey);

        return $token->toString();
    }

    public function parseToken(string $jwt): array
    {
        $token = (new Parser(new JoseEncoder()))->parse($jwt);

        return $token->claims()->all();
    }

    public function validateToken(string $jwt): bool
    {
        $token = (new Parser(new JoseEncoder()))->parse($jwt);

        $validator = new Validator();

        return $validator->validate(
            $token,
            new Lcobucci\JWT\Validation\Constraint\IssuedBy($this->issuer),
            new Lcobucci\JWT\Validation\Constraint\SignedWith(new Sha256(), $this->publicKey)
        );
    }
}
