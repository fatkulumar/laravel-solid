<?php

    namespace App\Services\Auth;

    use App\DataTransferObject\UserDTO;
    use App\Http\Resources\Auth\AuthResource;
    use App\Repositories\Auth\AuthRepository;
    use App\Services\Service;
    use App\Services\Auth\AuthService;
    use Illuminate\Http\JsonResponse;
    use App\Traits\EntityValidator;
    use App\Traits\ResultService;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Log;

    class AuthServiceImplement extends Service implements AuthService
    {
        use EntityValidator;
        use ResultService;
        use EntityValidator;

        protected $mainRepository;

        public function __construct(AuthRepository $mainRepository)
        {
            $this->mainRepository = $mainRepository;
        }

        public function register(UserDTO $params): JsonResponse
        {
            try {
                $validasiData = $this->registerValidator($params);
                if ($this->code != 200) {
                    return $validasiData;
                }

                $saveData = [
                    'name' => $params->getName(),
                    'email' => $params->getEmail(),
                    'password' => $params->getPassword()
                ];

                $data = $this->mainRepository->create($saveData);

                // $token = $data->createToken('auth_token', ['list-test'])->plainTextToken;
                $token = $data->createToken('auth_token')->plainTextToken;

                $dataResource = new AuthResource($data);

                return response()->json([
                    'success' => true,
                    'code' => JsonResponse::HTTP_OK,
                    'message' => 'Data Berhasil Ditambahkan',
                    'data' => $dataResource,
                    'token' => $token
                ], JsonResponse::HTTP_OK);

            } catch (\Exception $exception) {
                $this->exceptionResponse($exception);
                $errors['message'] = $exception->getMessage();
                $errors['file'] = $exception->getFile();
                $errors['line'] = $exception->getLine();
                Log::channel('daily')->info('function register in AuthServiceImplement', $errors);
            }
            return $this->toJson();
        }

        private function registerValidator(UserDTO $params): JsonResponse
        {
            try {
                $rules = [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users',
                    'password' => [
                        'required',
                        'min:8',
                        'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])/', // Kombinasi huruf kecil, huruf kapital, angka, dan karakter khusus
                    ],
                ];

                $Validatedata = [
                    'name' => $params->getName(),
                    'email' => $params->getEmail(),
                    'password' => $params->getPassword()
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
                Log::channel('daily')->info('function registerValidator in AuthServiceImplement', $errors);
            }
            return $this->toJson();
        }

        public function login(UserDTO $params): JsonResponse
        {
            try {
                $validasiData = $this->loginValidator($params);
                if ($this->code != 200) {
                    return $validasiData;
                }

                if (!Auth::attempt(request()->only('email', 'password')))
                {
                    return response()->json([
                        'success' => true,
                        'code' => JsonResponse::HTTP_UNAUTHORIZED,
                        'message' => 'Data Tidak Ditemukan',
                        'data' => null,
                    ], JsonResponse::HTTP_UNAUTHORIZED);
                }

                $data = $this->mainRepository->getByEmail($params->getEmail());

                $token = $data->createToken('auth_token')->plainTextToken;

                $dataResource = new AuthResource($data);

                return response()->json([
                    'success' => true,
                    'code' => JsonResponse::HTTP_OK,
                    'message' => 'Berhasil Login',
                    'data' => $dataResource,
                    'token' => $token
                ], JsonResponse::HTTP_OK);

            } catch (\Exception $exception) {
                $this->exceptionResponse($exception);
                $errors['message'] = $exception->getMessage();
                $errors['file'] = $exception->getFile();
                $errors['line'] = $exception->getLine();
                Log::channel('daily')->info('function login in AuthServiceImplement', $errors);
            }
            return $this->toJson();
        }

        private function loginValidator(UserDTO $params): JsonResponse
        {
            try {
                $rules = [
                    'email' => 'required|email',
                    'password' => [
                        'required',
                        'min:8',
                        'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])/', // Kombinasi huruf kecil, huruf kapital, angka, dan karakter khusus
                    ],
                ];

                $Validatedata = [
                    'email' => $params->getEmail(),
                    'password' => $params->getPassword()
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
                Log::channel('daily')->info('function loginValidator in AuthServiceImplement', $errors);
            }
            return $this->toJson();
        }

        public function logout(UserDTO $params): JsonResponse
        {
            try {

                auth()->user()->currentAccessToken()->delete();

                $this->setResult(null)
                    ->setStatus(true)
                    ->setMessage('Berhasil Logout')
                    ->setCode(JsonResponse::HTTP_OK);
            } catch (\Exception $exception) {
                $this->exceptionResponse($exception);
                $errors['message'] = $exception->getMessage();
                $errors['file'] = $exception->getFile();
                $errors['line'] = $exception->getLine();
                Log::channel('daily')->info('function logout in AuthServiceImplement', $errors);
            }
            return $this->toJson();
        }

        public function notAuthorized(): JsonResponse
        {
            return response()->json([
                'success' => false,
                'code' => JsonResponse::HTTP_UNAUTHORIZED,
                'message' => 'is not authorized',
                'data' => null,
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }
    }
