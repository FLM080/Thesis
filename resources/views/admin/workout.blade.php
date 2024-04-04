<x-adminLayout>
    <div class="background">
        <div class="container my-5 rounded border border-dark bg-dark">
            <h1 class="text-white m-3 text-uppercase mb-0">{{ __('Add workout plan') }}</h1>
            @if ($errors->any())
            <?php notify()->error($errors->first()) ?>
            @endif
            <form method="POST" action="{{ route('addWorkoutPlan') }}" enctype="multipart/form-data">
                @csrf
                <div class="row m-3">
                    <div class="form-group col-md-6">
                        <label for="name">{{ __('Workout Plan Name') }}</label>
                        <input type="text" class="form-control mb-3" id="name" name="workout_name"
                            placeholder="{{ __('Enter name') }}" value="{{ old('workout_name') }}">
                        @error('name')
                        <?php notify()->error(__($message)) ?>
                        @enderror

                        <label for="workout_gender">{{ __('Recommended Gender') }}</label>
                        <select class="form-control mb-3" id="workout_gender" name="workout_gender">
                            @foreach($workout_gender as $gender)
                            <option value="{{ $gender }}" {{ old('workout_gender')==$gender ? 'selected' : '' }}>
                                {{ __($gender) }}
                            </option>
                            @endforeach
                        </select>
                        @error('workout_gender')
                        <?php notify()->error(__($message)) ?>
                        @enderror

                        <label for="workoutPlan_image">{{ __('Workout Plan Image') }}</label>
                        <input type="file" class="form-control mb-3" id="workoutPlan_image" name="workoutPlan_image"
                            value="{{ old('workoutPlan_image') }}">
                        @error('workoutPlan_image')
                        <?php notify()->error(__($message)) ?>
                        @enderror

                        <div class="form-group col-auto">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea class="form-control mb-3" id="description" name="workout_description" rows="3"
                                placeholder="{{ __('Enter description') }}">{{ old('workout_description') }}</textarea>
                            @error('description')
                            <?php notify()->error(__($message)) ?>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group col-md-6">

                        <label for="workout_days">{{ __('Workout Days') }}</label>
                        <select class="form-control mb-3" id="workout_days" name="workout_days">
                            @for ($i = 1; $i <= 7; $i++) <option value="{{ $i }}" {{ old('workout_days')==$i
                                ? 'selected' : '' }}>
                                {{ $i }}
                                </option>
                                @endfor
                        </select>
                        @error('workout_days')
                        <?php notify()->error(__($message)) ?>
                        @enderror

                        <label for="workout_strength_level">{{ __('Workout Strength Level')}}</label>
                        <select class="form-control mb-3" id="workout_strength_level" name="workout_strength_level">
                            @foreach($workout_strength_level as $Difficulty)
                            <option value="{{ $Difficulty }}" {{ old('workout_strength_level')==$Difficulty ? 'selected'
                                : '' }}>
                                {{ __($Difficulty) }}
                            </option>
                            @endforeach
                        </select>
                        @error('workout_strength_level')
                        <?php notify()->error(__($message)) ?>
                        @enderror

                        <label for="workout_goal">{{ __('Workout Goal') }}</label>
                        <select class="form-control mb-3" id="workout_goal" name="workout_goal">
                            @foreach($workout_goal as $goal)
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
                            @foreach($workout_type as $type)
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
                <div class="text-right">
                    <button type="submit" class="btn btn-primary my-3">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
        <div class="container my-5 rounded border border-dark bg-dark">
            <h1 class="text-white m-3 text-uppercase mb-0">{{ __('Add workout day') }}</h1>
            <div class="row m-3">
                <form method="POST" action="{{ route('addWorkoutDayAdmin') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row m-3">
                        <div class="form-group col-md-6">
                            <label for="workout_day_name">{{ __('Workout name') }}</label>
                            <input type="text" class="form-control mb-3" id="workout_day_name" name="workout_day_name"
                                placeholder="{{ __('Enter name') }}" value="{{ old('workout_day_name') }}">
                            @error('workout_day_name')
                            <?php notify()->error(__($message)) ?>
                            @enderror

                            <label for="workout_plan">{{ __('Workout Plan') }}</label>
                            <select class="form-select mb-3" id="workout_plan" name="workout_plan">
                                @foreach($workout_plans as $plan)
                                <option value="{{ $plan->workout_id }}">{{ $plan->workout_name }}</option>
                                @endforeach
                            </select>
                            @error('workout_plan')
                            <?php notify()->error(__($message)) ?>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="workout_day_day">{{ __('Day') }}</label>
                            <select class="form-select mb-3" id="workout_day_day" name="workout_day_day">
                                @foreach($days as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                                @endforeach
                            </select>
                            @error('workout_day_day')
                            <?php notify()->error(__($message)) ?>
                            @enderror

                            <label for="workout_day_image">{{ __('Workout day Image') }}</label>
                            <input type="file" class="form-control" id="workout_day_image" name="workout_day_image">
                        </div>
                        <h1 class="text-white m-3 text-uppercase mb-0">{{ __('Avaiable exercises') }}</h1>
                        <div class="form-group col-md-12 my-5 exercisesTable">
                            <table id="exercisesTable" class="table table-striped my-2 text-center">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="text-white">Name</th>
                                        <th class="text-white">Description</th>
                                        <th class="text-white">Type</th>
                                        <th class="text-white">Difficulty</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($exercises as $exercise)
                                    <tr>
                                        <td class="text-center">
                                            <img class="exerciseTableImage" src="{{ asset($exercise->image_path) }}" alt="{{ $exercise->exercise_name }}" >
                                        </td>
                                        <td class="text-white text-center">{{ $exercise->exercise_name }}</td>
                                        <td class="text-white text-center">
                                            <div class="exerciseDescription">{{ $exercise->exercise_description }}</div>
                                        </td>
                                        <td class="text-white text-center">{{ $exercise->exercise_type }}</td>
                                        <td class="text-white text-center">{{ $exercise->exercise_strength_level }}</td>
                                        <td class="text-center"><button type="button" class="btn btn-primary addExercise" data-id="{{ $exercise->exercise_id }}">Add</button></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <h1 class="text-white m-3 text-uppercase mb-0">{{ __('Chosen exercises') }}</h1>
                        <div class="form-group col-md-12 my-5 selectedExercisesTable" >
                            <table id="selectedExercisesTable" class="table table-striped my-2 text-center">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="text-white">Name</th>
                                        <th class="text-white">Description</th>
                                        <th class="text-white">Type</th>
                                        <th class="text-white">Difficulty</th>
                                        <th class="text-white">Sets</th>
                                        <th class="text-white">Reps</th>
                                        <th class="text-white">Order</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-right my-3">
                        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="container my-5 rounded border border-dark bg-dark">
            <h1 class="text-white m-3 text-uppercase mb-0">{{ __('Edit workouts') }}</h1>
            <div class="d-flex justify-content-end">
                <div class="input-group mb-3 searchbar">
                </div>
            </div>
            <div class="scrollable-table">
                <table class="table table-dark table-striped my-2 text-center" id="workouts-table">
                    <tbody id="table-body">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/addExerciseButton.js') }}"></script>
</x-adminLayout>