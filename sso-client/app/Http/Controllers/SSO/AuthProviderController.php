<?php

namespace App\Http\Controllers\SSO;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class AuthProviderController extends Controller
{
    public function oauthAuthorization(Request $request)
    {
        // dd(config('sso.url_client_callback'));
        $request->session()->put('state', $state = Str::random(40));
        $query = http_build_query([
            'client_id' => 1,
            'redirect_uri' => "http://127.0.0.1:8001/callback",
            'response_type' => 'code',
            'scope' => 'view-user',
            'state' => $state
        ]);
        return redirect(config('sso.url_authorize').'?'.$query);
    }

    public function callback(Request $request)
    {
        $state = $request->session()->pull("state");

        try {

            $response = Http::asForm()->post(config('sso.url_token'),[
                'grant_type' => 'authorization_code',
                'client_id' => '1',
                'client_secret' => 'NHwEFeO34X7LcN06RlS4hh9N3ncKHDboIjIxTiMp',
                'redirect_uri' => config('sso.url_client_callback'),
                'code' => $request->code
            ]);

            request()->session()->put($response->json());

            return redirect()->route('claim.users');

        } catch (\Throwable $th) {

            Log::error($th->getMessage);

            return redirect()->back()->with('status', $th->getMessage());
        }
    }

    public function claimUserAccount(Request $request)
    {
        $accessToken = request()->session()->get('access_token');
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => "Bearer ". $accessToken
            ])->get(config('sso.url_claim_user'));
            if($response->successful()){

                $userProviders = $response->json();

                if($userProviders){

                    $user  = User::where('email', $userProviders['email'])->first();

                    if($user !== null){

                        auth()->login($user, true);
                        return redirect()->route('home');

                    }else{

                        $createNewUser = User::create([
                            'email'             => $userProviders['email'],
                            'name'              => $userProviders['name'],
                            'password'          => 0,
                            'email_verified_at' => now()
                        ]);

                        auth()->login($createNewUser, true);

                        return redirect()->route('home');
                    }
                }else{
                    return redirect()->back()->with('error', 'User Not Found');
                }
            }

        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}

