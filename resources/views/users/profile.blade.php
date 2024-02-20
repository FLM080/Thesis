@auth
<x-layout>
    <div id="profile-main">
        <div class="container my-5 rounded border border-dark bg-dark">
            <div class="row">
                <h1 class="text-white m-3 text-uppercase mb-0">{{ __('Profile Page') }}</h1>
                <div class="col-md-7 my-5 mx-auto align-items-center d-flex justify-content-center" id="profile-wall">
                    <div class="d-flex flex-column align-items-center p-3 py-5">
                        <img src="{{ asset(file_exists(public_path('images/profile/' . auth()->user()->id . '.jpg')) ? 'images/profile/' . auth()->user()->id . '.jpg' : 'images/profile/Default.jpg') }}"
                            class="rounded-circle" id="profile-image">
                        <h1 class="display-3 text-uppercase mb-0 text-white">{{ auth()->user()->name }}</h1>
                        <p class="text-gray">{{ auth()->user()->email }}</p>
                        <a href="" class="btn btn-danger profile-button">{{ __('Logout') }}</a>
                    </div>
                </div>
                <div class="col-md-4 my-5 mx-auto">
                    <div class="p-3  py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right text-white">{{ __('Gender') }}</h4>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="labels">Goal</label>
                            <select class="form-control">
                                <option value="option1">Option 1</option>
                                <option value="option2">Option 2</option>
                                <option value="option3">Option 3</option>
                            </select>
                        </div>
                        <div class="my-5 text-center">
                            <button class="btn btn-primary profile-button" type="button">
                                {{ __('Save') }}
                            </button>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right text-white">{{ __('Preferences') }}</h4>
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Goal</label>
                            <select class="form-control">
                                <option value="option1">Option 1</option>
                                <option value="option2">Option 2</option>
                                <option value="option3">Option 3</option>
                            </select>
                            <label class="labels">Goal</label>
                            <select class="form-control">
                                <option value="option1">Option 1</option>
                                <option value="option2">Option 2</option>
                                <option value="option3">Option 3</option>
                            </select>
                            <label class="labels">Goal</label>
                            <select class="form-control">
                                <option value="option1">Option 1</option>
                                <option value="option2">Option 2</option>
                                <option value="option3">Option 3</option>
                            </select>
                        </div>
                    </div>
                    <div class="my-5 text-center">
                        <button class="btn btn-primary profile-button" type="button">
                            {{ __('Save') }}
                        </button>
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
                    <div class="edit_det-box">
                        <input type="text" class="edit_field" placeholder="{{ auth()->user()->name }}">

                        <button class="edit_clkbtn btn btn-primary">{{ __('Save') }}</button>
                    </div>

                    <!-- edit_cred form -->
                    <div class="edit_cred-box">
                        <input type="email" class="edit_field" placeholder="{{ auth()->user()->email }}">
                        <input type="password" class="edit_field" placeholder="password">
                        <input type="password" class="edit_field" placeholder="Confirm password">
                        <button class="edit_clkbtn btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/profile_edit.js') }}"></script>
</x-layout>
@endauth