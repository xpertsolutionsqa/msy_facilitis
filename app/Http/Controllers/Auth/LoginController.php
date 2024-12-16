<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client as ModelsClient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Client;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function show(Request $request)
    {
        if (auth()->check()) {

            return redirect()->route('facilities');
        }
        if (auth()->guard('client')->check()) {
            return redirect()->route('facilities');
        }


        return view('login');
    }


    public function login(Request $request)
    {

        $response = $request->input('g-recaptcha-response');
        $captchaSecret = env('RECAPTCHA_SECRET_KEY');

        $verificationResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $captchaSecret,
            'response' => $response,
        ]);

        $body = $verificationResponse->json();
        $url = $request->input('redirecturl') ?? "";
       
            //if ($body['success']) {
            if (1 == 1) {
            $username = $request->input('username');
            $user = User::where('username', $username)->first();

            if ($user) {
                Auth::login($user);
                if ($url == '') {
                    if ($user->level == 3) {
                        return redirect()->intended('/bookings');
                    }
                    if ($user->level == 6) {
                        return redirect()->intended('/dashboard');
                    }
                    return redirect()->intended('/facilities');
                } else {
                    if (preg_match('/^https?:\/\//', $url)) {
                        return redirect($url);
                    } else {
                        return redirect()->intended(route($url));
                    } 
                }


                return redirect()->back()->withInput(['url', $url])->withErrors(['login' => 'Invalid credentials']);
            }


            $client = ModelsClient::where('username', $username)->first();
            if ($client) {
                $usercredentials = [
                    'username' => $request['username'],
                    'password' => $request['password'],
                ];


                //Auth::guard('client')->login($client);
                if (Auth::guard('client')->attempt($usercredentials)) {

                    if ($url == '') {
                        return redirect()->intended('/facilities');
                    } else {
                        if (preg_match('/^https?:\/\//', $url)) {
                            return redirect($url);
                        } else {
                            return redirect()->intended(route($url));
                        } 
                    }
                }
            }


            return redirect()->back()->withInput(['url', $url])->withErrors(['login' => 'Invalid credentials']);
        } else {
            return redirect()->back()->withInput(['url', $url])->withErrors(['reCAPTCHA' => 'worng']);
        }
    }

    public function redirectToProvider()
    {
        $state = (string) Str::uuid();

        $query = http_build_query([

            'client_id' => env('PASSPORT_CLIENT_ID'),
            'response_type' => 'code',
            'redirect_uri' => env('PASSPORT_REDIRECT_URI'),
            'scope' => 'openid profile',
            'state' => $state,
            'ui_locales' => 'en',

        ]);

        $query = str_replace('%20', '+', $query);
        return redirect(env('PASSPORT_AUTHORIZATION_URL') . '?' . $query);
    }

    public function handleProviderCallback(Request $request)
    {
        $http = new HttpClient;
        $response = $http->post(env('PASSPORT_TOKEN_URL'), [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => env('PASSPORT_CLIENT_ID'),
                'client_secret' => env('PASSPORT_CLIENT_SECRET'),
                'redirect_uri' => env('PASSPORT_REDIRECT_URI'),
                'code' => $request->code,
            ],
        ]);

        $tokens = json_decode((string) $response->getBody(), true);
        
        //  dd("Code:".$request->code ."   Token:  ".$tokens['access_token'] );

        $userResponse = $http->get(env('PASSPORT_RESOURCE_OWNER_DETAILS_URL'), [
            'headers' => [
                'Authorization' => 'Bearer ' . $tokens['access_token'],
            ],
        ]);
        $user = json_decode((string) $userResponse->getBody(), true);

        dd($user);
        // $authUser = User::updateOrCreate(
        //     [
        //         'openid_id' => $user['sub'],
        //     ],
        //     [
        //         'name' => $user['name'],
        //         'email' => $user['email'],
        //     ]
        // );
        //Auth::login($authUser);
        //return redirect('/facilites');
    }
}
