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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
function moveCard(card) {
    if ($(card).parent().hasClass('wrapper-left')) {
        // Move the card to the right
        $(card).remove();
        $('.wrapper-right').append(card);
    } else if ($(card).parent().hasClass('wrapper-right')) {
        // Move the card to the left
        $(card).remove();
        $('.wrapper-left').append(card);
    }
}
</script>
</x-layout>
                