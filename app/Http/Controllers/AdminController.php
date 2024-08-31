<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\AdminMessage;
use App\User;

class AdminController extends Controller
{
    public function showNotification(){
       return view('admin.notification');
    }
    public function sendAlert(Request $request){
        if(!env('ONESIGNAL_APP_ID',false)){
            return redirect()->route('notifications.index')->withStatus(__('One Signal is not installed.'));
        }
        $users  = User::all();
        foreach ($users as $user){
         $response =   $user->notify(new AdminMessage($request->title,$request->body));
        }
        return redirect()->route('notifications.index')->withStatus(__('Sent successfully.'));
    }
}
