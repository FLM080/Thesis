<x-layout>
    <div class="container-fluid background">
        @if(!$workout)
        <div class="row m-5 bg-dark">
            <h1 class="text-white m-3 text-uppercase ">{{ __('error') }}</h1>
        </div>
        @else
        <div class="row m-3 bg-dark">
            <h1 class="text-white m-3 text-uppercase ">{{ __('') }}{{ $workout->workout_name }}{{ __('`s workout plan') }}</h1>
            @if($workout)
            <div class="col-12 mb-5">
                <div class="row m-5 pb-0 mb-0 justify-content-center align-items-center userWorkout flex-wrap">
                    <div class="col-3 justify-content-center align-items-center d-flex">
                        <img src="{{ asset($workoutPlanImg) }}" alt="{{ __('Personal Image') }}" class="personalImg">
                    </div>
                    <div class="col-md-6 h-75 ">
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
                    <div class="col-md-2 p-5 d-flex justify-content-center align-items-center workoutEdit">
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#mainToggleDiv">More</button>
                    </div>
                    <div id="mainToggleDiv" class="collapse row m-5 p-3 justify-content-center align-items-center userWorkoutDays flex-wrap">
                        @if($days->isEmpty())
                            <h1 class="text-white m-3 text-uppercase text-center">{{ __('No workouts yet') }}</h1>
                        @else
                        @foreach($days as $day)
                        <div class="workoutDays  p-3" id="dayDiv{{ $day->workout_day_id }}">
                            <div class="row d-flex justify-content-center align-items-center">
                                <div class="col-md-3 p-0 m-0 d-flex justify-content-center align-items-center">
                                    <img src="{{ asset($day->daysImagePath) }}" alt="Day Image" class="personalImg">
                                </div>
                                <div class="col-md-3 h-75">
                                    <p class="text-white"><strong>{{ __('Workout Days Name:') }}</strong> {{ $day->workout_day_name }}</p>
                                    <p class="text-white"><strong>{{ __('Day:') }}</strong> {{ $day->workout_day }}</p>
                                </div>
                                <div class="col-md-2 p-3 d-flex justify-content-center align-items-center">
                                    <button class="toggleButton btn btn-primary" data-bs-toggle="collapse" data-bs-target="#toggleDiv{{ $day->workout_day_id }}">More</button>
                                </div>
                            </div>
                            <div id="toggleDiv{{ $day->workout_day_id }}" class="collapse row justify-content-center align-items-center flex-wrap userWorkoutExercises">
                                @foreach($day->exerciseWorkout->sortBy('order') as $exercise)
                                @if(empty($day->exercises))
                                <h1 class="text-white m-3 text-uppercase text-center">{{ __('no exercises yet') }}</h1>
                                @endif
                                <div class="row p-3 d-flex justify-content-center align-items-center workoutDayExercises">
                                    <div class="col-md-3 p-0 m-0 d-flex justify-content-center align-items-center">
                                        <img src="{{ asset($exercise->exerciseImagePath) }}" alt="Exercise Image" class="personalImg ">
                                    </div>
                                    <div class="col-md-5 p-0 h-75">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="text-white"><strong>{{ __('Exercise Name:') }}</strong> {{ $exercise->exerciseName }}</p>
                                                <p class="text-white"><strong>{{ __('Exercise Equipment type:') }}</strong> {{ $exercise->exerciseType }}</p>
                                                <p class="text-white "><strong>{{ __('Exercise Difficulty:') }}</strong> {{ $exercise->exerciseDifficulty }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="text-white"><strong>{{ __('Order:') }}</strong> {{ $exercise->exercise_workout_order }}</p>
                                                <p class="text-white"><strong>{{ __('Exercise Sets:') }}</strong> {{ $exercise->exercise_workout_sets }}</p>
                                                <p class="text-white"><strong>{{ __('Exercise Reps:') }}</strong> {{ $exercise->exercise_workout_reps }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="text-white exerciseDesc"><strong>{{ __('Exercise Description:') }}</strong> {{ $exercise->exerciseDescription }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @endif
            <div class="row m-3">
                <div class="col text-start">
                    <a href="{{ url()->previous() }}" class="btn btn-primary m-2">{{ __('Go Back') }}</a>
                </div>
                <div class="col text-end">
                    <form method="POST" action="{{ route('copyFamousWorkout', $workout->workout_id) }}">
                        @csrf
                        <input type="hidden" name="workout_id" value="{{ $workout->workout_id }}">
                        <button type="submit" class="btn btn-primary m-2">{{ __('Choose Path') }}</button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</x-layout>