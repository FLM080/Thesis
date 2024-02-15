@auth
<x-layout>
    <div id="profile-main">
    <div class="container rounded border border-dark bg-dark" >
        <div class="row">
            <div class="col-md-5 my-5" id="profile-wall">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img src="{{ asset(file_exists(public_path('images/profile/' . auth()->user()->id . '.jpg')) ? 'images/profile/' . auth()->user()->id . '.jpg' : 'images/profile/Default.jpg') }}"
                    class="h-100 w-75 rounded-circle"> 
                    <h1 class="display-3 text-uppercase mb-0 text-white">{{ auth()->user()->name }}</h1>
                    <p class="text-gray">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <div class="col-md-3 my-5" id="profile-wall">
                <div class="p-3  py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right text-white">Preferences</h4>
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
                <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="button">Save Profile</button></div>
            </div>
            <div class="col-md-4 ">
                <div class="p-3 py-5">
                    <div class="mt-5 ">
                        <a href="" class="btn btn-primary m-5 profile-button">Edit Profile</a>
                        <a href="" class="btn btn-danger m-5 profile-button">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layout>
@endauth

