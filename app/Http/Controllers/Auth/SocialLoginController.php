<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{

    public function socialLoginRedirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function socialLoginCallback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        $user = User::query()->where('email', $socialUser->getEmail())->first();

        if ($user) {
            if ($user->social_provider == $provider && $user->social_id == $socialUser->getId()) {
                Auth::login($user);
                return redirect(RouteServiceProvider::HOME);
            }

            return redirect('/login')->withErrors(['email' => 'Email taken']);
        }

        $user = User::create([
            'first_name' => $socialUser->getNickname() ?? $socialUser->getName(),
            'last_name' => '',
            'email' => $socialUser->getEmail(),
            'avatar' => $socialUser->getAvatar(),
            'social_provider' => $provider,
            'social_id' => $socialUser->getId(),
            'password' => Hash::make($socialUser->getName()),
        ]);

        $user->assignRole('user');

        Auth::login($user);

        event(new Registered($user));

        return redirect(RouteServiceProvider::HOME);
    }
}
