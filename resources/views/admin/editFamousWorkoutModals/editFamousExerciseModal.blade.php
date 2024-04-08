<div class="modal fade" id="updateExerciseModal{{ $exercise->exercise_workout_id }}" tabindex="-1" aria-labelledby="updateExerciseModalLabel{{ $exercise->exercise_id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateExerciseModalLabel{{ $exercise->exercise_workout_id }}">{{ __('Update Exercise') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateExerciseForm" action="{{ route('editFamousWorkoutDayExercise', $exercise->exercise_workout_id) }} " method="POST">
                    @csrf
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="mb-3">
                                    <label for="exercise_order" class="form-label">{{ __('Order') }}</label>
                                    <input type="number" class="form-control" id="exercise_order" name="exercise_order" value="{{ $exercise->exercise_workout_order }}" min="1">
                                </div>
                                @error('exercise_order')
                                <?php notify()->error(__($message)) ?>
                                @enderror
                                <div class="mb-3">
                                    <label for="exercise_sets" class="form-label">{{ __('Sets') }}</label>
                                    <input type="number" class="form-control" id="exercise_sets" name="exercise_sets" value="{{ $exercise->exercise_workout_sets }}" min="1">
                                </div>
                                @error('exercise_sets')
                                <?php notify()->error(__($message)) ?>
                                @enderror
                                <div class="mb-3">
                                    <label for="exercise_reps" class="form-label">{{ __('Reps') }}</label>
                                    <input type="number" class="form-control" id="exercise_reps" name="exercise_reps" value="{{ $exercise->exercise_workout_reps }}" min="1">
                                </div>
                                @error('exercise_reps')
                                <?php notify()->error(__($message)) ?>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <form action="{{ route('deleteFamousWorkoutDayExercise', $exercise->exercise_workout_id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this exercise? This action cannot be undone.') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                    </form>
                    <button type="button" class="btn btn-primary ms-auto" data-form-id="updateExerciseForm" id="updateExerciseButton">{{ __('Save changes') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>