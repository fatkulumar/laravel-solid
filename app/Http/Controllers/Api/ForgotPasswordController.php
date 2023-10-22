<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObject\UserDTO;
use App\Http\Controllers\Controller;
use App\Services\ForgotPassword\ForgotPasswordService;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    private $forgotPasswordService;

    function __construct(ForgotPasswordService $forgotPasswordService)
    {
        $this->forgotPasswordService = $forgotPasswordService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $forgotPassword = new UserDTO;
        $forgotPassword->setEmail($request->post('email'));
        $forgotPassword->setPassword($request->post('password'));
        $result = $this->forgotPasswordService->forgotPassword($forgotPassword);
        return $result;
    }
}
