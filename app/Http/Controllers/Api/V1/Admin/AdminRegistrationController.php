<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Contracts\V1\IdentityContract;
use App\DataTransferObjects\AdminRegisterDto;
use App\DataTransferObjects\UserRegisterDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AdminRegisterRequest;
use App\Http\Requests\V1\UserRegisterRequest;
use App\Http\Resources\V1\UserRegistrationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

class AdminRegistrationController extends Controller
{
    public IdentityContract $identityService;

    /**
     * @OA\Post(
     *     path="/api/v1/admin/create",
     *     operationId="admin-create",
     *     tags={"Admin"},
     *     summary="Create an Admin account",
     *     requestBody={
     *         "required": true,
     *         "content": {
     *             "application/x-www-form-urlencoded": {
     *                 "schema": {
     *                     "required": {
     *                         "first_name",
     *                         "last_name",
     *                         "email",
     *                         "password",
     *                         "password_confirmation",
     *                         "avatar",
     *                         "address",
     *                         "phone_number"
     *                     },
     *                     "properties": {
     *                         "first_name": {
     *                             "type": "string",
     *                             "description": "User firstname"
     *                         },
     *                         "last_name": {
     *                             "type": "string",
     *                             "description": "User lastname"
     *                         },
     *                         "email": {
     *                             "type": "string",
     *                             "description": "User email"
     *                         },
     *                         "password": {
     *                             "type": "string",
     *                             "description": "User password"
     *                         },
     *                         "password_confirmation": {
     *                             "type": "string",
     *                             "description": "User password"
     *                         },
     *                         "avatar": {
     *                             "type": "string",
     *                             "description": "Avatar image UUID"
     *                         },
     *                         "address": {
     *                             "type": "string",
     *                             "description": "User main address"
     *                         },
     *                         "phone_number": {
     *                             "type": "string",
     *                             "description": "User main phone number"
     *                         },
     *                         "marketing": {
     *                             "type": "string",
     *                             "description": "User marketing preferences"
     *                         }
     *                     },
     *                     "type": "object"
     *                 }
     *             }
     *         }
     *     },
     *     responses={
     *         @OA\Response(response="200", description="OK"),
     *         @OA\Response(response="401", description="Unauthorized"),
     *         @OA\Response(response="404", description="Page not found"),
     *         @OA\Response(response="422", description="Unprocessable Entity"),
     *         @OA\Response(response="500", description="Internal server error")
     *     },
     *     security={}
     * )
     */
    public function __construct(IdentityContract $identityService)
    {
        $this->identityService = $identityService;
    }

    public function __invoke(AdminRegisterRequest $request): JsonResource
    {
        $info = AdminRegisterDto::fromRequest($request);

        $user = $this->identityService->adminRegisteration($info);

        return new UserRegistrationResource($user);
    }
}
