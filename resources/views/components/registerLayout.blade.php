
<!DOCTYPE html>
<html lang="en" >

@include('components.head')

<body>

    <!-- Header Start -->
    <div class="container-fluid bg-dark px-0">
        <div class="row gx-0">
            <div class="col-lg-3 bg-dark d-none d-lg-block">
                <a href="{{route('home')}}" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                    <h1 class="m-0 display-4 text-primary text-uppercase">FitForge</h1>
                </a>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0 px-lg-5">
                    <a href="{{route('home')}}" class="navbar-brand d-block d-lg-none">
                        <h1 class="m-0 display-4 text-primary text-uppercase">FitForge</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                        data-bs-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="{{route('home')}}" class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">{{ __('Home') }}</a>
                            <a href="{{route('workoutPlanner')}}" class="nav-item nav-link {{ request()->is('WorkoutPlanner') ? 'active' : '' }}">{{ __('Plan Your Workout') }}</a>
                            <a href="{{route('famousWorkouts')}}" class="nav-item nav-link {{ request()->is('FamousWorkouts') ? 'active' : '' }}">{{ __('Famous Workouts') }}</a>
                            <div class=" px-md-5 nav-item nav-link dropdown d-flex">
                                <a class="dropdown-toggle  font-bold align-self-center"
                                    role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ __('Languages') }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    @foreach (config('localization.locales') as $locale)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('localization', $locale) }}">{{ __($locale) }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                </nav>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- output-->
    {{ $slot }}

    @include('components.footer')

    </body>

    </html>
