<h5 class="modal-title" id="editModalLabel{{ $item->$tableId }}">{{ __('Edit Muscle Group') }}</h5>
<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
    <!-- Muscle Group Edit Form -->
    <form method="POST" action="{{ route($editRoute, ['id' => $item->$tableId]) }}">
        @csrf
        <div class="form-group">
            <label for="editName{{ $item->$tableId }}" class="text-white">{{ __('Muscle Group Name')}}</label>
            <input type="text" class="form-control" name="muscle_group_name" value="{{ $item->muscle_group_name }}">
            @error('muscle_group_name')
            <?php notify()->error(__($message)) ?>
            @enderror
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-primary my-3">{{ __('Save') }}</button>
        </div>
    </form>