<?php

namespace App\Http\Controllers;

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
}
