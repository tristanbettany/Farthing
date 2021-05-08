<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use League\OAuth2\Client\Provider\Github;
use Exception;
use HttpException;

class GithubLoginController extends Controller
{
    public function getIndex(Request $request)
    {
        $provider = new Github([
            'clientId' => env('GITHUB_CLIENT_ID'),
            'clientSecret' => env('GITHUB_CLIENT_SECRET'),
            'redirectUri' => env('GITHUB_CALLBACK_URL'),
        ]);

        if ($request->has('code') === false) {
            $url = $provider->getAuthorizationUrl(); // this needs to be ran before get state
            Session::put('state', $provider->getState());

            return redirect($url);
        }

        $oauth2State = Session::get('state');

        if (
            $request->has('state') === false
            || $request->get('state') !== $oauth2State
        ) {
            Session::forget('state');

            throw new HttpException('Invalid OAuth State');
        }

        try {
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $request->get('code'),
            ]);

            $user = $provider->getResourceOwner($token);
        } catch (Exception $e) {
            throw new HttpException('Unable to retrieve access token');
        }

        $userModel = User::where('email', $user->getEmail())
            ->where('oauth_id', $user->getId())
            ->first();

        if (empty($userModel) === true) {
            $userModel = User::create([
                'name' => $user->getNickname(),
                'email' => $user->getEmail(),
                'password' => Hash::make(uniqid()),
                'oauth_id' => $user->getId(),
            ]);
        }

        Auth::login($userModel);

        return redirect('/dashboard');
    }
}
