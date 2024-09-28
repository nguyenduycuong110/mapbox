<?php

namespace App\Http\Controllers\Ajax\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendConfirmMail; 
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{

    public function __construct(){

    }


    public function getCode(Request $request)
    {
        $payload = $request->input('email');
        $confirmCode = time();
        Cookie::queue('confirm_code', $confirmCode, 2);
        Mail::to($payload)->send(new SendConfirmMail($confirmCode));
        return response()->json(
            [
                'messages' => 'Mã xác nhận đã được gửi về Email của bạn !'
            ]
        ); 
    }

}
