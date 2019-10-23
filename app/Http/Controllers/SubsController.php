<?php

namespace App\Http\Controllers;

use App\Mail\SubscribeEmail;
use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubsController extends Controller
{
    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:subscriptions'
        ]);

        $subscriber = Subscription::add($request->get('email'));
        $subscriber->generateToken();
        
        Mail::to($subscriber)->send(new SubscribeEmail($subscriber));

        return redirect()->back()->with('status', 'Проверьте вашу почту');
    }

    public function verify($token)
    {
        $subscribers = Subscription::where('token', $token)->firstOrFail();
        $subscribers->token = null;
        $subscribers->save();

        return redirect('/')->with('status', 'Ваша почта подтверждена!');
    }
}
