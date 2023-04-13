<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Contracts\V1\AdminUserManagementContract;
use App\DataTransferObjects\AdminUserEditDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AdminUserEditRequest;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

class UserEditController extends Controller
{
    public function __construct(protected AdminUserManagementContract $userManagementService)
    {}

    /**
     * @OA\Put(
     *     path="/api/v1/admin/user-edit/{uuid}",
     *     operationId="admin-user-edit",
     *     tags={"Admin"},
     *     summary="Edit a User account",
     *     description="Edit a User account",
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the User",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"first_name", "last_name", "email", "password", "password_confirmation", "address", "phone_number"},
     *                 @OA\Property(
     *                     property="first_name",
     *                     type="string",
     *                     description="User firstname"
     *                 ),
     *                 @OA\Property(
     *                     property="last_name",
     *                     type="string",
     *                     description="User lastname"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     description="User email"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     description="User password"
     *                 ),
     *                 @OA\Property(
     *                     property="password_confirmation",
     *                     type="string",
     *                     description="User password"
     *                 ),
     *                 @OA\Property(
     *                     property="avatar",
     *                     type="string",
     *                     description="Avatar image UUID"
     *                 ),
     *                 @OA\Property(
     *                     property="address",
     *                     type="string",
     *                     description="User main address"
     *                 ),
     *                 @OA\Property(
     *                     property="phone_number",
     *                     type="string",
     *                     description="User main phone number"
     *                 ),
     *                 @OA\Property(
     *                     property="is_marketing",
     *                     type="string",
     *                     description="User marketing preferences"
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
     *         response="404",
     *         description="Page not found"
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Entity"
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Internal server error"
     *     )
     * )
     */
    public function __invoke(AdminUserEditRequest $request, string $userUuid): JsonResource
    {
        $userDetails = AdminUserEditDto::fromRequest($request);

        $user = $this->userManagementService->editUser($userUuid, $userDetails);

        return new UserResource($user);
    }
}
