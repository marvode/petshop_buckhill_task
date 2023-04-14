<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Contracts\V1\UserAccountManagementContract;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class UserDeleteController extends Controller
{
    use ApiResponser;

    public function __construct(protected UserAccountManagementContract $userAccountService)
    {}

    /**
     * @OA\Delete(
     *     path="/api/v1/user",
     *     tags={"User"},
     *     summary="Delete a User account",
     *     operationId="user-delete",
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
    public function __invoke(Request $request): Response
    {
        $this->userAccountService->delete(Auth::user()->uuid);
        return $this->successResponse([], 204);
    }
}
