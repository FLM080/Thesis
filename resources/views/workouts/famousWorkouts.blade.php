<x-layout>
    <div class=" background">
        <div class="container-fluid p-0 mb-5">
            <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($famousImages as $index => $image)
                    @if($image->getFilename() !== 'Default.jpg')
                        <div class="carousel-item @if($index == 0) active @endif">
                            <img class="w-100 carouselImg" src="{{ asset('images/workouts/famous/carousel/' . $image->getFilename()) }}" alt="Image">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3 carouselText">
                                    <h5 class="text-white text-uppercase">{{__('Best workout plans')}}</h5>
                                    <h1 class="display-2 text-white text-uppercase mb-md-4">{{__('Follow the path of your favourites')}}</h1>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="row m-3 bg-dark ">
            <h1 class="text-white m-3 text-uppercase ">{{ __('Famous Workout Plans') }}</h1>
            <div class="overflow-auto p-3 famousWorkoutsContainer">
                <div class="d-flex flex-wrap justify-content-center">
                    @foreach($famousWorkouts as $workout)
                    <div class="card m-3" id="card-{{ $workout->workout_id }}">
                        <img src="{{ asset($famousWorkoutImagesPaths[$workout->workout_id]) }}" alt="{{ __('Workout Image') }}">
                        <div class="info d-flex flex-column text-center">
                            <h4 class="text-white card-title mt-2">{{ $workout->workout_name }}</h4>
                            <strong>{{ __('Description:') }}</strong>
                            <p class="flex-grow-1 description"> {{ $workout->workout_description }}</p>
                            <a href="{{ route('famousWorkout', $workout->workout_id) }}" class="btn btn-primary">{{ __('View Workout') }}</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layout>