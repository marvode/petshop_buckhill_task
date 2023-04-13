<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Contracts\V1\IdentityContract;
use App\DataTransferObjects\UserRegisterDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UserRegisterRequest;
use App\Http\Resources\V1\UserRegistrationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

class UserRegistrationController extends Controller
{
    public IdentityContract $identityService;

    /**
     * @OA\Post(
     *     path="/api/v1/user/create",
     *     operationId="user-create",
     *     tags={"User"},
     *     summary="Create a User account",
     *     description="Creates a new User account with the provided User information",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
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
     *                 ),
     *                 type="object"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     security={}
     * )
     */
    public function __construct(IdentityContract $identityService)
    {
        $this->identityService = $identityService;
    }

    public function __invoke(UserRegisterRequest $request): JsonResource
    {
        $userInfo = UserRegisterDto::fromRequest($request);

        $user = $this->identityService->userRegisteration($userInfo);

        return new UserRegistrationResource($user);
    }
}
