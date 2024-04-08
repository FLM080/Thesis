<x-layout>


    @include('partials._carousel')


    <div class="container-fluid p-5 mb-5">
        <div class="row gx-5 d-flex justify-content-center align-items-center">
            <div class="col-lg-5 mb-5 mb-lg-0 logoImage">
                <div class="h-100">
                    <img class="w-100 h-100 rounded" src="{{asset('images/logo.png')}}">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="mb-4">
                    <h5 class="text-primary text-uppercase">{{ __('About Us') }}</h5>
                    <h1 class="display-3 text-uppercase mb-0">{{ __('Welcome to FitForge') }}</h1>
                </div>
                <h4 class="text-body mb-4">{{ __('Where the journey to a fitter, healthier you begins. We
                    understand that the path to fitness isn\'t always easy, but with our platform, you\'ll find the
                    support, guidance, and inspiration you need to make every step count.') }}</h4>
                <p class="mb-4">{{ __('At FitForge, we\'re all about personalization. Whether you\'re looking to shed a few
                    pounds, build muscle, or simply improve your overall well-being, our platform empowers you to create
                    a workout plan that fits your unique goals and lifestyle. But we don\'t stop there. We know that
                    staying motivated is key to sticking with your fitness journey, which is why we offer the option to
                    follow in the footsteps of your favorite celebrities and fitness icons.') }}</p>
                <div class="rounded bg-dark p-5">
                    <ul class="nav nav-pills justify-content-between responsive-nav">
                        <li class="nav-item responsive-nav-item mb-3">
                            <a class="nav-link text-uppercase text-center w-100 active" data-bs-toggle="pill"
                                href="#pills-1">{{ __('Making Your Own Workout') }}</a>
                        </li>
                        <li class="nav-item responsive-nav-item mb-3">
                            <a class="nav-link text-uppercase text-center w-100" data-bs-toggle="pill"
                                href="#pills-2">{{ __('Choosing a Famous Workout') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="pills-1">
                            <p class="text-secondary mb-0">{{ __('At FitForge, we empower you to curate your fitness path with
                                precision. Dive into our diverse exercise library, where you can select from an array of
                                strength training, cardio, flexibility, and endurance workouts. Mix and match routines,
                                adjust sets and reps, and tailor your plan to match your goals, schedule, and fitness
                                level. With intuitive tools and expert guidance, crafting your personalized workout
                                regimen has never been easier. Take the reins of your fitness journey and achieve
                                results that truly reflect your aspirations with FitForge.') }}</p>
                        </div>
                        <div class="tab-pane fade" id="pills-2">
                            <p class="text-secondary mb-0">{{ __('Embark on iconic fitness journeys with FitForge\'s Celebrity
                                Workouts feature. Delve into curated routines inspired by your favorite stars and
                                athletes, from Hollywood legends to sports champions. Experience firsthand the exercises
                                and training techniques that fuel their success. Whether you aspire to train like a pro
                                athlete or emulate the sculpted physique of a movie star, our platform offers a glimpse
                                into their world. Select from a range of celebrity workouts, each designed to challenge
                                and inspire you. Take your fitness to the next level and unleash your inner champion
                                with FitForge.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>