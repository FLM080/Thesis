<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Rubik&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>Document</title>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</head>

<body class="height-100vh">


    <!-- Header Start -->
    <div class="container-fluid bg-dark px-0">
        <div class="row gx-0">
            <div class="col-lg-3 bg-dark d-none d-lg-block">
                <a href="/" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                    <h1 class="m-0 display-4 text-primary text-uppercase">WPM</h1>
                </a>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0 px-lg-5">
                    <a href="/" class="navbar-brand d-block d-lg-none">
                        <h1 class="m-0 display-4 text-primary text-uppercase">WPM</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                        data-bs-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="/" class="nav-item nav-link">Home</a>
                            <a href="about.html" class="nav-item nav-link">plan your workout</a>
                            <a href="class.html" class="nav-item nav-link">Famous workouts</a>
                            <a href="trainer.html" class="nav-item nav-link">Give us feedback</a>
                        </div>

                </nav>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- output-->
    {{ $slot }}

    <!-- Footer Start -->
    <div class="container-fluid py-4 py-lg-0 px-5 fixed-bottom bg-dark">
        <div class="row gx-5">
            <div class="py-lg-4 text-center">
                <p class="text-secondary mb-0">&copy; All Rights Reserved.</p>
            </div>
        </div>
    </div>
    <!-- Footer End -->
    
</body>

</html>