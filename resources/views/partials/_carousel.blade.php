<div class="container-fluid p-0">
    <div id="header-carousel" class="carousel slide" id="carousel" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="images/hero-1.jpg" alt="{{ __('Image') }}">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3 carouselText">
                        <h5 class="text-white text-uppercase">{{ __('Best Workout Planner') }}</h5>
                        <h1 class="display-2 text-white text-uppercase mb-md-4">{{ __('Make your own workout plan') }}</h1>
                        @if(!auth()->check())
                        <a href="{{ route('register') }}" class="btn btn-primary py-md-3 px-md-5 me-3 m-2">{{ __('Join Us') }}</a>
                    @endif
                    <a href="{{ route('workoutPlanner') }}" class="btn {{ auth()->check() ? 'btn-primary py-md-3 px-md-5 me-3 m-2' : 'btn-light py-md-3 px-md-5 m-2' }}">{{ __('Check out the possibilities') }}</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="w-100" src="images/hero-2.jpg" alt="{{ __('Image') }}">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3 carouselText">
                        <h5 class="text-white text-uppercase">{{ __('Best Workout Planner') }}</h5>
                        <h1 class="display-2 text-white text-uppercase mb-md-4">{{ __('Follow the path of your favourite') }}</h1>
                        @if(!auth()->check())
                            <a href="{{ route('register') }}" class="btn btn-primary py-md-3 px-md-5 me-3 m-2">{{ __('Join Us') }}</a>
                        @endif
                        <a href="{{ route('famousWorkouts') }}" class="btn {{ auth()->check() ? 'btn-primary py-md-3 px-md-5 me-3 m-2' : 'btn-light py-md-3 px-md-5 m-2' }}">{{ __('Check out the possibilities') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">{{ __('Previous') }}</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">{{ __('Next') }}</span>
        </button>
    </div>
</div>