<div class="modal fade" id="updateWorkoutPlanModal{{ $workout->workout_id }}" tabindex="-1" aria-labelledby="updateWorkoutPlanModalLabel{{ $workout->workout_id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateWorkoutPlanModalLabel{{ $workout->workout_id }}">update Workout Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateWorkoutPlanForm" action="{{ route('editFamousWorkoutPlan', $workout->workout_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="workout_id" value="{{ $workout->workout_id }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="workout_name" class="form-label">Name of the workout plan</label>
                                <input type="text" class="form-control" id="workout_name" name="workout_name" value="{{ $workout->workout_name }}">
                            </div>
                            <div class="mb-3">
                                <label for="workout-type" class="form-label">Exercise types</label>
                                <select class="form-select" id="workout-type" name="workout_type">
                                    @foreach($workoutTypes as $type)
                                        <option value="{{ $type }}" {{ $workout->workout_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="workout-strength-level" class="form-label">Strength level</label>
                                <select class="form-select" id="workout-strength-level" name="workout_strength_level">
                                    @foreach($workoutDifficulty as $difficulty)
                                        <option value="{{ $difficulty }}" {{ $workout->workout_strength_level == $difficulty ? 'selected' : '' }}>{{ $difficulty }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="workout-goal" class="form-label">Goal of the plan</label>
                                <select class="form-select" id="workout-goal" name="workout_goal">
                                    @foreach($workoutGoals as $goal)
                                        <option value="{{ $goal }}" {{ $workout->workout_goal == $goal ? 'selected' : '' }}>{{ $goal }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="workout-days" class="form-label">Days</label>
                                <input type="number" class="form-control" id="workout-days" name="workout_days" value="{{ $workout->workout_days }}" min="1" max="7">
                            </div>
                            <div class="mb-3">
                                <label for="workout-gender" class="form-label">Recommended Gender</label>
                                <select class="form-select" id="workout-gender" name="workout_gender">
                                    @foreach($workoutGenders as $gender)
                                        <option value="{{ $gender }}" {{ $workout->workout_gender == $gender ? 'selected' : '' }}>{{ $gender }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="workout-description" class="form-label">Description</label>
                                <textarea class="form-control" id="workout-description" name="workout_description" rows="3">{{ $workout->workout_description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="workoutPlan_image" class="form-label">Workout Plan Image</label>
                                <input type="file" class="form-control" id="workoutPlan_image" name="workoutPlan_image">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <form action="{{ route('deleteFamousWorkoutPlan', $workout->workout_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this workout plan?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <button type="button" class="btn btn-primary ms-auto" data-form-id="updateWorkoutPlanForm" id="updateWorkoutPlanButton">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>