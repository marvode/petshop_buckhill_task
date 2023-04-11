<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\V1\IdentityContract;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Symfony\Component\HttpFoundation\Response;

class UserLogoutController extends Controller
{
    use ApiResponser;

    private IdentityContract $identityService;

    public function __construct(IdentityContract $identityService)
    {
        $this->identityService = $identityService;
    }

    public function __invoke(): Response
    {
        $this->identityService->logout();

        return $this->successResponse([]);
    }
}
