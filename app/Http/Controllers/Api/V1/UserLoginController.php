<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\V1\IdentityContract;
use App\DataTransferObjects\LoginDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Resources\V1\LoginResource;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class UserLoginController extends Controller
{
    use ApiResponser;

    private IdentityContract $identityService;

    public function __construct(IdentityContract $identityService)
    {
        $this->identityService = $identityService;
    }

    public function __invoke(LoginRequest $request): LoginResource
    {
        $credentials = LoginDto::fromRequest($request);

        $result = $this->identityService->login($credentials);

        return new LoginResource($result);
    }
}
