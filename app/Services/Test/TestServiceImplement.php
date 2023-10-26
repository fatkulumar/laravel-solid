<?php

    namespace App\Services\Test;

    use App\Repositories\Test\TestRepository;
    use App\Services\Service;
    use App\Services\Test\TestService;
    use App\DataTransferObject\TestDTO;
    use App\Http\Resources\Test\TestResource;
    use App\Traits\ResultService;
    use App\Traits\EntityValidator;
    use Illuminate\Http\JsonResponse;
    use App\Traits\FileUpload;
    use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

    class TestServiceImplement extends Service implements TestService
    {

        use ResultService;
        use EntityValidator;
        use FileUpload;

        protected $mainRepository;

        public function __construct(TestRepository $mainRepository)
        {
            $this->mainRepository = $mainRepository;
        }

        protected function fileSettings()
        {
            $this->settings = [
                'attributes'  => ['jpeg', 'jpg', 'png'],
                'path'        => 'filessss/',
                'softdelete'  => false
            ];
        }

        public function all(): JsonResponse
        {

            try {
                if(Cache::has('data_test')) {
                    $dataFacade = Cache::get('data_test')->count();
                    $dataResource = $this->mainRepository->all()->count();
                    if($dataFacade == $dataResource) {
                        $data = Cache::get('data_test');
                        $this->setResult($data)
                            ->setStatus(true)
                            ->setMessage('Data Berhasil Ditemukan')
                            ->setCode(JsonResponse::HTTP_OK);
                    }else{
                        Cache::forget('data_test');
                        $minutes = 60;
                        $data = cache()->remember('data_test', $minutes, function () {
                            $data = $this->mainRepository->all();
                            $data->map(function ($user) {
                                $user->foto = $user->foto ? app('url')->to('/') . '/storage/' . $user->foto : null;
                                return $user;
                            });
                            return $data;
                        });
                        $this->setResult($data)
                            ->setStatus(true)
                            ->setMessage('Data Berhasil Ditemukan')
                            ->setCode(JsonResponse::HTTP_OK);
                    }
                    return $this->toJson();
                }

                $minutes = 60;
                $data = cache()->remember('data_test', $minutes, function () {
                    $data = $this->mainRepository->all();
                    $data->map(function ($user) {
                        $user->foto = $user->foto ? app('url')->to('/') . '/storage/' . $user->foto : null;
                        return $user;
                    });
                    return $data;
                });

                $dataResource = TestResource::collection($data);

                $this->setResult($dataResource)
                    ->setStatus(true)
                    ->setMessage('Data Berhasil Ditemukan')
                    ->setCode(JsonResponse::HTTP_OK);

            } catch (\Throwable $exception) {
                $this->exceptionResponse($exception);
                $errors['message'] = $exception->getMessage();
                $errors['file'] = $exception->getFile();
                $errors['line'] = $exception->getLine();
                Log::channel('daily')->info('function all in TestServiceImplement', $errors);
            }
            return $this->toJson();
        }

        public function getById(TestDTO $params): JsonResponse
        {
            try {

                $id = $params->getId();
                $data = $this->mainRepository->getById($id);

                if($data) {
                    collect([$data])->map(function ($test) {
                        $test->foto = $test->foto ? app('url')->to('/') . '/storage/' . $test->foto : null;
                        return $test;
                    });
                }

                $dataResource = new TestResource($data);

                $this->setResult($dataResource)
                    ->setStatus(true)
                    ->setMessage('Data Berhasil Ditemukan')
                    ->setCode(JsonResponse::HTTP_OK);

                return $this->toJson();
            } catch (\Exception $exception) {
                $this->exceptionResponse($exception);
                $errors['message'] = $exception->getMessage();
                $errors['file'] = $exception->getFile();
                $errors['line'] = $exception->getLine();
                Log::channel('daily')->info('function getById in TestServiceImplement', $errors);
            }
            return $this->toJson();
        }

        public function create(TestDTO $params): JsonResponse
        {
            try {
                $validasiData = $this->createValidator($params);
                if ($this->code != 200) {
                    return $validasiData;
                }

                $file = $params->getFile();
                $this->fileSettings();
                $upload = $this->uploadFile($file);

                $saveData = [
                    'test' => clean($params->getTest()),
                    'foto' => $upload
                ];

                $data = $this->mainRepository->create($saveData);

                $dataResource = new TestResource($data);

                $this->setResult($dataResource)
                ->setStatus(true)
                ->setMessage('Data Berhasil Ditambahkan')
                ->setCode(JsonResponse::HTTP_OK);

            } catch (\Exception $exception) {
                $this->exceptionResponse($exception);
                $errors['message'] = $exception->getMessage();
                $errors['file'] = $exception->getFile();
                $errors['line'] = $exception->getLine();
                Log::channel('daily')->info('function create in TestServiceImplement', $errors);
            }
            return $this->toJson();
        }

        private function createValidator(TestDTO $params): JsonResponse
        {
            try {
                $rules = [
                    'test' => 'required',
                    'foto' => 'required|image|mimes:jpeg,png,jpg,|max:2048',
                ];

                $Validatedata = [
                    'test' => $params->getTest(),
                    'foto' => $params->getFile(),
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
                Log::channel('daily')->info('function createValidator in TestServiceImplement', $errors);
            }
            return $this->toJson();
        }

        public function update(TestDTO $params): JsonResponse
        {
            try {
                $validasiData = $this->updateValidator($params);
                if ($this->code != 200) {
                    return $validasiData;
                }
                $id = $params->getId();
                $data = $this->mainRepository->getById($id);
                if(!$data) {
                    $this->setResult($id)
                    ->setStatus(false)
                    ->setMessage('Data Tidak Ditemukan')
                    ->setCode(JsonResponse::HTTP_NOT_FOUND);
                    return $this->toJson();
                }
                $file = $params->getFile();
                $this->fileSettings();
                $upload = $this->uploadFile($file);
                $this->deleteFile($data->foto);
                $updateData = [
                    'test' => clean($params->getTest()),
                    'foto' => $upload,
                ];
                $this->mainRepository->update($id, $updateData);
                $data = $this->mainRepository->getById($id);
                $dataResource = new TestResource($data);
                $this->setResult($dataResource)
                    ->setStatus(true)
                    ->setMessage('Data Berhasil Diupdate')
                    ->setCode(JsonResponse::HTTP_OK);
                return $this->toJson();
            } catch (\Exception $exception) {
                $this->exceptionResponse($exception);
                $errors['message'] = $exception->getMessage();
                $errors['file'] = $exception->getFile();
                $errors['line'] = $exception->getLine();
                Log::channel('daily')->info('function update in TestServiceImplement', $errors);
            }
            return $this->toJson();
        }

        private function updateValidator(TestDTO $params): JsonResponse
        {
            try {
                $rules = [
                    'test' => 'required',
                    'foto' => 'required|image|mimes:jpeg,png,jpg,|max:2048',
                ];

                $Validatedata = [
                    'test' => $params->getTest(),
                    'foto' => $params->getFile(),
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
                Log::channel('daily')->info('function updateValidator in TestServiceImplement', $errors);
            }
            return $this->toJson();
        }

        public function delete(TestDTO $params): JsonResponse
        {
            try {
                $id = $params->getId();
                $data = $this->mainRepository->getById($id);
                if(!$data) {
                    $this->setResult($id)
                    ->setStatus(false)
                    ->setMessage('Data Tidak Ditemukan')
                    ->setCode(JsonResponse::HTTP_NOT_FOUND);
                    return $this->toJson();
                }

                $this->fileSettings();
                $this->deleteFile($data->foto);
                $this->mainRepository->delete($id);

                $dataResource = new TestResource($data);

                $this->setResult($data)
                    ->setStatus(true)
                    ->setMessage('Data Berhasil Dihapus')
                    ->setCode(JsonResponse::HTTP_OK);
            } catch (\Exception $exception) {
                $this->exceptionResponse($exception);
                $errors['message'] = $exception->getMessage();
                $errors['file'] = $exception->getFile();
                $errors['line'] = $exception->getLine();
                Log::channel('daily')->info('function delete in TestServiceImplement', $errors);
            }
            return $this->toJson();
        }

        public function destroy(TestDTO $params): JsonResponse
        {
            try {
                $ids = $params->getId();
                if(count($ids) == 0) {
                    $this->setResult(null)
                    ->setStatus(false)
                    ->setMessage('Tidak Ada Yang Dihapus')
                    ->setCode(JsonResponse::HTTP_OK);
                    return $this->toJson();
                }

                foreach($ids as $item) {
                    $id = $item;
                    $data = $this->mainRepository->getById($id);
                    $this->fileSettings();
                    $this->deleteFile($data->foto);
                    $this->mainRepository->delete($id);
                }

                $this->setResult($ids)
                ->setStatus(true)
                ->setMessage('Data Berhasil Dihapus')
                ->setCode(JsonResponse::HTTP_OK);
            } catch (\Exception $exception) {
                $this->exceptionResponse($exception);
                $errors['message'] = $exception->getMessage();
                $errors['file'] = $exception->getFile();
                $errors['line'] = $exception->getLine();
                Log::channel('daily')->info('function destroy in TestServiceImplement', $errors);
            }
            return $this->toJson();
        }
    }
