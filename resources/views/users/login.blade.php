
<x-registerLayout>
    <div class="container-fluid p-5" style="height: 80vh;">
        <div class="row gx-5" style="height: 100%;">
            <div class="col-lg-5 mb-5 mb-lg-0" style="min-height: 500px;">
                <div class="position-relative h-100">
                    <div class="position-absolute w-100 h-100" style="background-image: url('{{asset('images/hero-1.jpg')}}'); background-size: cover; background-position: center;"></div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="mb-4">
                    <h1 class="display-3 text-uppercase mb-0">Login</h1>
                </div>
                <form method="POST" action="/users/authenticate">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}">
                        @error('email')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}">
                        @error('password')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <div class="">
                        <label for="new_member" class="mt-3">New member?</label>
                        <a class="" href="/register">Register</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-registerLayout>
