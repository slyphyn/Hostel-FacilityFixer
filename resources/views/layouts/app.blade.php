<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Hostel FacilityFixer') }}</title> --}}
    <title>Hostel FacilityFixer</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<style>
    #customAlertModal {
        background-color: rgb(0, 0, 0, 0.5);
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    #customAlertModal .modal-header {
        border-bottom: none; 
        background-color: #5699e1;
        color: #fff;
        /* border-radius: 10px 10px 0 0;  */
    }

    #customAlertModal .modal-body {
        padding: 20px;
        color: #333;
    }

    #customAlertModal .modal-footer {
        border-top: none; 
        background-color: #f8f9fa;
        text-align: center;
        /* border-radius: 0 0 10px 10px;  */
    }

    #customAlertModal .btn-primary {
        background-color: #007bff;
        color: #fff;
        /* border: 1px solid #5699e1; */
    }

    #customAlertModal .btn-primary:hover {
        background-color: #0056b3;
        border: 1px solid #5699e1;
    }
    .small-modal-header-footer {
        padding: 0.rem;
    }
</style>


<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Hostel FacilityFixer
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @auth
                        @if(auth()->user()->role === 1)
                            <!-- User -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('complaints.create') }}">Make Complaint</a>
                            </li>
                
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('complaints.index') }}">Complaints List</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('feedback.userIndex') }}">Feedback</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.news') }}">News</a>
                            </li>

                
                        @elseif(auth()->user()->role === 2)
                            <!-- Staff -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('staff.all') }}">Complaints</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('feedback.staffIndex') }}">Feedback</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('staff.news') }}">News</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('staff.report.show') }}">Report</a>
                            </li>
                            
                        @elseif(auth()->user()->role === 3)
                            <!-- Admin -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.index') }}">User Management</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    News
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('admin.news.create') }}">Create News</a>
                                    <a class="dropdown-item" href="{{ route('admin.news.index') }}">View News</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.report.show') }}">Report</a>
                            </li>

                        @endif
                    @endauth
                    </ul>
                    

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                                        {{ __('Profile') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <div class="modal fade" id="customAlertModal" tabindex="-1" role="dialog" aria-labelledby="customAlertModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 0.5rem;">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="customAlertMessage"></div>
                <div class="modal-footer" style="padding: 0.5rem;">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
