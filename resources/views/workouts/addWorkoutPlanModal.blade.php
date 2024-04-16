<div class="modal fade" id="workoutModal" tabindex="-1" role="dialog" aria-labelledby="workoutModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="workoutModalLabel">{{__('Workout Plan')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('addWorkout')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row m-3">
                        <div class="form-group col-md-6">
                            <label for="name">{{ __('Workout Plan Name') }}</label>
                            <input type="text" class="form-control mb-3" id="name" name="workout_name"
                                placeholder="{{ __('Enter name') }}" value="{{ old('workout_name') }}">
                            @error('workout_name')
                            <?php notify()->error(__($message)) ?>
                            @enderror

                            <label for="workout_gender">{{ __('Recommended Gender') }}</label>
                            <select class="form-select mb-3" id="workout_gender" name="workout_gender">
                                @foreach($workoutGenders as $gender)
                                <option value="{{ $gender }}" {{ old('workout_gender')==$gender ? 'selected' :
                                    (old('workout_gender')==$gender ? 'selected' : '' ) }}>
                                    {{ __($gender) }}
                                </option>
                                @endforeach
                            </select>
                            @error('workout_gender')
                            <?php notify()->error(__($message)) ?>
                            @enderror

                            <label for="workoutPlan_image">{{ __('Workout Plan Image (Optional)') }}</label>
                            <input type="file" class="form-control mb-3" id="workoutPlan_image" name="workoutPlan_image"
                                value="{{ old('workoutPlan_image') }}">
                            @error('workoutPlan_image')
                            <?php notify()->error(__($message)) ?>
                            @enderror

                            <div class="form-group col-auto">
                                <label for="description">{{ __('Description') }}</label>
                                <textarea class="form-control mb-3" id="description" name="workout_description" rows="3"
                                    placeholder="{{ __('Enter description') }}">{{ old('workout_description') }}</textarea>
                                @error('workout_description')
                                <?php notify()->error(__($message)) ?>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-md-6">

                            <label for="workout_days">{{ __('Workout Days') }}</label>
                            <select class="form-select mb-3" id="workout_days" name="workout_days">
                                @for ($i = 1; $i <= 7; $i++) <option value="{{ $i }}" {{ old('workout_days')==$i
                                    ? 'selected' : '' }}>
                                    {{ $i }}
                                    </option>
                                    @endfor
                            </select>
                            @error('workout_days')
                            <?php notify()->error(__($message)) ?>
                            @enderror

                            <label for="workout_strength_level" ">{{ __('Workout Strength Level')}}</label>
                        <select class=" form-select mb-3" id="workout_strength_level" name="workout_strength_level">
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
                                <select class="form-select mb-3" id="workout_goal" name="workout_goal">
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
                                <select class="form-select mb-3" id="workout_type" name="workout_type">
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
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
            </div>
            </form>
        </div>
    </div>
</div>