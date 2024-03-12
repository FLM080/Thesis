<x-adminLayout>
    <div id="admin-page">
        <div class="container my-5 rounded border border-dark bg-dark">
            <h1 class="text-white m-3 text-uppercase mb-0">{{ __('Add Exercise') }}</h1>
            @if ($errors->any())
                <?php notify()->error($errors->first()) ?>
            @endif
            <form method="POST" action="{{ route('addExercise') }}" enctype="multipart/form-data">
                @csrf
                <div class="row m-3">
                    <div class="form-group col-md-6">
                        <label for="name" class="text-white">{{ __('Exercise Name') }}</label>
                        <input type="text" class="form-control mb-3" id="name" name="exercise_name"
                            placeholder="{{ __('Enter name') }}" value="{{ old('exercise_name') }}">
                        @error('name')
                        <?php notify()->error(__($message)) ?>
                        @enderror

                        <label for="muscle_group_id" class="text-white">{{ __('Muscle Group') }}</label>
                        <select class="form-control mb-3" id="muscle_group_id" name="muscle_group_id">
                            @foreach ($muscleGroups as $muscleGroup)
                            <option value="{{ $muscleGroup->muscle_group_id }}" {{ old('muscle_group_id') == $muscleGroup->muscle_group_id ? 'selected' : '' }}>
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
                            <option value="{{ $type }}" {{ old('exercise_type') == $type ? 'selected' : '' }}>
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
                            <option value="{{ $difficulty }}" {{ old('exercise_strength_level') == $difficulty ? 'selected' : '' }}>
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
                            <option value="{{ $goal }}" {{ old('exercise_goal') == $goal ? 'selected' : '' }}>
                                {{ $goal }}
                            </option>
                            @endforeach
                        </select>
                        @error('goal')
                        <?php notify()->error(__($message)) ?>
                        @enderror
                    </div>
                    <div class="form-group col-auto>
                        <label for="description" class="text-white">{{ __('Description') }}</label>
                        <textarea class="form-control mb-3" id="description" name="exercise_description" rows="3"
                            placeholder="{{ __('Enter description') }}">{{ old('exercise_description') }}</textarea>
                        @error('description')
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
            <h1 class="text-white m-3 text-uppercase mb-0">{{ __('Edit exercises') }}</h1>
            <div class="d-flex justify-content-end">
                <div class="input-group mb-3" style="max-width: 300px;">
                    <input type="text" class="form-control" id="search" name="search" placeholder="Search exercises" data-url="{{ route($searchRoute) }}">
                </div>
            </div>
            <div class="scrollable-table">
                <table class="table table-dark table-striped my-2 text-center" id="exercises-table">
                    <tbody id="table-body">
                        @include('partials._table', ['items' => $exercises, 'columns' => $columns, 'deleteRoute' => 'deleteExercise', 'tableId' => $tableId, 'editRoute' => $editRoute])
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-adminLayout>