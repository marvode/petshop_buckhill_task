<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Contracts\V1\AdminUserManagementContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;

class UserListingController extends Controller
{
    public function __construct(protected AdminUserManagementContract $userManagementService)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/admin/user-listing",
     *     tags={"Admin"},
     *     summary="List all users",
     *     operationId="admin-user-listing",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Limit per page",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="sortBy",
     *         in="query",
     *         description="Field to sort by",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="desc",
     *         in="query",
     *         description="Sort in descending order",
     *         required=false,
     *         @OA\Schema(
     *             type="boolean"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="first_name",
     *         in="query",
     *         description="Filter by first name",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Filter by email",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="phone",
     *         in="query",
     *         description="Filter by phone",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="address",
     *         in="query",
     *         description="Filter by address",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="created_at",
     *         in="query",
     *         description="Filter by created date",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="marketing",
     *         in="query",
     *         description="Filter by marketing status",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             enum={"0", "1"}
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

    public function __invoke(Request $request): AnonymousResourceCollection
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        $sort = $request->get('sortBy', 'id');
        $desc = $request->get('desc', false);
        $first_name = $request->get('first_name', '');
        $last_name = $request->get('last_name', '');
        $email = $request->get('email', '');
        $phone_number = $request->get('phone', '');
        $is_marketing = $request->get('is_marketing', null);
        $created_at = $request->get('created_at', '');

        $users = $this->userManagementService->getAllUsers($page, $limit, $sort, $desc, $first_name, $last_name, $email, $phone_number, $is_marketing, $created_at);

        return UserResource::collection($users);
    }
}
