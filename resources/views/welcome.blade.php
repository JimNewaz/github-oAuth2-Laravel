<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Github oAuth</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite('resources/css/app.css')
        
    </head>
    <body class="antialiased">        
        <div class="relative sm:flex sm:justify-center min-h-screen sm:items-center bg-center bg-dots-darker bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                    @auth
                        <a href="{{ url('/github-profile') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>
    
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
    
            <div class="mx-auto p-6 lg:p-8">
                <div class="flex justify-center">
                    <a href="{{ url('/auth/github') }}" class="w-72 h-72 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex flex-col items-center justify-center motion-safe:hover:scale-[1.01] transition-all duration-250 group hover:outline-custom">
                        <div class="h-24 w-24 bg-gray-50 dark:bg-gray-800/20 flex items-center justify-center rounded-full mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-16 h-16 text-gray-900 dark:text-white">
                                <path fill-rule="evenodd" d="M12 0C5.373 0 0 5.373 0 12a12 12 0 008.207 11.427c.6.11.793-.261.793-.579 0-.286-.011-1.243-.017-2.253-3.338.727-4.042-1.588-4.042-1.588-.546-1.384-1.333-1.754-1.333-1.754-1.09-.746.083-.73.083-.73 1.204.085 1.837 1.236 1.837 1.236 1.07 1.835 2.807 1.304 3.491.996.108-.774.418-1.305.76-1.606-2.664-.303-5.466-1.332-5.466-5.93 0-1.31.467-2.382 1.235-3.222-.123-.303-.535-1.524.118-3.176 0 0 1.007-.323 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.046.138 3.005.404 2.292-1.553 3.297-1.23 3.297-1.23.655 1.652.243 2.873.12 3.176.77.84 1.234 1.912 1.234 3.222 0 4.61-2.805 5.624-5.476 5.922.43.37.813 1.102.813 2.222 0 1.605-.015 2.899-.015 3.293 0 .322.19.694.8.576A12 12 0 0024 12c0-6.627-5.373-12-12-12z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white ml-4">Login with GitHub</h2>
                    </a>
                </div>
                
                            
                <div class="flex justify-center mt-16 px-0 sm:items-center">
                    <div class="text-center text-sm text-gray-500 dark:text-gray-400"></div>
                    <div class="flex justify-center text-sm text-gray-500 dark:text-gray-400">
                        Developed by: <a href="https://www.laravel.com" class="hover:underline">Sayed Newaz</a>
                    </div>
                </div>
            </div>
        </div> 
    </body>
</html>
