<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Mail;
use Modules\Authen\Emails\SendVerifyEmail;
class SendMail {
    public static function register($params) {
        // Params: email, token
        $email = isset($params['email']) ? $params['email'] : "";
        Mail::to($email)->send(new SendVerifyEmail($params));
        
    }
    public static function verify($params) {
        // Params: email, token
        $email = isset($params['email']) ? $params['email'] : "";
        Mail::to($email)->send(new SendVerifyEmail($params));
        
    }
}