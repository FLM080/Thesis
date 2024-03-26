<x-layout>
    <div class="container-fluid workoutPlanner">

        @if(!$workout)
        <div class="row m-5 bg-dark">
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
                                alt="" />
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
        <div class="row m-5 bg-dark">
            <h1 class="text-white m-3 text-uppercase ">{{ __('Keep up the grind') }}</h1>

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
                    <div class="col-md-2 d-flex justify-content-center align-items-center workoutPlanner-button">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#workoutModal">Create a workout plan</button>
                    </div>
                @endauth
                @guest
                    <div class="col-md-2 d-flex justify-content-center align-items-center workoutPlanner-button">
                        <a href="{{ route('login') }}" class="btn btn-primary ">{{ __('Save') }}</a>
                    </div>
                @endguest
            @else
                <div class="col-md-2 d-flex justify-content-center align-items-center workoutPlanner-button">
                    <button class="btn btn-primary saveExercise">Save</button>
                </div>
            @endif
            <div class="col-md-5">
                <h2 class="text-white m-3 text-uppercase ">{{ __('available exercises') }}</h2>
                <!-- Right container -->
                <div class="wrapper-right bg-dark">
                    @foreach($items as $item)
                    <div class="card" id="card-{{ $item->exercise_id }}" onclick="moveCard(this)">
                        <img src="{{ asset($item->imagePath) }}" alt="Exercise Image">
                        <div class="info">
                            <h4 class="text-white">{{ $item->exercise_name }}</h4>
                            <strong>Description:</strong>
                            <p> {{ $item->exercise_description }}</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Type</strong>
                                    <p>{{ $item->exercise_type }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>Strength Level:</strong>
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