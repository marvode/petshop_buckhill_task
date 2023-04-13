<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Contracts\V1\IdentityContract;
use App\DataTransferObjects\LoginDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Resources\V1\LoginResource;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class UserLoginController extends Controller
{
    use ApiResponser;

    private IdentityContract $identityService;

    public function __construct(IdentityContract $identityService)
    {
        $this->identityService = $identityService;
    }

    /**
     * @OA\Post(
     *      path="/api/v1/user/login",
     *      tags={"User"},
     *      summary="Login a user account",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="email",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="string"
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function __invoke(LoginRequest $request): LoginResource
    {
        $credentials = LoginDto::fromRequest($request, false);

        $result = $this->identityService->login($credentials);

        return new LoginResource($result);
    }
}
