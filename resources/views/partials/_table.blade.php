

    <tr>
        @foreach ($columns as $column)
        <th class="text-white">{{ str_replace('id', '', str_replace('_', ' ', __($column))) }}</th>
        @endforeach
        <th class="text-white text-center">{{ __('Edit') }}</th>
        <th class="text-white text-center">{{ __('Delete') }}</th>
    </tr> 
    @foreach ($items as $item)
    <tr>
        @foreach ($columns as $column)
            <td class="text-white">{{ $item->getDisplayValue($column)}}</td>
        @endforeach
        <td class="text-center">
            <button type="button" class="btn btn-primary edit-btn"
                data-bs-target="#editModal{{ $item->id }}">{{ __('Edit') }}
            </button>
        </td>
        <td class="text-center">
            <form method="POST" action="{{ route($deleteRoute, ['id' => $item->$tableId]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-primary">{{__('Delete') }}</button>
            </form>
        </td>
    </tr>
<!-- Edit Modal -->
<div class="modal fade" id="editModal{{ $item->$tableId }}" tabindex="-1"
    role="dialog" aria-labelledby="editModalLabel{{ $item->$tableId }}"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $item->$tableId }}">{{ __('Edit Muscle Group') }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route($editRoute, ['id' => $item->$tableId]) }}">
                    @csrf
                    <div class="form-group">
                        <label for="editName{{ $item->$tableId }}" class="text-white">{{ __('Muscle Group Name')}}</label>
                        <input type="text" class="form-control" name="muscle_group_name" value="{{ $item->muscle_group_name }}">
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