<?php

namespace App\Http\Middleware;

use App\Interfaces\JwtServiceInterface;
use App\Models\JwtToken;
use App\Traits\ApiResponser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpFoundation\Response;

class JwtAuthenticationMiddleware
{
    use ApiResponser;

    private JwtServiceInterface $jwtService;

    public function __construct(JwtServiceInterface $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $jwt = $request->bearerToken();

        if (!$jwt) {
            return $this->errorResponse(['Missing Bearer Token'], 401);
        }

        $token = JwtToken::where('unique_id', $jwt)->first();

        if ($token === null) {
            return $this->errorResponse(['Revoked Bearer Token'], 401);
        }

        $claims = $this->jwtService->parseToken($jwt);

        if ($this->jwtService->validateToken($jwt, $claims['exp'])) {
            return $this->errorResponse(['Invalid JWT'], 401);
        }

        Auth::loginUsingId($claims['uuid']);
        $request->attributes->add(['user_id' => $claims['uuid']]);

        return $next($request);
    }
}
