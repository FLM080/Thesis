<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Rubik&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    @notifyCss
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <title>FitForge: Your ultimate Workout Creator</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</head>


<body>

    <!-- Header Start -->
    <div class="container-fluid bg-dark px-0">
        <div class="row gx-0">
            <div class="col-lg-3 bg-dark d-none d-lg-block">
                <a href="/" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                    <h1 class="m-0 display-4 text-primary text-uppercase">FitForge</h1>
                </a>
            </div>
            @auth
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0 px-lg-5">
                    <a href="/" class="navbar-brand d-block d-lg-none">
                        <h1 class="m-0 display-4 text-primary text-uppercase">FitForge</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                        data-bs-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="/" class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">{{ __('Home')
                                }}</a>
                            <a href="/exercise"
                                class="nav-item nav-link {{ request()->is('exercise') ? 'active' : '' }}">{{ __('Manage
                                Exercises') }}</a>
                            <a href="/workout"
                                class="nav-item nav-link {{ request()->is('workout') ? 'active' : '' }}">{{ __('Manage
                                Workouts') }}</a>
                            <a href="/muscleGroup"
                                class="nav-item nav-link {{ request()->is('muscleGroup') ? 'active' : '' }}">{{
                                __('Manage Muscle Groups') }}</a>
                        </div>
                        <div class="d-flex flex-row justify-content-between">
                            <a class="nav-item nav-link btn btn-primary py-md-3 px-md-5 d-lg-none" role="button"
                                id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" href="/profile">{{ __('Profile') }}</a></li>
                                @if(auth()->user()->user_admin_privilege)
                                <li><a class="dropdown-item" href="/exercise">{{ __('Admin Panel') }}</a></li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form class="inline" method="POST" action="/logout">
                                        @csrf
                                        <input type="submit" class="dropdown-item" value="{{ __('Logout') }}">
                                    </form>
                                </li>
                            </ul>
                            <div class="px-md-5 nav-item nav-link dropdown d-flex">
                                <a class="dropdown-toggle font-bold align-self-center" role="button"
                                    id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ __('Languages') }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    @foreach (config('localization.locales') as $locale)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('localization', $locale) }}">{{
                                            __($locale) }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="dropdown">
                                <a class="btn btn-primary dropdown-toggle py-md-3 px-md-5 d-none d-lg-block font-bold"
                                    role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ auth()->user()->name }}
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item" href="/profile">{{ __('Profile') }}</a></li>
                                    @if(auth()->user()->user_admin_privilege)
                                    <li><a class="dropdown-item" href="/exercise">{{ __('Admin Panel') }}</a></li>
                                    @endif

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form class=" inline" method="POST" action="/logout">
                                            @csrf
                                            <input type="submit" class="dropdown-item" value="{{ __('Logout') }}">
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            @endauth
        </div>
    </div>
    <!-- Header End -->

    <!-- output-->
    {{ $slot }}

    <!-- Footer Start -->
    @if (request()->is('/'))
    <div class="container-fluid bg-dark text-secondary px-5 mt-5">
        <div class="row gx-5">
            <h4 class="text-uppercase text-light mb-4 text-center pt-3">{{ __('Quick Links') }}</h4>
            <div class="d-flex flex-row justify-content-center">
                <a class="text-secondary mb-2 me-3" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>{{
                    __('Home') }}</a>
                <a class="text-secondary mb-2 me-3" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>{{
                    __('Plan Your Workout') }}</a>
                <a class="text-secondary mb-2 me-3" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>{{
                    __('Famous Workouts') }}</a>
                <a class="text-secondary mb-2 me-3" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>{{
                    __('Give Us Feedback') }}</a>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4 py-lg-0 px-5" id="footer">
        <div class="row gx-5">
            <div class="py-lg-4 text-center">
                <p class="text-secondary mb-0">&copy;All Rights Reserved.</p>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->

    @else
    <div class="container-fluid py-4 py-lg-0 px-5" id="footer">
        <div class="row gx-5">
            <div class="py-lg-4 text-center">
                <p class="text-secondary mb-0">&copy;All Rights Reserved.</p>
            </div>script
        </div>
    </div>
    @endif
    <x-notify::notify />
    @notifyJs
    <script src="{{ asset('js/modal.js') }}"></script>

</body>

</html>