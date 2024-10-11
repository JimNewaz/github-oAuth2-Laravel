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
        $user = Socialite::driver('github')->stateless()->user();
        $token = $user->token;

        // Fetch the user's repositories
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.github.com/user/repos', [
            'headers' => [
                'Authorization' => 'token ' . $token,
                'Accept'        => 'application/vnd.github.v3+json',
            ],
        ]);

        $repositories = json_decode($response->getBody());

        // total number of repositories
        $totalRepos = count($repositories);

        // total number of stars
        $totalStars = array_reduce($repositories, function ($carry, $repo) {
            return $carry + $repo->stargazers_count;
        }, 0);

        // total number of commits
        $totalCommits = 0;
        foreach ($repositories as $repo) {            
            if (isset($repo->owner->login) && isset($repo->name)) {
                try {
                    // Fetch commits for each repository
                    $commitResponse = $client->request('GET', 'https://api.github.com/repos/'.$repo->owner->login.'/'.$repo->name.'/commits', [
                        'headers' => [
                            'Authorization' => 'token ' . $token,
                            'Accept'        => 'application/vnd.github.v3+json',
                        ],
                    ]);
                    
                    $commits = json_decode($commitResponse->getBody());
                    $totalCommits += count($commits);
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    // Handle 409 Conflict for empty repositories (or other errors)
                    if ($e->getCode() == 409) {                        
                        continue;
                    } else {                        
                        throw $e;
                    }
                }
            }
        }

        
        return view('profile', [
            'user' => $user,
            'repositories' => $repositories,
            'totalRepos' => $totalRepos,
            'totalStars' => $totalStars,
            'totalCommits' => $totalCommits,
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

    public function logout(){
        session()->forget('github_user');
        session()->forget('repositories');
        
        return redirect('/')->with('message', 'You have been logged out.');
    }
}
