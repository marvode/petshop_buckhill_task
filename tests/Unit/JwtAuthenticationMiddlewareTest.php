<?php

namespace Tests\Unit;

use App\Http\Middleware\JwtAuthenticationMiddleware;
use App\Interfaces\JwtServiceInterface;
use App\Models\JwtToken;
use App\Models\RegularUser;
use App\Models\User;
use App\Services\JwtService;
use App\Traits\ApiResponser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Mockery\MockInterface;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class JwtAuthenticationMiddlewareTest extends TestCase
{
    use ApiResponser;

    private JwtAuthenticationMiddleware $middleware;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->partialMock(JwtServiceInterface::class, function (MockInterface $mock) use ($user) {
            $mock->shouldReceive('validateToken')->andReturn(true);
            $mock->shouldReceive('parseToken')->andReturn([
                'uuid' => $user->uuid,
                'exp' => now()->addMinutes(5)->toDateTimeImmutable(),
            ]);
        });

        $jwtService = $this->app->make(JwtServiceInterface::class);
        $this->middleware = new JwtAuthenticationMiddleware($jwtService);
    }

    public function test_handle_valid_token()
    {
        $jwt = 'valid_token';
        JwtToken::factory()->create(['unique_id' => $jwt]);

        $request = Request::create('/test');
        $request->headers->set('Authorization', 'Bearer ' . $jwt);

        $response = $this->middleware->handle($request, function () {
            return response()->json(['message' => 'success']);
        });

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_handle_with_missing_token()
    {
        $request = Request::create('/test');

        $response = $this->middleware->handle($request, function () {
            return response()->json(['message' => 'success']);
        });

        $this->assertEquals(401, $response->getStatusCode());
        $this->assertArrayHasKey('errors', json_decode($response->getContent(), true));
    }

    public function test_handle_with_revoked_token()
    {
        $jwt = 'revoked_token';
        $token = JwtToken::factory()->create(['unique_id' => $jwt]);
        $token->delete();

        $request = Request::create('/test');
        $request->headers->set('Authorization', 'Bearer ' . $jwt);

        $response = $this->middleware->handle($request, function () {
            return response()->json(['message' => 'success']);
        });

        $this->assertEquals(401, $response->getStatusCode());
        $this->assertArrayHasKey('errors', json_decode($response->getContent(), true));
    }
}
