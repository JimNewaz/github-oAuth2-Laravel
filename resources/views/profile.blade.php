<link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/styles/tailwind.css">
<link rel="stylesheet"
    href="https://demos.creative-tim.com/notus-js/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
    @vite('resources/css/app.css')
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
        <div class="container mx-auto px-4">
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
                    </div>
                    <div class="mt-10 py-10 border-t border-blueGray-200 text-center">
                        <div class="flex flex-wrap justify-center">
                            <div class="w-full lg:w-9/12 px-4">
                                <p class="mb-4 text-lg leading-relaxed text-blueGray-700">
                                    
                                </p>                                
                            </div>
                        </div>
                    </div>

                    
                    <p><strong>Profile URL:</strong> <a href="{{ $user->user['html_url'] }}"
                            target="_blank">View GitHub Profile</a></p>
                </div>

                <div class="grid grid-cols-5 gap-3">
                    <div class="bg-blue-100">1st col</div>
                    <div class="bg-red-100 col-span-4">2nd col</div>
                  </div>
            </div>

            <div class="flex flex-wrap">
                
                <div class="w-full md:w-3/12 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-4">Search Filters</h3>
                    
                    
                    <div class="mb-4">
                        <label for="search" class="block text-sm font-medium text-gray-700">Search Repositories</label>
                        <input type="text" id="search" name="search" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
        
                    <div class="mb-4">
                        <label for="language" class="block text-sm font-medium text-gray-700">Language</label>
                        <select id="language" name="language" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">All Languages</option>
                            <option value="JavaScript">JavaScript</option>
                            <option value="PHP">PHP</option>
                            <option value="Python">Python</option>
                            
                        </select>
                    </div>       
                </div>
        
                
                <div class="w-full md:w-9/12 p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($repositories as $repo)
                        <div class="w-full p-4 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex flex-col items-center justify-center motion-safe:hover:scale-[1.01] transition-all duration-250 group hover:outline-custom mb-5">
                            <div class="h-24 w-full flex flex-col items-center justify-center text-center mb-4">
                                <h2 class="text-xl font-bold">{{ $repo->name }}</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $repo->description ?? 'No description available.' }}</p>
                            </div>
        
                            <div class="flex items-center space-x-2 mt-4">
                                
                                <div class="flex items-center space-x-1">
                                    <i class="fa fa-star text-yellow-500"></i>
                                    <span>{{ $repo->stargazers_count }}</span>
                                </div>
        
                                
                                <div class="flex items-center space-x-1">
                                    <i class="fa fa-code-branch text-gray-500"></i>
                                    <span>{{ $repo->forks_count }}</span>
                                </div>
                            </div>
        
                            
                            <div class="mt-2">
                                @if ($repo->language)
                                    <span class="inline-block rounded-full px-2 py-1 text-xs font-semibold bg-{{ strtolower($repo->language) }}-500 text-white">
                                        {{ $repo->language }}
                                    </span>
                                @else
                                    <span class="inline-block rounded-full px-2 py-1 text-xs font-semibold bg-gray-500 text-white">Unknown</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
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
