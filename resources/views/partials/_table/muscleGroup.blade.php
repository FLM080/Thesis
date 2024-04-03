<h5 class="modal-title" id="updateModalLabel{{ $item->$tableId }}">{{ __('update Muscle Group') }}</h5>
<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body ">
    <form method="POST" action="{{ route($editRoute, ['id' => $item->$tableId]) }}">
        @csrf
        <div class="d-flex justify-content-center m-3">
            <div class="form-group w-75">
                <label for="updateName{{ $item->$tableId }}" >{{ __('Muscle Group Name')}}</label>
                <input type="text" class="form-control" name="muscle_group_name" value="{{ $item->muscle_group_name }}">
                @error('muscle_group_name')
                <?php notify()->error(__($message)) ?>
                @enderror
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </div>
    </form>
</div>