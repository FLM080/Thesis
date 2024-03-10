<x-layout>

    <div class="row container-fluid">
        <div class=" col-md-5">
            <!-- Left container -->
            <div class="wrapper-left bg-dark">
            </div>
        </div>
        <div class="col-md-2 text-center ">
            <!-- Save button -->
            <button class="btn btn-primary">Save</button>
        </div>
        <div class="col-md-5 ">
            <!-- Right container -->
            <div class="wrapper-right bg-dark">
                <div class="card" onclick="moveCard(this)">
                    <img src="{{ asset('images/exercises/bench.jpg') }}">

                    <div class="info">
                        <h1>Excercise Name dasdasdasdasdasdasdasdas</h1>
                        <p>desc</p>
                        <p>type</p>
                        <p>difficulty</p>
                    </div>
                </div>
                <div class="card" onclick="moveCard(this)">
                    <img src="{{ asset('images/exercises/bench.jpg') }}">

                    <div class="info">
                        <h1>Excercise Name</h1>
                        <p>desc</p>
                        <p>type</p>
                        <p>difficulty</p>
                    </div>
                </div>
                <div class="card" onclick="moveCard(this)">
                    <img src="{{ asset('images/exercises/bench.jpg') }}">

                    <div class="info">
                        <h1>Excercise Name</h1>
                        <p>desc</p>
                        <p>type</p>
                        <p>difficulty</p>
                    </div>
                </div>
                <div class="card" onclick="moveCard(this)">
                    <img src="{{ asset('images/exercises/bench.jpg') }}">

                    <div class="info">
                        <h1>Excercise Name</h1>
                        <p>desc</p>
                        <p>type</p>
                        <p>difficulty</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/workoutPlanner.js') }}"></script>
</x-layout>