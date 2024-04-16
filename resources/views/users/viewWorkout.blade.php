<x-layout>
    <div class="container-fluid background">
        @if(!$workout)
        <div class="row m-5 bg-dark">
            <h1 class="text-white m-3 text-uppercase ">{{ __('you don`t have a workout plan yet') }}</h1>
            <div class="justify-content-center d-flex my-5">
                <a href="{{ route('workoutPlanner') }}" type="button" class="btn btn-primary m-3 w-50">
                    {{__('Make a workout plan')}}
                </a>
            </div>
        </div>
        @else
        <div class="row m-3 bg-dark">
            <h1 class="text-white m-3 text-uppercase ">{{ __('My workout plan') }}</h1>
            @if($workout)
            <div class="col-12 mb-5">
                <div class="row m-5 pb-0 mb-0 justify-content-center align-items-center userWorkout flex-wrap">
                    <div class="col-3 justify-content-center align-items-center d-flex">
                        <img src="{{ asset($workoutPlanImg) }}" alt="{{ __('Personal Image') }}" class="personalImg">
                    </div>
                    <div class="col-md-6 h-75 ">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-white"><strong>{{ __('Name of the workout plan:') }}</strong> {{ __($workout->workout_name) }}</p>
                                <p class="text-white"><strong>{{ __('Exercise types:') }}</strong> {{ __($workout->workout_type) }}</p>
                                <p class="text-white"><strong>{{ __('Required strength level:') }}</strong> {{ __($workout->workout_strength_level) }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-white"><strong>{{ __('Goal of the plan:') }}</strong> {{ __($workout->workout_goal) }}</p>
                                <p class="text-white"><strong>{{ __('Days:') }}</strong> {{ $workout->workout_days }}</p>
                                <p class="text-white"><strong>{{ __('Recommended Gender:') }}</strong> {{ __($workout->workout_gender) }}</p>
                            </div>
                        </div>
                        <div class="row workoutDescription">
                            <div class="col-md-12 mt-3">
                                <p class="text-white"><strong>{{ __('Description:') }}</strong> {{ __($workout->workout_description) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex justify-content-center align-items-center workoutEdit">
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#updateWorkoutPlanModal{{ $workout->workout_id }}">{{ __('Edit') }}</button>
                    </div>
                    <div class="col-md-2 p-5 d-flex justify-content-center align-items-center">
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#mainToggleDiv">{{ __('More') }}</button>
                    </div>
                    <div id="mainToggleDiv" class="collapse row m-5 p-3 justify-content-center align-items-center userWorkoutDays flex-wrap">
                        @if($days->isEmpty())
                            <h1 class="text-white m-3 text-uppercase text-center">{{ __('you don\'t have workout days yet') }}</h1>
                        @else
                        @foreach($days as $day)
                        <div class="workoutDays  p-3" id="dayDiv{{ $day->workout_day_id }}">
                            <div class="row d-flex justify-content-center align-items-center">
                                <div class="col-md-3 p-0 m-0 d-flex justify-content-center align-items-center">
                                    <img src="{{ asset($day->daysImagePath) }}" alt="Day Image" class="personalImg">
                                </div>
                                <div class="col-md-3 h-75">
                                    <p class="text-white"><strong>{{ __('Workout Days Name:') }}</strong> {{ __($day->workout_day_name) }}</p>
                                    <p class="text-white"><strong>{{ __('Day:') }}</strong> {{ $day->workout_day }}</p>
                                </div>
                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateDayModal{{ $day->workout_day_id }}">{{ __('edit') }}</button>
                                </div>
                                <div class="col-md-2 p-3 d-flex justify-content-center align-items-center">
                                    <button class="toggleButton btn btn-primary" data-bs-toggle="collapse" data-bs-target="#toggleDiv{{ $day->workout_day_id }}">{{ __('More') }}</button>
                                </div>
                            </div>
                            <div id="toggleDiv{{ $day->workout_day_id }}" class="collapse row justify-content-center align-items-center flex-wrap userWorkoutExercises">
                                @if($day->exerciseWorkout->isEmpty())
                                    <h1 class="text-white m-3 text-uppercase text-center">{{ __('you dont have exercises on this day') }}</h1>
                                @endif
                                @foreach($day->exerciseWorkout->sortBy('order') as $exercise)
                                <div class="row p-3 d-flex justify-content-center align-items-center workoutDayExercises">
                                    <div class="col-md-3 p-0 m-0 d-flex justify-content-center align-items-center">
                                        <img src="{{ asset($exercise->exerciseImagePath) }}" alt="Exercise Image" class="personalImg ">
                                    </div>
                                    <div class="col-md-5 p-0 h-75">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="text-white"><strong>{{ __('Exercise Name:') }}</strong> {{ __($exercise->exerciseName) }}</p>
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
                                                <p class="text-white exerciseDesc"><strong>{{ __('Exercise Description:') }}</strong> {{ __($exercise->exerciseDescription) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 p-3 d-flex justify-content-center align-items-center">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateExerciseModal{{ $exercise->exercise_workout_connect_id }}">{{ __('edit') }}</button>
                                    </div>
                                </div>
                                @include('users.viewWorkoutModals.updateExerciseModal')
                                @endforeach
                            </div>
                        </div>
                        @include('users.viewWorkoutModals.updateDayModal')
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
        @include('users.viewWorkoutModals.updateWorkoutPlanModal')
        @endif
    </div>
    <script src="{{ asset('js/editWorkoutPlanButton.js') }}"></script>
</x-layout>