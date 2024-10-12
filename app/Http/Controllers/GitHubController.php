<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GitHubController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('github')->stateless()->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        try {
            $user = Socialite::driver('github')->stateless()->user();
            Log::info('User retrieved from GitHub: ' . json_encode($user));
        } catch (\Exception $e) {
            Log::error('Error retrieving GitHub user: ' . $e->getMessage());
            return redirect('/login')->withErrors('GitHub login failed.');
        }

        $token = $user->token;

        // Handle user creation and authentication
        $existinguser = User::where('github_email', $user->email)->first();
        if (!$existinguser) {
            $existinguser = User::create([
                'github_id' => $user->id,
                'github_name' => $user->name,
                'github_nickname' => $user->nickname,
                'github_email' => $user->email,
                'github_avatar' => $user->avatar,
                'github_token' => $user->token,
                'github_refresh_token' => $user->refreshToken,
                'password' => bcrypt('github'),
            ]);
        }
        Auth::login($existinguser);

        // Fetch all repositories, not just the first page
        $repositories = [];
        $perPage = 100; 
        $page = 1;
        $client = new \GuzzleHttp\Client();

        do {
            $response = $client->request('GET', 'https://api.github.com/user/repos', [
                'headers' => [
                    'Authorization' => 'token ' . $token,
                    'Accept'        => 'application/vnd.github.v3+json',
                ],
                'query' => [
                    'page' => $page,
                    'per_page' => $perPage,
                ],
            ]);

            $fetchedRepos = json_decode($response->getBody(), true);
            $repositories = array_merge($repositories, $fetchedRepos); 
            $page++;
        } while (count($fetchedRepos) === $perPage); 

        // Calculate total stars and commits, fetch languages
        $totalStars = array_reduce($repositories, function ($carry, $repo) {
            return $carry + $repo['stargazers_count'];
        }, 0);

        $totalCommits = 0;
        foreach ($repositories as &$repo) {
            if (isset($repo['owner']['login']) && isset($repo['name'])) {
                try {
                    // Fetch commits for each repository
                    $commitResponse = $client->request('GET', 'https://api.github.com/repos/'.$repo['owner']['login'].'/'.$repo['name'].'/commits', [
                        'headers' => [
                            'Authorization' => 'token ' . $token,
                            'Accept'        => 'application/vnd.github.v3+json',
                        ],
                    ]);

                    $commits = json_decode($commitResponse->getBody(), true);
                    $totalCommits += count($commits);

                    // Fetch all languages for each repository
                    $languageResponse = $client->request('GET', 'https://api.github.com/repos/'.$repo['owner']['login'].'/'.$repo['name'].'/languages', [
                        'headers' => [
                            'Authorization' => 'token ' . $token,
                            'Accept'        => 'application/vnd.github.v3+json',
                        ],
                    ]);

                    $repo['languages'] = json_decode($languageResponse->getBody(), true);
                    
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    if ($e->getCode() == 409) { 
                        continue;
                    } else {
                        throw $e;
                    }
                }
            }
        }

        // Store everything in the session
        session([
            'github_user' => $user,
            'repositories' => $repositories, 
            'totalStars' => $totalStars,
            'totalCommits' => $totalCommits,
            'totalRepos' => count($repositories),
            'totalPages' => ceil(count($repositories) / 10), 
            'languages' => $this->getAvailableLanguages($repositories),
        ]);

        // Log::info('GitHub user data saved in session: ' . json_encode(session()->all()));
        
        return view('profile', [
            'user' => $user,
            'repositories' => array_slice($repositories, 0, 10), 
            'totalRepos' => count($repositories),
            'totalStars' => $totalStars,
            'totalCommits' => $totalCommits,
            'currentPage' => 1,
            'totalPages' => ceil(count($repositories) / 10),
            'languages' => $this->getAvailableLanguages($repositories),
        ]);
    }


    
    public function profile(Request $request)
    {
        $user = session('github_user');
        $repositories = session('repositories');
        $totalStars = session('totalStars');
        $totalCommits = session('totalCommits');
        $totalRepos = session('totalRepos');
        $totalPages = session('totalPages');
        $languages = session('languages');
        
        if (!$user) {
            return redirect('/auth/github');
        }

        $searchTerm = $request->input('search');
        $languageFilter = $request->input('language');
        $starsFilter = $request->input('stars');
        $dateRangeFilter = $request->input('date_range');
        $typeFilter = $request->input('type');

        // Filter repositories based on search criteria
        if ($searchTerm) {
            $repositories = array_filter($repositories, function($repo) use ($searchTerm) {
                return stripos($repo['name'], $searchTerm) !== false; 
            });
        }

        if ($languageFilter) {
            $repositories = array_filter($repositories, function($repo) use ($languageFilter) {
                return isset($repo['languages'][$languageFilter]);
            });
        }

        if ($starsFilter) {
            $repositories = array_filter($repositories, function($repo) use ($starsFilter) {
                return $repo['stargazers_count'] >= $starsFilter;
            });
        }

        if ($dateRangeFilter) {
            $repositories = array_filter($repositories, function($repo) use ($dateRangeFilter) {
                return strtotime($repo['updated_at']) >= strtotime($dateRangeFilter);
            });
        }

        // Calculate total number of filtered repositories
        $totalFilteredRepos = count($repositories);

        // Determine total pages based on filtered results
        $perPage = 10; 
        $totalPages = ceil($totalFilteredRepos / $perPage); // Update total pages

        // Get current page
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;

        // Slice the repositories for pagination
        $repositories = array_slice($repositories, $offset, $perPage);

        return view('profile', [
            'user' => $user,
            'repositories' => $repositories,
            'totalStars' => $totalStars,
            'totalCommits' => $totalCommits,
            'totalRepos' => $totalRepos,
            'totalPages' => $totalPages, // Pass the updated total pages
            'languages' => $languages,
            'currentPage' => $currentPage,
            'search' => $searchTerm,
            'language' => $languageFilter,
            'stars' => $starsFilter,
            'date_range' => $dateRangeFilter,
            'type' => $typeFilter,
        ]);
    }



    

    public function logout()
    {        
        Auth::logout();
        session()->forget('github_user');
        session()->forget('repositories');
        session()->flush();
        
        return redirect('/')->with('message', 'You have been logged out.');
    }



    private function getAvailableLanguages($repositories)
    {
        $languages = [];

        foreach ($repositories as $repo) {
            if (isset($repo['language']) && !in_array($repo['language'], $languages)) {
                $languages[] = $repo['language'];
            }
        }
        
        return $languages;
    }

}
