<?php

    namespace App\Services\ForgotPassword;

    use App\DataTransferObject\UserDTO;
    use App\Http\Resources\Auth\AuthResource;
    use App\Repositories\ForgotPassword\ForgotPasswordRepository;
    use App\Services\Service;
    use App\Services\ForgotPassword\ForgotPasswordService;
    use Illuminate\Http\JsonResponse;
    use App\Traits\EntityValidator;
    use App\Traits\ResultService;
    use Illuminate\Support\Facades\Log;

    class ForgotPasswordServiceImplement extends Service implements ForgotPasswordService
    {
        use EntityValidator;
        use ResultService;
        use EntityValidator;

        protected $forgotPasswordRepository;

        public function __construct(ForgotPasswordRepository $forgotPasswordRepository)
        {
            $this->forgotPasswordRepository = $forgotPasswordRepository;
        }

        public function forgotPassword(UserDTO $params): JsonResponse
        {
            try {
                $validasiData = $this->forgotPasswordValidator($params);
                if ($this->code != 200) {
                    return $validasiData;
                }

                $checkEmail = $this->forgotPasswordRepository->getByEmail($params->getEmail());
                if(!$checkEmail) {
                    return response()->json([
                        'success' => false,
                        'code' => JsonResponse::HTTP_CREATED,
                        'message' => 'Email Tidak Ditemukan',
                        'data' => null,
                    ], JsonResponse::HTTP_CREATED);
                    return $this->toJson();
                }else{
                    $id = $checkEmail->id;
                    $this->forgotPasswordRepository->update($id, [
                        'password' => $params->getPassword()
                    ]);
                    $data = $this->forgotPasswordRepository->getById($id);
                    $dataResource = new AuthResource($data);
                    return response()->json([
                        'success' => false,
                        'code' => JsonResponse::HTTP_OK,
                        'message' => 'Update Password Berhasil',
                        'data' => $dataResource,
                    ], JsonResponse::HTTP_OK);
                    return $this->toJson();
                }

            } catch (\Exception $exception) {
                $this->exceptionResponse($exception);
                $errors['message'] = $exception->getMessage();
                $errors['file'] = $exception->getFile();
                $errors['line'] = $exception->getLine();
                Log::channel('daily')->info('function sendEmail in SendEmailServiceImplement', $errors);
            }
            return $this->toJson();
        }

        private function forgotPasswordValidator(UserDTO $params): JsonResponse
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
                    'password' => $params->getPassword(),
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
    }
