<div class="modal fade" id="updateExerciseModal{{ $exercise->exercise_workout_connect_id }}" tabindex="-1" aria-labelledby="updateExerciseModalLabel{{ $exercise->exercise_id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateExerciseModalLabel{{ $exercise->exercise_workout_connect_id }}">Update Exercise</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateExerciseForm" action="{{ route('updateWorkoutDayExercise', $exercise->exercise_workout_connect_id) }} " method="POST">
                    @csrf
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="mb-3">
                                    <label for="exercise_order" class="form-label">Order</label>
                                    <input type="number" class="form-control" id="exercise_order" name="exercise_order" value="{{ $exercise->order }}" min="1">
                                </div>
                                <div class="mb-3">
                                    <label for="exercise_sets" class="form-label">Sets</label>
                                    <input type="number" class="form-control" id="exercise_sets" name="exercise_sets" value="{{ $exercise->exercise_workout_sets }}" min="1">
                                </div>
                                <div class="mb-3">
                                    <label for="exercise_reps" class="form-label">Reps</label>
                                    <input type="number" class="form-control" id="exercise_reps" name="exercise_reps" value="{{ $exercise->exercise_workout_reps }}" min="1">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <form action="{{ route('deleteWorkoutDayExercise', $exercise->exercise_workout_connect_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this exercise? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <button type="button" class="btn btn-primary ms-auto" data-form-id="updateExerciseForm" id="updateExerciseButton">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>