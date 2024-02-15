<x-registerLayout>
    <div id="registerOuter" class="container-fluid ">
        <div class="row gx-5">
            <div class="col-lg-5 mb-5 mb-lg-0" style="min-height: 500px;">
                <div class="position-relative h-100">
                    <div class="position-absolute w-100 h-100 " id="registerImg"
                        style="background-image: url('{{asset('images/hero-1.jpg')}}');"></div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="mb-4">
                    <h1 class="display-3 text-uppercase mb-0">{{ __('Create an Account') }}</h1>
                </div>
                <form method="POST" action="/users">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input type="text" class="form-control" name="name" value="{{old('name')}}">
                        @error('name')
                        <p class="text-danger">{{__($message)}}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{old('email')}}">
                        @error('email')
                        <p class="text-danger">{{__($message)}}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input type="password" class="form-control" id="password" name="password"
                            value="{{old('password')}}">
                        @error('password')
                        <p class="text-danger">{{__($message)}}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                        <input type="password" class="form-control" name="password_confirmation"
                            value="{{old('password_confirmation')}}">
                    </div>
                    <button type="submit" class="btn  btn-primary">{{ __('Register') }}</button>
                    <div>
                        <label for="already_member" class="mt-3">{{ __('Already a member') }}?</label>
                        <a class="pb-5" href="/login">{{ __('Login') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-registerLayout>