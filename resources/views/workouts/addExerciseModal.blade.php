<div class="modal fade" id="exerciseModal" tabindex="-1" role="dialog" aria-labelledby="ExerciseModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exerciseModalLabel">{{__('Add Exercise')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('addWorkoutDay')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row m-3">
                        <div class="form-group col-md-6">
                            <label for="workout_day_name">{{ __('Workout Day name') }}</label>
                            <input type="text" class="form-control mb-3" id="workout_day_name" name="workout_day_name"
                                placeholder="{{ __('Enter name') }}" value="{{ old('workout_day_name') }}">
                            @error('workout_day_name')
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
                        </div>

                        <div class="form-group col-md-12 mb-3">
                            <label for="workout_image">{{ __('Workout Day Image (Optional)') }}</label>
                            <input type="file" class="form-control" id="workout_image" name="workout_image">
                            @error('workout_image')
                            <?php notify()->error(__($message)) ?>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 exercisesTable">
                            <table id="exercisesTable" class="table  table-striped my-2 text-center">
                            </table>
                        </div>

                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
            </div>
        </form>
        </div>
    </div>
</div>