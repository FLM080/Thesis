<h5 class="modal-title" id="updateModalLabel{{ $item->id }}">{{ __('update User') }}</h5>
<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
    <form method="POST" action="{{ route($editRoute, ['id' => $item->$tableId]) }}" enctype="multipart/form-data">
        @csrf
        <div class="row m-3 justify-content-center">
            <div class="form-group text-center w-75">
                <label for="name">{{ __('User Name') }}</label>
                <input type="text" class="form-control mb-3 disabled-field" id="name" name="name" value="{{ $item->name }}" disabled>
            </div>

            <div class="form-group text-center w-75">
                <label for="email">{{ __('Email') }}</label>
                <input type="email" class="form-control mb-3 disabled-field" id="email" name="email" placeholder="{{ __('Enter email') }}"
                    value="{{ $item->email }}" disabled>
            </div>

            <div class="form-group text-center w-75">
                <label for="gender">{{ __('Gender') }}</label>
                <input type="text" class="form-control mb-3 disabled-field" id="gender" name="gender" value="{{ $item->user_gender }}"
                    disabled>
            </div>

            <div class="form-group text-center w-75">
                <label for="user_admin_privilege">{{ __('Admin Status') }}</label>
                <select class="form-select mb-3 updateable-field" id="user_admin_privilege" name="user_admin_privilege">
                    <option value="0" {{ $item->user_admin_privilege == false ? 'selected' : '' }}>
                        {{ __('No') }}
                    </option>
                    <option value="1" {{ $item->user_admin_privilege == true ? 'selected' : '' }}>
                        {{ __('Yes') }}
                    </option>
                </select>
                @error('user_admin_privilege')
                    <?php notify()->error(__($message)) ?>
                @enderror
            </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary ">{{ __('Save') }}</button>
        </div>
    </form>
</div>