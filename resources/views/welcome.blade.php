<!DOCTYPE html>
<html>
<head>
    <title>Basketball Manager</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    @extends('layout')
    @section('content')
    <div class="container my-5">
        <div class="row">
            <!-- Jumbotron -->
            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4">Welcome to League Manager</h1>
                    <p class="lead">Easily manage your basketball teams and players with our platform.</p>
                </div>
            </div>
        <!-- Features Section -->
        <section class="features">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Team Management</h5>
                                <p class="card-text">
                                Create and manage your basketball teams with ease. Keep track of players, budget and more, and take your team to the next level.

                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Player Management</h5>
                                <p class="card-text">
                                Manage and track your players effortlessly, including stats, roster information and more. Build a winning team with the right players.

                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Transfers and signings </h5>
                                <p class="card-text">
                                Choose your team members and improve your player transfer. Make better decisions, and lead your team to victory.

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="d-flex justify-content-center">
            <img style="max-width: 25rem;" src="{{ asset('images/central_image.png') }}">
        </div>

    </div>
</div>
@endsection
</body>
</html>