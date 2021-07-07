<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{

    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        $socialUser = Socialite::driver('google')->user();

        $user = User::query()
            ->where('email', $socialUser->getEmail())
            ->where('social_id', $socialUser->getId())
            ->where('social_provider', 'google')
            ->first();

        if ($user) {
            Auth::login($user, true);
            return redirect(RouteServiceProvider::HOME);
        }

        $user = User::create([
            'first_name' => $socialUser->getNickname() ?? $socialUser->getName(),
            'last_name' => '',
            'email' => $socialUser->getEmail(),
            'avatar' => $socialUser->getAvatar(),
            'social_provider' => 'google',
            'social_id' => $socialUser->getId(),
            'password' => Hash::make($socialUser->getName()),
        ]);

        $user->assignRole('user');

        Auth::login($user);

        event(new Registered($user));

        return redirect(RouteServiceProvider::HOME);
    }

    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback()
    {
        $socialUser = Socialite::driver('facebook')->user();

        $user = User::query()
            ->where('email', $socialUser->getEmail())
            ->where('social_id', $socialUser->getId())
            ->where('social_provider', 'facebook')
            ->first();

        if ($user) {
            Auth::login($user, true);
            return redirect(RouteServiceProvider::HOME);
        }

        $user = User::create([
            'first_name' => $socialUser->getNickname() ?? $socialUser->getName(),
            'last_name' => '',
            'email' => $socialUser->getEmail(),
            'avatar' => $socialUser->getAvatar(),
            'social_provider' => 'facebook',
            'social_id' => $socialUser->getId(),
            'password' => Hash::make($socialUser->getName()),
        ]);

        $user->assignRole('user');

        Auth::login($user);

        event(new Registered($user));

        return redirect(RouteServiceProvider::HOME);
    }
}
