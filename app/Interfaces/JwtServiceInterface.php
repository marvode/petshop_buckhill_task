<?php

namespace App\Interfaces;

use App\Models\User;

interface JwtServiceInterface
{
    public function generateToken(User $user): string;
    public function parseToken(string $jwt): array;
    public function validateToken(string $jwt): bool;
}
