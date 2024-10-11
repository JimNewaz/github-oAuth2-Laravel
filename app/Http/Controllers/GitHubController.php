<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GitHubController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('github')->user();
        $token = $user->token;

        
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.github.com/user/repos', [
            'headers' => [
                'Authorization' => 'token ' . $token,
                'Accept'        => 'application/vnd.github.v3+json',
            ],
        ]);

        $repositories = json_decode($response->getBody());

        return view('profile', [
            'user' => $user,
            'repositories' => $repositories,
        ]);
    }


    public function profile(){
        $user = session('github_user');
        $repositories = session('repositories');

        if (!$user) {
            return redirect('/auth/github');
        }

        return view('profile', [
            'user' => $user,
            'repositories' => $repositories,
        ]);
    }
}
