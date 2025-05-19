<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    {{-- <bootstrap> --}}
    <script src="https://kit.fontawesome.com/3d7900bfe9.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    @vite( ['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    {{-- </bootstrap> --}}
    <title>{{env('APP_NAME')}}</title>
    
    <link rel="stylesheet" href="{{asset('build/assets/style.css')}}">
    @yield('style')
    <style>
    /* ألوان رئيسية */
    :root {
        --primary: #6C63FF; /* أزرق بنفسجي */
        --secondary: #FF9F43; /* برتقالي فاتح */
        --accent: #FF6B6B; /* أحمر مخملي */
        --bg: #F8F9FA;
        --card-bg: rgba(255, 255, 255, 0.95);
    }

    .navbar-nav .nav-link {
        position: relative;
        transition: color 0.3s ease;
        font-weight: 500;
    }

    .navbar-nav .nav-link i {
        margin-right: 8px;
        transition: transform 0.3s ease;
    }

    /* تأثير عند التمرير على العناصر */
    .navbar-nav .nav-item:hover .nav-link {
        color: var(--primary);
    }

    .navbar-nav .nav-item:hover .nav-link i {
        transform: translateX(4px);
    }

    /* تنسيق العنصر النشط */
    .navbar-nav .nav-item.active .nav-link,
    .navbar-nav .nav-item.active .nav-link i {
        color: var(--primary);
        font-weight: bold;
        transition: all 0.3s ease;
    }

    /* خط سفلي جذاب للعنصر النشط */
    .navbar-nav .nav-item.active .nav-link::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(to right, var(--primary), var(--secondary));
        border-radius: 2px;
    }
</style>
</head>
<body dir="rtl" style="text-align :right">
    
    <nav
        class="navbar navbar-expand-md navbar-light bg-light"
    >
        <div class="container">
            <a class="navbar-brand bg-indigo-700" href="{{ route('main') }}">footube</a>
            <button
                class="navbar-toggler d-lg-none"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapsibleNavId"
                aria-controls="collapsibleNavId"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item {{ request()->is('/')? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('main') }}"><i class="fa fa-home"></i> الرئيسية</a>
                    </li>
                    @auth
                    <li class="nav-item {{ request()->is('history')? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('History') }}"><i class="fa fa-history"></i> السجل</a>
                    </li>
                    <li class="nav-item {{ request()->is('videos/create*')? 'active' : '' }}">
                        <a class="nav-link " href="{{ route('videos.create') }}"><i class="fa fa-upload"></i> رفع فيديو</a>
                    </li>
                    <li class="nav-item {{ request()->is('videos')? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('videos.index') }}"><i class="fa fa-film"></i> فيديوهاتي</a>
                    </li>
                    @endauth
                    <li class="nav-item {{ request()->is('channel*')? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('channel.index') }}"><i class="fa fa-tv"></i> قنوات</a>
                    </li>
                </ul>


                <ul class="navbar-nav mx-auto ">
                    @guest
                        <li class="nav-item mt-2">
                            <a href="{{route('login')}}" class="nav-link">{{__('Login')}}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item mt-2">
                                <a href="{{route('register')}}" class="nav-link">{{__('Register')}}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown justify-content-left mt-2">
                           <a href="" class="nav-link" data-bs-toggle="dropdown" id="navbarDropdown">
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full">
                            </a> 
                            
                            <div  aria-labelledby="navbarDropdown" class="dropdown-menu dropdown-menu-left px-2 text-right mt-2">
                                <div class="p-3  border-t border-gray-200">
                                    <div class="flex items-center px-4">
                                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                            <div class="shrink-0 me-3">
                                                <img class="size-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                            </div>
                                        @endif
                        
                                        <div>
                                            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                                        </div>
                                    </div>
                        
                                    <div class="mt-3 space-y-1">
                                        <!-- Account Management -->
                                        <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                                            {{ __('Profile') }}
                                        </x-responsive-nav-link>
                                        @can('updateVid')
                                        <x-responsive-nav-link href="{{ route('admin.index') }}" :active="request()->routeIs('admin.index')">
                                            {{ __('الأدارة') }}
                                        </x-responsive-nav-link>
                                        @endcan
                                        

                                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                            <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                                                {{ __('API Tokens') }}
                                            </x-responsive-nav-link>
                                        @endif
                        
                                        <!-- Authentication -->
                                        <form method="POST" action="{{ route('logout') }}" x-data>
                                            @csrf
                        
                                            <x-responsive-nav-link href="{{ route('logout') }}"
                                                           @click.prevent="$root.submit();">
                                                {{ __('Log Out') }}
                                            </x-responsive-nav-link>
                                        </form>
                        
                                        <!-- Team Management -->
                                        @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                                            <div class="border-t border-gray-200"></div>
                        
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ __('Manage Team') }}
                                            </div>
                        
                                            <!-- Team Settings -->
                                            <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                                                {{ __('Team Settings') }}
                                            </x-responsive-nav-link>
                        
                                            @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                                <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                                                    {{ __('Create New Team') }}
                                                </x-responsive-nav-link>
                                            @endcan
                        
                                            <!-- Team Switcher -->
                                            @if (Auth::user()->allTeams()->count() > 1)
                                                <div class="border-t border-gray-200"></div>
                        
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    {{ __('Switch Teams') }}
                                                </div>
                        
                                                @foreach (Auth::user()->allTeams() as $team)
                                                    <x-switchable-team :team="$team" component="responsive-nav-link" />
                                                @endforeach
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endguest
                    
                    
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        @if (session()->has('success'))
            <div class="p-3 mb-2 bg-success text-white rounded mx-auto col-8">
                <span class="text-center">{{session('success')}}</span>
            </div>
        @endif


        @yield('content')
    </main>
   
    @yield('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

</body>
</html>