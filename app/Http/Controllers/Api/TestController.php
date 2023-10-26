<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObject\TestDTO;
use App\Http\Controllers\Controller;
use App\Services\Test\TestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestController extends Controller
{
    private $testService;
    /**
     * Display a listing of the resource.
     */
    function __construct(TestService $testService)
    {
        $this->testService = $testService;

        // $this->middleware(['role:admin'])->only('index');
    }

    public function index(): JsonResponse
    {
        $result = $this->testService->all();
        return $result;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $test = new TestDTO;
        $test->setTest($request->post('test'));
        $test->setFile($request->file('foto'));
        $result = $this->testService->create($test);
        return $result;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $test = new TestDTO;
        $test->setId($id);
        $result = $this->testService->getById($test);
        return $result;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $test = new TestDTO;
        $test->setId($id);
        $test->setTest($request->post('test'));
        $test->setFile($request->file('foto'));
        $result = $this->testService->update($test);
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */

    function delete(string $id): JsonResponse
    {
        $test = new TestDTO();
        $test->setId($id);
        $result = $this->testService->delete($test);
        return $result;
    }

    /**
     * Remove some resource from storage.
    */
    public function destroy(Request $request): JsonResponse
    {
        $test = new TestDTO();
        $test->setId($request->post('id'));
        $result = $this->testService->destroy($test);
        return $result;
    }
}
