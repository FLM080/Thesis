<!DOCTYPE html>
<html lang="en">

@include('components.head')

    <body>
        <div class="container-fluid bg-dark px-0">
            <div class="row gx-0">
                <div class="col-lg-3 bg-dark d-none d-lg-block">
                    <a href="{{route('home')}}" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                        <h1 class="m-0 display-4 text-primary text-uppercase">FitForge</h1>
                    </a>
                </div>
                @auth
                <div class="col-lg-9">
                    <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0 px-lg-5">
                        <a href="{{route('home')}}" class="navbar-brand d-block d-lg-none">
                            <h1 class="m-0 display-4 text-primary text-uppercase">FitForge</h1>
                        </a>
                        <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                            data-bs-target="#navbarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                            <div class="navbar-nav mr-auto py-0">
                                <a href="{{route('home')}}" class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">{{ __('Home')
                                    }}</a>
                                <a href="{{route('workoutPlanner')}}"
                                    class="nav-item nav-link {{ request()->is('WorkoutPlanner') ? 'active' : '' }}">{{
                                    __('Manage Your Workout') }}</a>
                                <a href=""
                                    class="nav-item nav-link {{ request()->is('famous') ? 'active' : '' }}">{{ __('Famous
                                    Workouts') }}</a>
                                <a href=""
                                    class="nav-item nav-link {{ request()->is('feedback') ? 'active' : '' }}">{{ __('Give Us
                                    Feedback') }}</a>
                            </div>
                            <div class="d-flex flex-row justify-content-between">
                                <a class="nav-item nav-link btn btn-primary py-md-3 px-md-5 d-lg-none" role="button"
                                    id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">{{
                                    auth()->user()->name }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item" href="{{route('profile')}}">{{ __('Profile') }}</a></li>
                                    @if(auth()->user()->user_admin_privilege)
                                    <li><a class="dropdown-item" href="{{route('adminExercise')}}">{{ __('Admin Panel') }}</a></li>
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
                                <div class=" px-md-5 nav-item nav-link dropdown d-flex">
                                    <a class="dropdown-toggle  font-bold align-self-center" role="button"
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
                                        <li><a class="dropdown-item" href="{{route('profile')}}">{{ __('Profile') }}</a></li>
                                        @if(auth()->user()->user_admin_privilege)
                                        <li><a class="dropdown-item" href="{{route('adminExercise')}}">{{ __('Admin Panel') }}</a></li>
                                        @endif

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <form class=" inline" method="POST" action="{{ route('logout') }}">
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
                @else
                <div class="col-lg-9">
                    <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0 px-lg-5">
                        <a href="{{route('home')}}" class="navbar-brand d-block d-lg-none">
                            <h1 class="m-0 display-4 text-primary text-uppercase">FitForge</h1>
                        </a>
                        <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                            data-bs-target="#navbarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                            <div class="navbar-nav mr-auto py-0">
                                <a href="{{route('home')}}" class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">{{ __('Home')
                                    }}</a>
                                <a href="{{route('workoutPlanner')}}"
                                    class="nav-item nav-link {{ request()->is('WorkoutPlanner') ? 'active' : '' }}">{{
                                    __('Plan Your Workout') }}</a>
                                <a href=""
                                    class="nav-item nav-link {{ request()->is('famous') ? 'active' : '' }}">{{ __('Famous Workouts') }}</a>
                                <a href=""
                                    class="nav-item nav-link {{ request()->is('feedback') ? 'active' : '' }}">{{ __('Give Us Feedback') }}</a>
                                <a href="{{ route('login') }}"
                                    class="nav-item nav-link btn btn-outline-primary py-md-3 px-md-5 d-lg-block d-lg-none" k
                                    id="Login">{{ __('Login') }}</a>
                                <a href="{{ route('register') }}" class="nav-item nav-link btn btn-primary py-md-3 px-md-5 d-lg-none">{{
                                    __('Sign Up') }}</a>

                            </div>
                            <div class="d-flex flex-row justify-content-between">
                                <div class=" px-md-5 nav-item nav-link dropdown d-flex">
                                    <a class="dropdown-toggle  font-bold align-self-center" role="button"
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
                                <a href="{{ route('login') }}"
                                    class="nav-item nav-link btn btn-outline-primary py-md-3 px-md-5 m-2 d-none d-lg-block">{{
                                    __('Login') }}</a>
                            <a href="{{ route('register') }}"
                                class="nav-item nav-link btn btn-primary py-md-3 px-md-5 m-2 d-none d-lg-block">{{
                                __('Sign Up') }}</a>
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

    @include('components.footer')
</body>

</html>