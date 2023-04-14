<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Contracts\V1\UserAccountManagementContract;
use App\DataTransferObjects\UserEditDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UserEditRequest;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

class UserEditController extends Controller
{
    public function __construct(protected UserAccountManagementContract $userAccountService)
    {}

    /**
     * @OA\Put(
     *     path="/api/v1/user/edit",
     *     operationId="user-update",
     *     tags={"User"},
     *     summary="Update a User account",
     *     description="Updates a User account",
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
     *                     description="User password confirmation"
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
    public function __invoke(UserEditRequest $request): JsonResource
    {
        $details = UserEditDto::fromRequest($request);
        $userUuid = Auth::user()->uuid;
        $result = $this->userAccountService->edit($details, $userUuid);

        return new UserResource($result);
    }
}
