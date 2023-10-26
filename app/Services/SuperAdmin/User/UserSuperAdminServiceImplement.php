<?php

    namespace App\Services\SuperAdmin\User;

    use App\DataTransferObject\UserDTO;
    use App\Repositories\Auth\AuthRepository;
    use App\Repositories\SuperAdmin\Permission\HasPermissionSuperAdminRepository;
    use App\Repositories\SuperAdmin\Role\HasRoleSuperAdminRepository;
    use App\Repositories\SuperAdmin\User\UserSuperAdminRepository;
    use App\Services\Service;
    use Illuminate\Http\JsonResponse;
    use App\Traits\EntityValidator;
    use App\Traits\ResultService;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Spatie\Permission\Models\Permission;
    use Spatie\Permission\Models\Role;

    class UserSuperAdminServiceImplement extends Service implements UserSuperAdminService
    {
        use EntityValidator;
        use ResultService;
        use EntityValidator;

        private $userSuperAdminRepository,
                $hasRoleSuperAdminRepository,
                $hasPermissionSuperAdminRepository,
                $authRepository;

        public function __construct(UserSuperAdminRepository $userSuperAdminRepository,
                                    HasRoleSuperAdminRepository $hasRoleSuperAdminRepository,
                                    HasPermissionSuperAdminRepository $hasPermissionSuperAdminRepository,
                                    AuthRepository $authRepository
                                    )
        {
            $this->userSuperAdminRepository = $userSuperAdminRepository;
            $this->hasRoleSuperAdminRepository = $hasRoleSuperAdminRepository;
            $this->hasPermissionSuperAdminRepository = $hasPermissionSuperAdminRepository;
            $this->authRepository = $authRepository;
        }

        public function users(): JsonResponse
        {
            try {
                $data = $this->userSuperAdminRepository->users();

                return response()->json([
                    'success' => true,
                    'code' => JsonResponse::HTTP_OK,
                    'message' => 'Data Berhasil Ditambahkan',
                    'data' => $data,
                ], JsonResponse::HTTP_OK);

            } catch (\Exception $exception) {
                $this->exceptionResponse($exception);
                $errors['message'] = $exception->getMessage();
                $errors['file'] = $exception->getFile();
                $errors['line'] = $exception->getLine();
                Log::channel('daily')->info('function users in SuperAdminServiceImplement', $errors);
            }
            return $this->toJson();
        }

        public function updateUser(UserDTO $params): JsonResponse
        {
            DB::beginTransaction();
            try {
                $validasiData = $this->updateUserValidator($params);
                if ($this->code != 200) {
                    return $validasiData;
                }
                $this->authRepository->update($params->getId(),[
                    'name' => $params->getName()
                ]);
                $data = $this->authRepository->getByIdUser($params->getId());
                $this->hasRoleSuperAdminRepository->deleteRole($params->getModelId());
                $this->hasPermissionSuperAdminRepository->deletePermission($params->getModelId());
                $roles = $params->getRole();
                foreach($roles as $role) {
                        $roleSpatie = Role::findOrCreate($role, $params->getGuardName());
                        $data->assignRole($roleSpatie);
                }
                $permissions = $params->getPermission();
                foreach($permissions as $permission) {
                    $permissionSpatie = Permission::findOrCreate($permission, $params->getGuardName());
                    $data->givePermissionTo($permissionSpatie);
                }
                $dataUser = $this->userSuperAdminRepository->userByEmail($data->email);
                DB::commit();
                $this->setResult($data)
                    ->setStatus(true)
                    ->setMessage('Berhasil Update Data')
                    ->setCode(JsonResponse::HTTP_OK);
            } catch (\Exception $exception) {
                DB::rollBack();
                $this->exceptionResponse($exception);
                $errors['message'] = $exception->getMessage();
                $errors['file'] = $exception->getFile();
                $errors['line'] = $exception->getLine();
                Log::channel('daily')->info('function updateUser in SuperAdminServiceImplement', $errors);
            }
            return $this->toJson();
        }

        private function updateUserValidator(UserDTO $params): JsonResponse
        {
            try {
                $rules = [
                    'model_id' => 'required|string|max:36',
                    'name' => 'required|string|max:255',
                    'role' => 'required|array|max:255',
                    'permission' => 'required|array|max:255'
                ];

                $Validatedata = [
                    'model_id' => $params->getId(),
                    'name' => $params->getName(),
                    'role' => $params->getRole(),
                    'permission' => $params->getPermission()
                ];

                $validator = EntityValidator::validate($Validatedata, $rules);
                if ($validator->fails()) {
                    $error = $validator->errors();

                    $this->setResult($error)
                    ->setStatus(true)
                    ->setMessage('Gagal melakukan validasi input data')
                    ->setCode(JsonResponse::HTTP_BAD_REQUEST);

                    return $this->toJson();
                }

                $this->setResult(null)
                    ->setStatus(true)
                    ->setMessage('Proses Validasi input data berhasil')
                    ->setCode(JsonResponse::HTTP_OK);
            } catch (\Exception $exception) {
                $this->exceptionResponse($exception);
                $errors['message'] = $exception->getMessage();
                $errors['file'] = $exception->getFile();
                $errors['line'] = $exception->getLine();
                Log::channel('daily')->info('function updateUserValidator in UserSuperAdminServiceImplement', $errors);
            }
            return $this->toJson();
        }
    }
