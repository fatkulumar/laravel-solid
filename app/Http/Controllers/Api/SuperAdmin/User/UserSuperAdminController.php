<?php

namespace App\Http\Controllers\Api\SuperAdmin\User;

use App\DataTransferObject\UserDTO;
use App\Http\Controllers\Controller;
use App\Services\SuperAdmin\User\UserSuperAdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserSuperAdminController extends Controller
{
    private $userSuperAdminService;

    function __construct(UserSuperAdminService $userSuperAdminService)
    {
        $this->userSuperAdminService = $userSuperAdminService;

        // $this->middleware(['role:super admin'])->only(['users', 'updateUser']);
    }
    /**
     * Display a listing of the resource.
     */
    public function users(): JsonResponse
    {
        $result = $this->userSuperAdminService->users();
        return $result;
    }

    public function updateUser(Request $request): JsonResponse
    {
        $user = new UserDTO;
        $user->setId($request->post('model_id'));
        $user->setModelId($request->post('model_id'));
        $user->setName($request->post('name'));
        $user->setRole($request->post('role'));
        $user->setPermission($request->post('permission'));
        $user->setGuardName($request->post('guard_name'));
        $result = $this->userSuperAdminService->updateUser($user);
        return $result;
    }
}
