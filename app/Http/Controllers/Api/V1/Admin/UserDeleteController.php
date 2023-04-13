<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Contracts\V1\AdminUserManagementContract;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class UserDeleteController extends Controller
{
    use ApiResponser;

    public function __construct(protected AdminUserManagementContract $userManagementContract)
    {
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/admin/user-delete/{uuid}",
     *     operationId="admin-user-delete",
     *     tags={"Admin"},
     *     summary="Delete a User account",
     *     description="Deletes a User account by UUID",
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the User account to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
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
    public function __invoke(string $uuid): Response
    {
        $this->userManagementContract->deleteUser($uuid);

        return $this->successResponse([], 204);
    }
}
