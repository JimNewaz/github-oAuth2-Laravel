
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Github oAuth</title>

    <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/styles/tailwind.css">
    <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />    

    @vite('resources/css/app.css')
</head>
<body>
    




    
<main class="profile-page">    
    <section class="relative block h-500-px"> 
        <div class="absolute top-0 w-full h-full bg-center bg-cover bg-dots-darker bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900">
            <span id="blackOverlay" class="w-full h-full absolute opacity-50 bg-black"></span>
        </div>
        <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden h-70-px"
            style="transform: translateZ(0px)">
            <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
                version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                <polygon class="text-blueGray-200 fill-current" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </section>
    
    <section class="relative py-16 bg-blueGray-200">
        <div class="container mx-auto px-4 lg:px-16">
            <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg -mt-64">
                <div class="px-6">
                    <div class="flex flex-wrap justify-center">
                        <div class="w-full lg:w-3/12 px-4 lg:order-2 flex justify-center">
                            <div class="relative">
                                <img alt="..." src="{{ $user->avatar }}"
                                    class="shadow-xl rounded-full h-auto align-middle border-none absolute -m-16 -ml-20 lg:-ml-16 max-w-150-px">
                            </div>
                        </div>
                        <div class="w-full lg:w-4/12 px-4 lg:order-3 lg:self-center">
                            <div class="py-4 px-3 mt-32 sm:mt-0">
                                <div class="mb-2 text-blueGray-600">   
                                    <p>
                                        <i class="fas fa-map-marker-alt mr-2 text-lg text-blueGray-400"></i>
                                        {{ $user->user['location'] }}     
                                    </p>                         
                                    <p>
                                        <i class="fas fa-envelope text-lg mr-2 text-blueGray-400 "></i>
                                        {{ $user->email }}
                                    </p>                                    
                                </div>                                  
                            </div>   
                                                    
                        </div>
                        <div class="w-full lg:w-4/12 px-4 lg:order-1">
                            <div class="flex justify-center py-4 lg:pt-4 pt-8">
                                <div class="mr-4 p-3 text-center">
                                    <span class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">
                                        {{ $totalRepos }}
                                    </span>
                                    <span class="text-sm text-blueGray-400">Repositories</span>
                                </div>
                                <div class="mr-4 p-3 text-center">
                                    <span class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">
                                        {{ $totalStars }}
                                    </span>
                                    <span class="text-sm text-blueGray-400">Stars</span>
                                </div>
                                <div class="lg:mr-4 p-3 text-center">
                                    <span class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">
                                        {{ $totalCommits }}
                                    </span>
                                    <span class="text-sm text-blueGray-400">Commits</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-12">
                        <h3 class="text-4xl font-semibold leading-normal mb-2 text-blueGray-700 mb-2">
                            {{ $user->name }}
                        </h3>
                        <div class="text-sm leading-normal mt-0 mb-2 text-blueGray-400 font-bold uppercase">
                            {{ $user->user['bio'] }}
                        </div>    

                        <p> <a href="{{ $user->user['html_url'] }}" target="_blank">View GitHub Profile</a></p>                                       
                    </div>
                    <div class="mt-10 py-10 border-t border-blueGray-200 text-center">
                        <div class="flex flex-wrap justify-center">
                            <div class="w-full lg:w-9/12 px-4">
                                <p class="mb-4 text-lg leading-relaxed text-blueGray-700">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Logout</a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                    
                                    
                                </p>                                
                            </div>
                        </div>
                    </div>

                    
                    
                </div>


                <div class="flex flex-col md:flex-row p-5">
                
                    <div class="w-full md:w-4/12 p-2 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-lg mr-4">
                        <h3 class="text-xl font-semibold mb-4">Search Filters</h3>
                        
                        <form method="POST" action="">
                            @csrf

                            <!-- Search by Repository Name -->
                            <div class="mb-4">
                                <label for="search" class="block text-sm font-medium text-gray-700">Search Repositories</label>
                                <input type="text" id="search" name="search" value="{{ request('search') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                        
                            <!-- Filter by Language -->
                            <div class="mb-4">
                                <label for="language" class="block text-sm font-medium text-gray-700">Language</label>
                                <select id="language" name="language" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2">
                                    <option value="">All Languages</option>
                                    @foreach ($languages as $lang)
                                        <option value="{{ $lang }}" {{ request('language') == $lang ? 'selected' : '' }}>{{ $lang }}</option>
                                    @endforeach
                                </select>                            
                            </div>
                        
                            <!-- Filter by Stars -->
                            <div class="mb-4">
                                <label for="stars" class="block text-sm font-medium text-gray-700">Minimum Stars</label>
                                <input type="number" id="stars" name="stars" value="{{ request('stars') }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                        
                            <!-- Filter by Date Range -->
                            <div class="mb-4">
                                <label for="date_range" class="block text-sm font-medium text-gray-700">Updated Since</label>
                                <input type="date" id="date_range" name="date_range" value="{{ request('date_range') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                        
                            <!-- Filter by Repository Type -->
                            <div class="mb-4">
                                <label for="type" class="block text-sm font-medium text-gray-700">Repository Type</label>
                                <select id="type" name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2">
                                    <option value="">All Types</option>
                                    <option value="fork" {{ request('type') == 'fork' ? 'selected' : '' }}>Forked</option>
                                    <option value="source" {{ request('type') == 'source' ? 'selected' : '' }}>Original</option>
                                </select>
                            </div>
                        
                            <!-- Submit Button -->
                            <button type="submit" class="px-4 py-2 bg-dark-500 text-white rounded-lg shadow hover:bg-drak-600 bg-custom">
                                Apply Filters
                            </button>
                        </form>
                    </div>
                    
                    
                    <div class="w-full md:w-8/12 p-2">
                        <div class="grid grid-cols-1 gap-6">
                            @foreach($repositories as $repo)
                            <div class="w-full p-2 bg-custom rounded-lg  dark:shadow-none flex flex-col items-center justify-center motion-safe:hover:scale-[1.01] transition-all duration-250 group hover:outline-custom mb-2">
                                <div class="h-20 w-full flex flex-col justify-center mb-1">
                                    <h2 class="text-xl font-bold uppercase text-white">{{ $repo->name }}</h2>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $repo->description ?? 'No description available.' }}</p>
                                </div>
            
                                <div class="flex text-right mt-2">                                    
                                    <div class="flex space-x-1 mr-3">
                                        <i class="fa fa-star text-yellow-500"></i>
                                        <span class="text-smtext-gray-500 dark:text-gray-400">{{ $repo->stargazers_count }}</span>
                                    </div>
                                    
                                    <div class="flex space-x-1 mr-3">
                                        <i class="fa fa-code-branch text-white"></i>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $repo->forks_count }}</span>
                                    </div>
                                </div>
            
                                
                                <div class="mt-3">
                                    @if (!empty($repo->languages))
                                        @foreach ($repo->languages as $language => $bytes)
                                            <span class="bg-gray-100 text-gray-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300 p-2 mr-2 mt-2" style="padding: 0.3rem">
                                                {{ $language }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="inline-block rounded-full px-2 py-1 text-xs font-semibold bg-gray-500 text-white">-</span>
                                    @endif
                                </div>
                                
                            </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="flex justify-center mt-4">
                            <nav class="inline-flex rounded-md shadow">
                                <!-- Previous Button -->
                                <a href="{{ $currentPage > 1 ? route('profile', ['page' => $currentPage - 1]) : '#' }}"
                                    class="px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 {{ $currentPage == 1 ? 'cursor-not-allowed opacity-50 pointer-events-none' : '' }}">
                                    Previous
                                </a>
                        
                                <!-- Page Numbers -->
                                @for ($i = 1; $i <= $totalPages; $i++)
                                    <a href="{{ route('profile', ['page' => $i]) }}"
                                        class="px-4 py-2 border-t border-b border-r border-gray-300 text-sm font-medium text-gray-700 {{ $currentPage == $i ? 'bg-blue-500 text-white' : 'bg-white hover:bg-gray-50' }}">
                                        {{ $i }}
                                    </a>
                                @endfor
                        
                                <!-- Next Button -->
                                <a href="{{ $currentPage < $totalPages ? route('profile', ['page' => $currentPage + 1]) : '#' }}"
                                    class="px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 {{ $currentPage == $totalPages ? 'cursor-not-allowed opacity-50 pointer-events-none' : '' }}">
                                    Next
                                </a>
                            </nav>
                        </div>
                        
                        
                    </div>              
                    
                </div>
                
            </div>
        </div>

        
        <footer class="relative bg-blueGray-200 pt-8 pb-6 mt-8">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap items-center md:justify-between justify-center">
                    <div class="w-full md:w-6/12 px-4 mx-auto text-center">
                        <div class="text-sm text-blueGray-500 font-semibold py-1">
                            {{-- Made with <a href="https://www.creative-tim.com/product/notus-js"
                                class="text-blueGray-500 hover:text-gray-800" target="_blank">Notus JS</a> by <a
                                href="https://www.creative-tim.com" class="text-blueGray-500 hover:text-blueGray-800"
                                target="_blank"> Creative Tim</a>. --}}
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </section>
</main>

</body>
</html>