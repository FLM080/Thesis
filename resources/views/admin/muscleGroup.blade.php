<x-adminLayout>
    <div id="admin-page">
        <div class="container my-5 rounded border border-dark bg-dark w-25">
            <h1 class="text-white m-3 text-uppercase mb-0">{{ __('Add muscle group') }}</h1>

            <form method="POST" action="/admin/addMuscleGroup">
                @csrf
                <div class="form-group mx-3">
                    <label for="name" class="text-white">{{ __('Muscle Group Name') }}</label>
                    <input type="text" class="form-control" id="muscle_group_name" name="muscle_group_name"
                        placeholder="{{ __('Enter name') }}">
                    @error('muscle_group_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary my-3">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
        <div class="container my-5 rounded border border-dark bg-dark">
            <h1 class="text-white m-3 text-uppercase mb-0">{{ __('Edit exercises') }}</h1>
            <div class="scrollable-table">
                <table class="table table-dark table-striped my-5">
                    <tr>
                        <th class="text-white">Id</th>
                        <th class="text-white">{{ __('Muscle Group Name') }}</th>
                        <th class="text-white text-center">{{ __('Edit') }}</th>
                        <th class="text-white text-center">{{ __('Delete') }}</th>
                    </tr>
                    @foreach ($muscleGroups as $muscleGroup)
                    <tr>
                        <td class="text-white">{{ $muscleGroup->muscle_group_id }}</td>
                        <td class="text-white">{{ $muscleGroup->muscle_group_name }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-primary edit-btn"
                                data-bs-target="#editModal{{ $muscleGroup->muscle_group_id}}">{{ __('Edit') }}
                            </button>
                        </td>
                        <td class="text-center">
                            <form method="POST" action="/admin/deleteMuscleGroup/{{ $muscleGroup->muscle_group_id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-primary">{{__('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal{{ $muscleGroup->muscle_group_id }}" tabindex="-1"
                        role="dialog" aria-labelledby="editModalLabel{{ $muscleGroup->muscle_group_id }}"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $muscleGroup->muscle_group_id }}">{{
                                        __('Edit Muscle Group') }}</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST"
                                        action="/admin/editMuscleGroup/{{ $muscleGroup->muscle_group_id }}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="editName{{ $muscleGroup->muscle_group_id }}"
                                                class="text-white">{{
                                                __('Muscle Group Name')}}</label>
                                            <input type="text" class="form-control" name="muscle_group_name"
                                                value="{{ $muscleGroup->muscle_group_name }}">
                                            @error('muscle_group_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary my-3">{{ __('Save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</x-adminLayout>