<?php

namespace App\Services;

use App\Models\User;
use App\Interfaces\JwtServiceInterface;
use DateTimeImmutable;
use Lcobucci\Clock\FrozenClock;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Constraint\ValidAt;
use Lcobucci\JWT\Validation\Validator;

class JwtService implements JwtServiceInterface
{
    private InMemory $privateKey;
    private string $issuer;
    private string $audience;
    private string $expiration;
    private InMemory $publicKey;

    public function __construct()
    {
        $this->privateKey = InMemory::file(base_path('private.pem'));
        $this->publicKey = InMemory::file(base_path('public.pem'));
        $this->issuer = config('jwt.issuer');
        $this->audience = config('jwt.audience');
        $this->expiration = '+' . config('jwt.expiration') . ' seconds';
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
            ->expiresAt($now->modify($this->expiration))
            ->withClaim('uuid', $user->uuid)
            ->getToken($algorithm, $this->privateKey);

        return $token->toString();
    }

    public function parseToken(string $jwt): array
    {
        $token = (new Parser(new JoseEncoder()))->parse($jwt);

        return $token->claims()->all();
    }

    public function validateToken(string $jwt, DateTimeImmutable $exp): bool
    {
        $token = (new Parser(new JoseEncoder()))->parse($jwt);

        $validator = new Validator();

        return $validator->validate(
            $token,
            new IssuedBy($this->issuer),
            new SignedWith(new Sha256(), $this->publicKey),
            new ValidAt(new FrozenClock($exp))
        );
    }
}
