<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Contracts\V1\IdentityContract;
use App\DataTransferObjects\LoginDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Resources\V1\LoginResource;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class AdminLoginController extends Controller
{
    public IdentityContract $identityService;

    public function __construct(IdentityContract $identityService)
    {
        $this->identityService = $identityService;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/admin/login",
     *     tags={"Admin"},
     *     summary="Login an Admin account",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"email", "password"},
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     description="Admin email"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     description="Admin password"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Entity"
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Internal server error"
     *     ),
     *     security={}
     * )
     */
    public function __invoke(LoginRequest $request): LoginResource
    {
        $credentials = LoginDto::fromRequest($request, true);

        $result = $this->identityService->login($credentials);

        return new LoginResource($result);
    }
}
