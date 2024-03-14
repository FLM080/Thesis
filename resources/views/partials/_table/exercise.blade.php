<h5 class="modal-title" id="editModalLabel{{ $item->$tableId }}">{{ __('Edit Exercise') }}</h5>
<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
    <form method="POST" action="{{ route($editRoute, ['id' => $item->$tableId]) }}" enctype="multipart/form-data">
        @csrf
        <div class="row m-3">
            <div class="form-group col-md-6">
                <label for="name" class="text-white">{{ __('Exercise Name') }}</label>
                <input type="text" class="form-control mb-3" id="name" name="exercise_name"
                    placeholder="{{ __('Enter name') }}" value="{{ $item->exercise_name }}">
                @error('name')
                <?php notify()->error(__($message)) ?>
                @enderror

                <label for="muscle_group_id" class="text-white">{{ __('Muscle Group') }}</label>
                <select class="form-control mb-3" id="muscle_group_id" name="muscle_group_id">
                    @foreach ($muscleGroups as $muscleGroup)
                    <option value="{{ $muscleGroup->muscle_group_id }}" {{ $item->muscle_group_id ==
                        $muscleGroup->muscle_group_id ? 'selected' : '' }}>
                        {{ $muscleGroup->muscle_group_name }}
                    </option>
                    @endforeach
                </select>
                @error('muscle_group_id')
                <?php notify()->error(__($message)) ?>
                @enderror

                <label for="image" class="text-white">{{ __('Image') }}</label>
                <input type="file" class="form-control mb-3" id="image" name="image">
                @error('image')
                <?php notify()->error(__($message)) ?>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="exercise_type" class="text-white">{{ __('Exercise Type') }}</label>
                <select class="form-control mb-3" id="exercise_type" name="exercise_type">
                    @foreach ($exerciseTypes as $type)
                    <option value="{{ $type }}" {{ $item->exercise_type == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                    @endforeach
                </select>
                @error('exercise_type')
                <?php notify()->error(__($message)) ?>
                @enderror

                <label for="difficulty" class="text-white">{{ __('Difficulty') }}</label>
                <select class="form-control mb-3" id="difficulty" name="exercise_strength_level">
                    @foreach ($exerciseDifficulty as $difficulty)
                    <option value="{{ $difficulty }}" {{ $item->exercise_strength_level == $difficulty ? 'selected' : ''
                        }}>
                        {{ $difficulty }}
                    </option>
                    @endforeach
                </select>
                @error('difficulty')
                <?php notify()->error(__($message)) ?>
                @enderror

                <label for="goal" class="text-white">{{ __('Goal') }}</label>
                <select class="form-control mb-3" id="goal" name="exercise_goal">
                    @foreach ($exerciseGoal as $goal)
                    <option value="{{ $goal }}" {{ $item->exercise_goal == $goal ? 'selected' : '' }}>
                        {{ $goal }}
                    </option>
                    @endforeach
                </select>
                @error('goal')
                <?php notify()->error(__($message)) ?>
                @enderror
            </div>
            <div class="form-group col-auto">
                <label for="description" class="text-white">{{ __('Description') }}</label>
                <textarea class="form-control mb-3" id="exercise_description_edit" name="exercise_description" rows="3"
                    placeholder="{{ __('Enter description') }}">{{ $item->exercise_description }}</textarea>
                @error('description')
                <?php notify()->error(__($message)) ?>
                @enderror
            </div>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-primary my-3">{{ __('Save') }}</button>
        </div>
    </form>