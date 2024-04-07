<x-layout>
    <div class="container-fluid background">

        @if(!$workout)
        <div class="row m-5 bg-dark text-center">
            <h1 class="text-white m-3 text-uppercase ">{{ __('Start your own journey') }}</h1>
            <div class="justify-content-center d-flex">
                @guest
                <?php notify()->info(__('Log in to make your own workout')) ?>
                <a href="{{ route('login') }}" class="btn btn-primary m-3 w-50">
                    {{__('Log in to make your own workout plan')}}
                </a>
                @else
                <button type="button" class="btn btn-primary m-3 w-50" data-bs-toggle="modal"
                    data-bs-target="#workoutModal">
                    {{__('Make your own workout plan')}}
                </button>
                @endguest
            </div>
            <div class="justify-content-center d-flex my-5">
                <h1 class="text-white m-3 text-uppercase ">{{ __('Or') }}</h1>
            </div>
            <div>
                <h1 class="text-white m-3 text-uppercase ">{{ __('Follow the path of one of your favourite') }}</h1>
                <div class="scrollingImg">
                    <div class="scroller" data-direction="right" data-speed="slow">
                        <div class="scroller__inner">
                            @foreach ($images as $image)
                            <img class="loopingImg" src="{{ asset('images/workouts/famous/' . $image->getFilename()) }}"
                                alt="famousImages">
                            @endforeach
                        </div>
                    </div>

                </div>
                <div class="justify-content-center d-flex my-5">
                    <button type="button" class="btn btn-primary m-3 w-50">
                        {{__('Follow the path')}}
                    </button>
                </div>
            </div>
        </div>
        @else
        <div class="row m-3 bg-dark">
            <h1 class="text-white my-3 text-uppercase ">{{ __('Keep up the grind') }}</h1>
            @if($workout)
            <div class="col-12">
                <div class="row m-5 justify-content-center align-items-center userWorkout flex-wrap">
                    <div class="col-3 justify-content-center align-items-center d-flex">
                        <img src="{{ asset($personalImg) }}" alt="{{ __('Personal Image') }}" class="personalImg" >
                    </div>
                    <div class="col-md-7 h-75 ">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-white"><strong>{{ __('Name of the workout plan:') }}</strong> {{ $workout->workout_name }}</p>
                                <p class="text-white"><strong>{{ __('Exercise types:') }}</strong> {{ $workout->workout_type }}</p>
                                <p class="text-white"><strong>{{ __('Required strength level for the workout:') }}</strong> {{ $workout->workout_strength_level }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-white"><strong>{{ __('Goal of the plan:') }}</strong> {{ $workout->workout_goal }}</p>
                                <p class="text-white"><strong>{{ __('Days:') }}</strong> {{ $workout->workout_days }}</p>
                                <p class="text-white"><strong>{{ __('Recommended Gender:') }}</strong> {{ $workout->workout_gender }}</p>
                            </div>
                        </div>
                        <div class="row workoutDescription">
                            <div class="col-md-12 mt-3">
                                <p class="text-white"><strong>{{ __('Description:') }}</strong> {{ $workout->workout_description }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex justify-content-center align-items-center workoutView h-100">
                        <a href="{{ route('personalWorkoutPlan') }}" class="btn btn-primary">{{ __('View') }}</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endif
        <div class="row m-5 bg-dark">
            <h1 class="text-white m-3 text-uppercase ">{{ __('exercises') }}</h1>
            <div class=" col-md-5">
                <h2 class="text-white m-3 text-uppercase ">{{ __('Chosen exercises') }}</h2>
                <!-- Left container -->
                <div class="wrapper-left bg-dark">
                </div>
            </div>
            @if(!$workout)
            @auth
            <div class="col-md-2 my-3 d-flex justify-content-center align-items-center workoutPlanner-button">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#workoutModal">{{ __('Create a workout plan') }}</button>
            </div>
            @endauth
            @guest
            <div class="col-md-2 my-3 d-flex justify-content-center align-items-center workoutPlanner-button">
                <a href="{{ route('login') }}" class="btn btn-primary ">{{ __('Save') }}</a>
            </div>
            @endguest
            @else
            <div class="col-md-2 my-3 d-flex justify-content-center align-items-center workoutPlanner-button">
                <button class="btn btn-primary saveExercise ">{{ __('Save') }}</button>
            </div>
            @endif
            <div class="col-md-5">
                <h2 class="text-white m-3 text-uppercase ">{{ __('available exercises') }}</h2>
                <div class="wrapper-right bg-dark">
                    @foreach($items as $item)
                    <div class="card" id="card-{{ $item->exercise_id }}" onclick="moveCard(this)">
                        <img src="{{ asset($item->imagePath) }}" alt="{{ __('Exercise Image') }}">
                        <div class="info">
                            <h4 class="text-white">{{ $item->exercise_name }}</h4>
                            <strong>{{ __('Description:') }}</strong>
                            <p class="description"> {{ $item->exercise_description }}</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>{{ __('Type') }}</strong>
                                    <p>{{ $item->exercise_type }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>{{ __('Strength Level:') }}</strong>
                                    <p> {{ $item->exercise_strength_level }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('workouts.addWorkoutPlanModal')
    @include('workouts.addExerciseModal')

    <script src="{{ asset('js/workoutPlanner.js') }}"></script>
    <script src="{{ asset('js/movingSlide.js') }}"></script>
</x-layout>