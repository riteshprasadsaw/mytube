<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\UserRegistered;
use Mail;

class EmailController extends Controller
{
    /**
     * Show the application sendMail.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendEmail(Request $request)
    {
        $user_email=$request->user()->email;
        // \Log::info( $user);
    	$content = [
            'subject'=> 'Subscription is cancelled', 
    		'title'=> 'Subscription Cancellation Confirmation ', 
    		'body'=> 'Your subscription has been cancelled. In case you change your mind, you can resume the subscription any time.',
    		'button' => 'Browse Now'
    		];

    	// $receiverAddress =  $user_email;

    	Mail::to($user_email)->send(new UserRegistered($content));

    	return "success";
    }
}