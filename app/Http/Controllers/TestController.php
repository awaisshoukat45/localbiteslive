<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class TestController extends Controller
{
    public function sendMail()
    {
       $status = Mail::raw('Hi, welcome user!', function ($message) {
            $message->to('devBilalhussain@gmail.com');
        });
        dd('Done' , $status);
    }
}
