<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObject\UserDTO;
use App\Http\Controllers\Controller;
use App\Services\SendEmail\SendEmailService;
use Illuminate\Http\Request;

class SendEmailController extends Controller
{
    private $sendEmailService;

    function __construct(SendEmailService $sendEmailService)
    {
        $this->sendEmailService = $sendEmailService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sendEmail = new UserDTO;
        $sendEmail->setEmail($request->post('email'));
        $result = $this->sendEmailService->sendEmail($sendEmail);
        return $result;
    }
}
