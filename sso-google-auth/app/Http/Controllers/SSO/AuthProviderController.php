<?php

namespace App\Http\Controllers\SSO;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class AuthProviderController extends Controller
{
    public function redirectToProvider(String $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(String $provider = 'google')
    {
        try {
            $userProviders = Socialite::driver($provider)->user();
            $user          = User::where('email', $userProviders->getEmail())->first();

            if($user !== null){
                auth()->login($user, true);
                return redirect()->route('home');
            }else{
                $createNewUser = User::create([
                    'email'             => $userProviders->getEmail(),
                    'name'              => $userProviders->getName(),
                    'password'          => 0,
                    'email_verified_at' => now()
                ]);
                auth()->login($createNewUser, true);
                return redirect()->route('home');
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->route('login');
        }
    }
}
