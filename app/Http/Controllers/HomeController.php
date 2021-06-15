<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Models\UserMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        return view('welcome');
    }

    public function termsAndConditions()
    {
        return view('terms-and-conditions');
    }

    public function privacyPolicy()
    {
        return view('privacy-policy');
    }

    public function cookiePolicy()
    {
        return view('cookie-policy');
    }

    public function deliveryPolicy()
    {
        return view('delivery-policy');
    }

    public function faq()
    {
        return view('faq');
    }

    public function contactUs()
    {
        return view('contact-us');
    }

    public function submitContactUs(ContactFormRequest $request)
    {
        $message = UserMessage::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
            'type' => 'contact',
            'user_id' => Auth::check() ? Auth::user()->id : null
        ]);

        return $message;
    }
}
