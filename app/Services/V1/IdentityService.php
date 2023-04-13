<?php

namespace App\Services\V1;

use App\Contracts\V1\IdentityContract;
use App\DataTransferObjects\LoginDto;
use App\Interfaces\JwtServiceInterface;
use App\Models\User;
use App\Results\LoginResult;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class IdentityService implements IdentityContract
{
    private JwtServiceInterface $jwtService;

    public function __construct(JwtServiceInterface $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function login(LoginDto $credentials): LoginResult
    {
        $user = User::where('is_admin', $credentials->is_admin)
            ->where('email', $credentials->email)
            ->first();

        if ($user === null) {
            throw new AuthenticationException('invalid credentials');
        }

        $isPasswordMatched = Hash::check($credentials->password, $user->password);
        if (!$isPasswordMatched) {
            throw new AuthenticationException('invalid credentials');
        }

        $jwt = $this->jwtService->generateToken($user);

        if ($user->jwtToken !== null) {
            $user->jwtToken()->delete();
        }

        $user->jwtToken()->create([
            'unique_id' => $jwt,
            'token_title' => 'Default',
            'expires_at' => $this->jwtService->parseToken($jwt)['exp'],
            'last_used_at' => now(),
        ]);

        return new LoginResult($jwt, 'Bearer');
    }

    public function logout(): void
    {
        Auth::user()->jwtToken()->delete();
    }
}
