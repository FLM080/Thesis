@if (request()->is('/'))
<div class="container-fluid bg-dark text-secondary px-5 mt-5">
    <div class="row gx-5">
        <h4 class="text-uppercase text-light mb-4 text-center pt-3">{{ __('Quick Links') }}</h4>
        <div class="d-flex flex-row justify-content-center">
            <a class="text-secondary mb-2 me-3" href="{{ route('home') }}"><i class="bi bi-arrow-right text-primary me-2"></i>{{ __('Home') }}</a>
            <a class="text-secondary mb-2 me-3" href="{{ route('workoutPlanner') }}"><i class="bi bi-arrow-right text-primary me-2"></i>{{ __('Plan Your Workout') }}</a>
            <a class="text-secondary mb-2 me-3" href=""><i class="bi bi-arrow-right text-primary me-2"></i>{{ __('Famous Workouts') }}</a>
            <a class="text-secondary mb-2 me-3" href=""><i class="bi bi-arrow-right text-primary me-2"></i>{{ __('Give Us Feedback') }}</a>
        </div>
    </div>
</div>
@endif
<div class="container-fluid py-4 py-lg-0 px-5" id="footer">
    <div class="row gx-5">
        <div class="py-lg-4 text-center">
            <p class="text-secondary mb-0">&copy;All Rights Reserved.</p>
        </div>
    </div>
</div>
<x-notify::notify />
@notifyJs