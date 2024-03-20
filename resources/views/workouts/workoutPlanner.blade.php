<x-layout>
    <div class="container-fluid workoutPlanner">
        <div class="row  m-5">
            <div class=" col-md-5">
                <!-- Left container -->
                <div class="wrapper-left bg-dark">
                </div>
            </div>
            <div class="col-md-2 d-flex justify-content-center align-items-center">
                <!-- Save button -->
                <button class="btn btn-primary">Save</button>
            </div>
            <div class="col-md-5">
                <!-- Right container -->
                <div class="wrapper-right bg-dark">
                    @foreach($items as $item)
                    <div class="card" onclick="moveCard(this)">
                        <img src="{{ asset($item->imagePath) }}" alt="Exercise Image">
                        <div class="info">
                            <h4 class="text-white">{{ $item->exercise_name }}</h4>
                            <strong>Description:</strong>
                            <p> {{ $item->exercise_description }}</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Type</strong>
                                    <p>{{ $item->exercise_type }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>Strength Level:</strong>
                                    <p> {{ $item->exercise_strength_level }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/workoutPlanner.js') }}"></script>
</x-layout>