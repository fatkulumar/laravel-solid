<?php

    namespace App\Services\sendEmail;

    use App\DataTransferObject\UserDTO;
    use App\Mail\SendEmail;
    use App\Repositories\SendEmail\SendEmailRepository;
    use App\Services\Service;
    use App\Services\SendEmail\SendEmailService;
    use Illuminate\Http\JsonResponse;
    use App\Traits\EntityValidator;
    use App\Traits\ResultService;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Mail;

    class SendEmailServiceImplement extends Service implements SendEmailService
    {
        use EntityValidator;
        use ResultService;
        use EntityValidator;

        protected $sendEmailRepository;

        public function __construct(SendEmailRepository $sendEmailRepository)
        {
            $this->sendEmailRepository = $sendEmailRepository;
        }

        public function sendEmail(UserDTO $params): JsonResponse
        {
            try {
                $validasiData = $this->sendEmailValidator($params);
                if ($this->code != 200) {
                    return $validasiData;
                }

                $checkEmail = $this->sendEmailRepository->getByEmail($params->getEmail());
                if(!$checkEmail) {
                    return response()->json([
                        'success' => false,
                        'code' => JsonResponse::HTTP_CREATED,
                        'message' => 'Email Tidak Ditemukan',
                        'data' => null,
                    ], JsonResponse::HTTP_CREATED);
                    return $this->toJson();
                }

                Mail::to($params->getEmail())->send(new SendEmail());

                return response()->json([
                    'success' => true,
                    'code' => JsonResponse::HTTP_OK,
                    'message' => 'Email Terkirim',
                    'data' => $params->getEmail(),
                ], JsonResponse::HTTP_OK);

            } catch (\Exception $exception) {
                $this->exceptionResponse($exception);
                $errors['message'] = $exception->getMessage();
                $errors['file'] = $exception->getFile();
                $errors['line'] = $exception->getLine();
                Log::channel('daily')->info('function sendEmail in SendEmailServiceImplement', $errors);
            }
            return $this->toJson();
        }

        private function sendEmailValidator(UserDTO $params): JsonResponse
        {
            try {
                $rules = [
                    'email' => 'required|email'
                ];

                $Validatedata = [
                    'email' => $params->getEmail(),
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
