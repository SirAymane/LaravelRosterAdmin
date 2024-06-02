<!-- Start of custom header -->
<div class="sticky-top bg-primary">
    <div class="container">
        <div class="row">
            <nav class="row navbar navbar-expand-lg navbar-dark">
                <div class="container-fluid gap-5">
                    <!-- Favicon definition-->
                <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
                    <!-- Start of navbar-brand -->
                    <a class="navbar-brand" href="/">
                        <!-- Start of navbar icon -->
                        <img id="navbar-icon" src="{{ asset('images/navbar_nba_icon.png') }}">
                        <!-- End of navbar icon -->
                    </a>
                    <!-- End of navbar-brand -->
                    <!-- Start of navbar toggler -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <!-- End of navbar toggler -->

                    <!-- Start of navbar items -->
                    <div class="collapse navbar-collapse" id="navbarColor02">
                        <ul class="navbar-nav me-auto">
                            <!-- Start of home item -->
                            <li class="nav-item">
                                <a class="nav-link active" href="/">Homepage
                                    <span class="visually-hidden">(current)</span>
                                </a>
                            </li>
                            <!-- End of home item -->

                            <!-- Start of manage teams item -->
                            <li class="nav-item">
                                <a class="nav-link" href="/teams/manage">Manage Teams</a>
                            </li>
                            <!-- End of manage teams item -->

                            <!-- Start of manage players item -->
                            <li class="nav-item">
                                <a class="nav-link" href="/players/manage">Manage Players</a>
                            </li>
                            <!-- End of manage players item -->
                        </ul>
                    </div>
                    <!-- End of navbar items -->
                </div>
            </nav>
        </div>
    </div>

</div>
<!-- End of custom header -->
<header>
</header>