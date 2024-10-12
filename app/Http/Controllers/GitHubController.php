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

    public function handleProviderCallback(Request $request)
    {
        $user = Socialite::driver('github')->stateless()->user();
        $token = $user->token;

        // session([
        //     'github_user' => $user,
        //     'github_token' => $user->token,
        // ]);

        $page = $request->input('page', 1); 
        $perPage = 10; 
        
        // Fetch query parameters
        $search = $request->input('search');
        $language = $request->input('language');
        $stars = $request->input('stars');
        $dateRange = $request->input('date_range');
        $type = $request->input('type');

        // Fetch the user's repositories
        $client = new \GuzzleHttp\Client();
        $queryParams = [
            'page' => $page,
            'per_page' => $perPage
        ];

        // Add filters to query parameters
        if ($search) {
            $queryParams['q'] = $search;
        }
        if ($language) {
            $queryParams['language'] = $language;
        }
        if ($stars) {
            $queryParams['stars'] = '>=' . $stars;
        }
        if ($dateRange) {
            $queryParams['since'] = $dateRange;
        }
        if ($type) {
            $queryParams['type'] = $type;
        }

        // Fetch the user's repositories with pagination
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.github.com/user/repos', [
            'headers' => [
                'Authorization' => 'token ' . $token,
                'Accept'        => 'application/vnd.github.v3+json',
            ],
            'query' => [
                'page' => $page,      
                'per_page' => $perPage 
            ],
        ]);

        $repositories = json_decode($response->getBody());

        // Total number of stars
        $totalStars = array_reduce($repositories, function ($carry, $repo) {
            return $carry + $repo->stargazers_count;
        }, 0);

        // Total number of commits and fetch all languages for repositories
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

                    // Fetch all languages for each repository
                    $languageResponse = $client->request('GET', 'https://api.github.com/repos/'.$repo->owner->login.'/'.$repo->name.'/languages', [
                        'headers' => [
                            'Authorization' => 'token ' . $token,
                            'Accept'        => 'application/vnd.github.v3+json',
                        ],
                    ]);

                    $repo->languages = json_decode($languageResponse->getBody());
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    if ($e->getCode() == 409) {
                        continue;
                    } else {
                        throw $e;
                    }
                }
            }
        }

        // Determine total number of repositories for pagination
        $totalReposResponse = $client->request('GET', 'https://api.github.com/user', [
            'headers' => [
                'Authorization' => 'token ' . $token,
                'Accept'        => 'application/vnd.github.v3+json',
            ],
        ]);

        $totalRepos = json_decode($totalReposResponse->getBody())->public_repos; 
        $totalPages = ceil($totalRepos / $perPage); 

        session([
            'github_user' => $user,
            'repositories' => $repositories,
            'totalStars' => $totalStars,
            'totalCommits' => $totalCommits,
            'totalRepos' => $totalRepos,
            'totalPages' => $totalPages,
            'languages' => $this->getAvailableLanguages($repositories),
        ]);

        // return redirect('/profile');

        return view('profile', [
            'user' => $user,
            'repositories' => $repositories,
            'totalRepos' => $totalRepos,
            'totalStars' => $totalStars,
            'totalCommits' => $totalCommits,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'languages' => $this->getAvailableLanguages($repositories),
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

    // public function profile()
    // {
    //     $user = session('github_user');
    //     $repositories = session('repositories');
    //     $totalStars = session('totalStars');
    //     $totalCommits = session('totalCommits');
    //     $totalRepos = session('totalRepos');
    //     $totalPages = session('totalPages');
    //     $languages = session('languages');

    //     if (!$user) {
    //         return redirect('/auth/github');
    //     }

    //     return view('profile', [
    //         'user' => $user,
    //         'repositories' => $repositories,
    //         'totalStars' => $totalStars,
    //         'totalCommits' => $totalCommits,
    //         'totalRepos' => $totalRepos,
    //         'totalPages' => $totalPages,
    //         'languages' => $languages,
    //     ]);
    // }


    public function logout()
    {        
        session()->forget('github_user');
        session()->forget('repositories');
        session()->flush();
        
        return redirect('/')->with('message', 'You have been logged out.');
    }



    private function getAvailableLanguages($repositories)
    {
        $languages = [];

        foreach ($repositories as $repo) {
            if (isset($repo->language) && !in_array($repo->language, $languages)) {
                $languages[] = $repo->language;
            }
        }

        return $languages;
    }

}
