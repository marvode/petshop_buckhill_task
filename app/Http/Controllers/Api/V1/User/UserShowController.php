<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Contracts\V1\UserAccountManagementContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

class UserShowController extends Controller
{
    public function __construct(protected UserAccountManagementContract $userAccountService)
    {}

    /**
     * @OA\Get(
     *     path="/api/v1/user",
     *     tags={"User"},
     *     summary="View a User account",
     *     operationId="user-read",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Page not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function __invoke(): JsonResource
    {
        $user = $this->userAccountService->show(Auth::user()->uuid);

        return new UserResource($user);
    }
}
