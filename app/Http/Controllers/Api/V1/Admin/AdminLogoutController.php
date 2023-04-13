<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Contracts\V1\IdentityContract;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class AdminLogoutController extends Controller
{
    use ApiResponser;

    private IdentityContract $identityService;

    public function __construct(IdentityContract $identityService)
    {
        $this->identityService = $identityService;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/admin/logout",
     *     summary="Logout",
     *     description="Logout the authenticated admin user",
     *     tags={"Admin"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     * )
     */
    public function __invoke(): Response
    {
        $this->identityService->logout();

        return $this->successResponse([]);
    }
}
