<x-layout>
    <div class="container-fluid workoutPlanner">

        @if(!$workout)
        <div class="row m-5 bg-dark">
            <h1 class="text-white m-3 text-uppercase ">{{ __('Start your journey') }}</h1>
            <div class="justify-content-center d-flex">
                @guest
                    <button type="button" class="btn btn-primary m-3 w-50" 
                        onclick="window.location.href='{{ route('login') }}';"
                        <?php notify()->info(__('Log in to make your own workout')) ?>
                    >
                        {{__('Log in to make your own workout')}}
                    </button>
                @else
                    <button type="button" class="btn btn-primary m-3 w-50" 
                        data-bs-toggle="modal" data-bs-target="#workoutModal"
                    >
                        {{__('Make your own workout')}}
                    </button>
                @endguest
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
            <div class="col-md-2 d-flex justify-content-center align-items-center workoutPlanner-button">
                <!-- Save button -->
                <button class="btn btn-primary saveExercise">Save</button>
            </div>
            <div class="col-md-5">
                <h2 class="text-white m-3 text-uppercase ">{{ __('available exercises') }}</h2>
                <!-- Right container -->
                <div class="wrapper-right bg-dark">
                    @foreach($items as $item)
                    <div class="card" onclick="moveCard(this)">
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
    <!-- Modal -->
    <div class="modal fade" id="workoutModal" tabindex="-1" role="dialog" aria-labelledby="workoutModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="workoutModalLabel">{{__('Workout')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        <div class="row m-3">
                            <div class="form-group col-md-6">
                                <label for="name">{{ __('Workout Name') }}</label>
                                <input type="text" class="form-control mb-3" id="name" name="workout_name"
                                    placeholder="{{ __('Enter name') }}" value="{{ old('workout_name') }}">
                                @error('name')
                                <?php notify()->error(__($message)) ?>
                                @enderror

                                <label for="workout_gender">{{ __('Workout Gender') }}</label>
                                <select class="form-control mb-3" id="workout_gender" name="workout_gender">
                                    @foreach($workoutGenders as $gender)
                                    <option value="{{ $gender }}" {{ old('workout_gender') == $gender ? 'selected' : (old('workout_gender') == $gender ? 'selected' : '') }}>
                                        {{ __($gender) }}
                                    </option>
                                @endforeach
                                </select>
                                @error('workout_gender')
                                <?php notify()->error(__($message)) ?>
                                @enderror

                                <div class="form-group col-auto">
                                    <label for="description">{{ __('Description') }}</label>
                                    <textarea class="form-control mb-3" id="description" name="workout_description"
                                        rows="3"
                                        placeholder="{{ __('Enter description') }}">{{ old('workout_description') }}</textarea>
                                    @error('description')
                                    <?php notify()->error(__($message)) ?>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="workout_strength_level" ">{{ __('Workout Strength Level')}}</label>
                                <select class=" form-control mb-3" id="workout_strength_level"
                                    name="workout_strength_level">
                                    @foreach($workoutDifficulty as $Difficulty)
                                    <option value="{{ $Difficulty }}" {{ old('workout_strength_level')==$Difficulty
                                        ? 'selected' : '' }}>
                                        {{ __($Difficulty) }}
                                    </option>
                                    @endforeach
                                </select>
                                    @error('workout_strength_level')
                                    <?php notify()->error(__($message)) ?>
                                    @enderror

                                    <label for="workout_goal">{{ __('Workout Goal') }}</label>
                                    <select class="form-control mb-3" id="workout_goal" name="workout_goal">
                                        @foreach($workoutGoals as $goal)
                                        <option value="{{ $goal }}" {{ old('workout_goal')==$goal ? 'selected' : '' }}>
                                            {{ __($goal) }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('workout_goal')
                                    <?php notify()->error(__($message)) ?>
                                    @enderror

                                    <label for="workout_type">{{ __('Workout Type') }}</label>
                                    <select class="form-control mb-3" id="workout_type" name="workout_type">
                                        @foreach($workoutTypes as $type)
                                        <option value="{{ $type }}" {{ old('workout_type')==$type ? 'selected' : '' }}>
                                            {{ __($type) }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('workout_type')
                                    <?php notify()->error(__($message)) ?>
                                    @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/workoutPlanner.js') }}"></script>
</x-layout>