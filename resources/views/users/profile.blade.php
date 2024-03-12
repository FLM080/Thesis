@auth
<x-layout>
    <div id="profile-main">
        <div class="container my-5 rounded border border-dark bg-dark">
            <div class="row">
                <h1 class="text-white m-3 text-uppercase mb-0">{{ __('Profile Page') }}</h1>
                <div class="col-md-7 my-5 mx-auto align-items-center d-flex justify-content-center" id="profile-wall">
                    <div class="d-flex flex-column align-items-center p-3 py-5">
                        <img src="{{ asset($userImagePath) }}" class="rounded-circle" id="profile-image">
                        <h1 class="display-3 text-uppercase mb-0 text-white">{{ auth()->user()->name }}</h1>
                        <p class="text-gray">{{ auth()->user()->email }}</p>
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="btn btn-danger profile-button" type="button">
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-md-4 my-5 mx-auto">
                    <div class="p-3  py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right text-white">{{ __('Gender') }}</h4>
                        </div>
                        <form action="/profile/updateGender/{id}" method="POST">
                            @csrf
                            <div class="col-md-12">  
                                <select class="form-control" name="{{ $genderColumn }}">
                                    @foreach ($genders as $option)
                                    <option name="{{ $genderColumn }}" value="{{ $option }}" {{ $option==$selectedGender
                                        ? 'selected' : '' }}>
                                        {{ __($option) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="my-5 text-center">
                                <button type="submit" class="btn btn-primary profile-button" type="button">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </form>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right text-white">{{ __('Preferences') }}</h4>
                        </div>
                        <form action="/profile/updatePreference/{id}" method="POST">
                            @csrf
                            <div class="col-md-12">
                                @foreach ($columns as $column => $label)
                                <label for="{{ $column }}" class="labels">{{ __($label) }}</label>
                                <select class="form-control" name="{{ $column }}">
                                    @foreach ($options[$column] as $option)
                                    <option name="$column" value="{{ $option }}" {{ $option==$selected[$column]
                                        ? 'selected' : '' }}>
                                        {{ __($option) }}
                                    </option>
                                    @endforeach
                                </select>
                                @endforeach
                            </div>
                            <div class="my-5 text-center">
                                <button type="submit" class="btn btn-primary profile-button" type="button">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-5 container rounded border border-dark bg-dark" id="edit">
            <h1 class="text-white m-3 text-uppercase mb-0">{{ __('Edit profile') }}</h1>
            <div class="edit_container text-white">
                <div class="edit_slider"></div>
                <div class="edit_btn">
                    <button class="edit_det">{{ __('Details') }}</button>
                    <button class="edit_cred">{{ __('Credentials') }}</button>
                </div>
                <div class="edit_form-section">
                    <!-- edit_det form -->
                    <form method="POST" action="/profile/updateDetails/{id}" enctype="multipart/form-data">
                        @csrf
                        <div class="edit_det-box">
                            <input name="name" type="text" class="edit_field" placeholder="{{ __('new Username') }}">
                            @error('name')
                            <?php notify()->error(__($message)) ?>
                            @enderror
                            <input name="image" type="file" id="profile-img" placeholder="{{ __('Upload Image') }}">
                            @error('image')
                                <?php notify()->error(__($message)) ?>
                            @enderror
                            <button type="submit" class="edit_clkbtn btn btn-primary">{{ __('Save') }}</button>
                        </div>
                    </form>
                    <!-- edit_cred form -->
                    <form method="POST" action="/profile/updateCredentials/{id}">
                        @csrf
                        <div class="edit_cred-box">
                            <input name="email" type="email" class="edit_field" placeholder="{{ __('new Email') }}">
                            @error('email')
                            <?php notify()->error(__($message)) ?>
                            @enderror
                            <input name="password" type="password" class="edit_field" placeholder="{{ __('new Password') }}">
                            @error('password')
                            <?php notify()->error(__($message)) ?>
                            @enderror
                            <input name="password_confirmation" type="password" class="edit_field" placeholder="{{ __('new Confirm Password') }}">
                            <button class="edit_clkbtn btn btn-primary">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="my-5 container rounded border border-dark bg-dark" id="delete">
            <h1 class="text-white m-3 text-uppercase mb-0">{{ __('Delete profile') }}</h1>
            <div class="container">
                <form method="POST" action="/users/{{ Auth::user()->id }}" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <div class="form-group">
                        <label for="current_password">{{ __('Current Password') }}</label>
                        <input type="password" name="current_password" id="current_password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-danger m-5">{{ __('Delete Account') }}</button>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/profile_edit.js') }}"></script>
</x-layout>
@endauth