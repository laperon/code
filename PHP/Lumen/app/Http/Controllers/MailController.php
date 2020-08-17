<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){}

    public function emailTest() {}

    /**
     * Send email with hash_id to user
     *
     * @param $hash_id
     * @param $user_mail
     */
    public function sendUserEmail($hash_id, $user_mail)
    {
        $params = http_build_query(['hash_id' => $hash_id]);
        $url = url('websitecheck') . '?' . $params;

        try {
            Mail::raw("Your hash id ==> {$url}", function($message) use($user_mail) {
                $message->to($user_mail);
            });
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}


