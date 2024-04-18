<div class="modal fade" id="updateDayModal{{ $day->workout_day_id }}" tabindex="-1"
    aria-labelledby="updateModalLabel{{ $day->workout_day_id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel{{ $day->workout_day_id }}">{{ __('update Day') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateWorkoutDayFrom" action="{{ route('updateWorkoutDay', $day->workout_day_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="workout_day_id" value="{{ $day->workout_day_id }}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="workout_day_name" class="form-label">{{ __('Day Name') }}</label>
                            <input type="text" class="form-control" name="workout_day_name" id="workout_day_name"
                                value="{{ $day->workout_day_name }}">
                            @error('workout_day_name')
                            <?php notify()->error(__($message)) ?>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="workout_day" class="form-label">{{ __('Day Number') }}</label>
                            <select class="form-select" id="workout_day"
                                name="workout_day">
                                @foreach($daysOfTheWeek as $dayOption)
                                <option value="{{ $dayOption }}" {{ $dayOption==$day->workout_day ? 'selected' : ''
                                    }}>{{ __($dayOption) }}</option>
                                @endforeach
                            </select>
                            @error('workout_day')
                            <?php notify()->error(__($message)) ?>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="WorkoutDayImage" class="form-label">{{ __('Day Image (Optional)') }}</label>
                        <input type="file" class="form-control" id="WorkoutDayImage"
                            name="WorkoutDayImage">
                        @error('WorkoutDayImage')
                        <?php notify()->error(__($message)) ?>
                        @enderror
                    </div>
            </div>
        </form>
            <div class="modal-footer">
                <form action="{{ route('deleteWorkoutDay', $day->workout_day_id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this day? This action cannot be undone.') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                </form>
                <button type="submit" class="btn btn-primary ms-auto" data-form-id="updateWorkoutDayFrom" id="updateWorkoutDayButton">{{ __('Save changes') }}</button>
            </div>
        </div>
    </div>
</div>