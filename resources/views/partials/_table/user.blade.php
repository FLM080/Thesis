<h5 class="modal-title" id="editModalLabel{{ $item->id }}">{{ __('Edit User') }}</h5>
<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
    <form method="POST" action="{{ route($editRoute, ['id' => $item->$tableId]) }}" enctype="multipart/form-data">
        @csrf
        <div class="row m-3 justify-content-center">
            <div class="form-group text-center w-75">
                <label for="name" class="text-white">{{ __('User Name') }}</label>
                <input type="text" class="form-control mb-3 disabled-field" id="name" name="name" value="{{ $item->name }}" disabled>
            </div>

            <div class="form-group text-center w-75">
                <label for="email" class="text-white">{{ __('Email') }}</label>
                <input type="email" class="form-control mb-3 disabled-field" id="email" name="email" placeholder="{{ __('Enter email') }}"
                    value="{{ $item->email }}" disabled>
            </div>

            <div class="form-group text-center w-75">
                <label for="gender" class="text-white">{{ __('Gender') }}</label>
                <input type="text" class="form-control mb-3 disabled-field" id="gender" name="gender" value="{{ $item->user_gender }}"
                    disabled>
            </div>

            <div class="form-group text-center w-75">
                <label for="user_admin_privilege" class="text-white">{{ __('Admin Status') }}</label>
                <select class="form-control mb-3 editable-field" id="user_admin_privilege" name="user_admin_privilege">
                    <option value="No" {{ $item->user_admin_privilege == 'No' ? 'selected' : '' }}>
                        {{ __('No') }}
                    </option>
                    <option value="Yes" {{ $item->user_admin_privilege == 'Yes' ? 'selected' : '' }}>
                        {{ __('Yes') }}
                    </option>
                </select>
            @error('user_admin_privilege')
            <?php notify()->error(__($message)) ?>
            @enderror
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-primary my-3">{{ __('Save') }}</button>
        </div>
    </form>
</div>