<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>LaunchPad demo</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{asset('css/home.css')}}" rel="stylesheet">

    <!-- Temporary navbar container fix -->
    <style>
    .navbar-toggler {
        z-index: 1;
    }
    
    @media (max-width: 576px) {
        nav > .container {
            width: 100%;
        }
    }
    </style>

</head>

<body id="page-top">

    <!-- Navigation -->
    <nav id="mainNav" class="navbar fixed-top navbar-toggleable-md navbar-light">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarExample" aria-controls="navbarExample" aria-expanded="false" aria-label="Toggle navigation">
            Menu <i class="fa fa-bars"></i>
        </button>
        <div class="container">
            <a class="navbar-brand" href="#page-top">LaunchPad</a>
            <div class="collapse navbar-collapse" id="navbarExample">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#goals">Goals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#mentors">Mentors</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Intro Header -->
    <header class="masthead">
        <div class="intro-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
            <img src="img/logo.png" class="img-fluid logo">
                        <h1 class="brand-heading">LaunchPad</h1>
                        <p class="intro-text"><a href="{{ action('PageController@showApplicationForm') }}"" class="btn btn-primary btn-lg">APPLY</a></p>
                        <a href="#about" class="btn btn-circle page-scroll">
                            <i class="fa fa-angle-double-down animated"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- About Section -->
    <div class="about_wrap">
      <section id="about" class="container content-section text-center">
          <div class="row">
              <div class="col-md-10 offset-md-1">
                  <h2>About</h2>
                  text about history of launchpad, why it exists, etc.
              </div>
          </div>
      </section>
    </div>

    <div class="goals_wrap">
      <section id="goals" class="container content-section text-center">
          <div class="row">
              <div class="col-md-12">
                  <h2>Goals</h2>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="goals-box">
                            <i class="fa fa-heart fa-4x" aria-hidden="true"></i>
                            <h3>MENTORSHIP</h3>
                            <p>PLACEHOLDER: Guide your first semester with a seasoned upperclassmen who will help you with everything</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                      <div class="goals-box">
                            <i class="fa fa-code-fork fa-4x" aria-hidden="true"></i>
                            <h3>LEARN</h3>
                            <p>PLACEHOLDER: Learn useful and marketable skills outside of the classroom, like mobile and web development.</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                      <div class="goals-box">
                            <i class="fa fa-globe fa-4x" aria-hidden="true"></i>
                            <h3>COMMUNITY</h3>
                            <p>PLACEHOLDER: Gain a sense of belonging, and join a community of passionate and driven students</p>
                        </div>
                    </div>
            <div class="col-md-3">
                      <div class="goals-box">
                            <i class="fa fa-wrench fa-4x" aria-hidden="true"></i>
                            <h3>BUILD</h3>
                            <p>PLACEHOLDER: Build cool shit</p>
                        </div>
                    </div>
                  </div>
              </div>
          </div>
      </section>
    </div>
    <section id="mentors" class="content-section">
      <div class="album text-muted">
        <div class="container">
        <h2 class="text-center">Mentors</h2>
          <div class="row">
            <div class="card">
              <img src="http://placehold.it/350x350" alt="Card image cap" class="img-fluid">
              <div class="card-text">
                  <h5 style="margin-top:0px">Cool Mentor <small class="text-muted">Enjoys doing x y and z blah blah blah 140 characters.</small></h5>
                  <div class="row">
                      <div class="col-6">
                      <a href="#" class="btn btn-secondary btn-sm">View Profile</a>
                      </div>
                      <div class="col-sm-6 text-right hidden-sm-down">
                        <a href="#" class="social_link"><i class="fa fa-snapchat-square fa-2x" aria-hidden="true"></i></a>
                        <a href="#" class="social_link"><i class="fa fa-facebook-official fa-2x" aria-hidden="true"></i></a>
                        <a href="#" class="social_link"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a>
                      </div>
                      <div class="col-sm-12 hidden-md-up">
                        <a href="#" class="social_link"><i class="fa fa-snapchat-square fa-2x" aria-hidden="true"></i></a>
                        <a href="#" class="social_link"><i class="fa fa-facebook-official fa-2x" aria-hidden="true"></i></a>
                        <a href="#" class="social_link"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a>
                      </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p>Copyright &copy; LaunchPad 2017</p>
        </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="{{ asset('js/tether.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="{{asset('js/jquery.easing.min.js')}}"></script>
    <script src="{{asset('js/grayscale.js')}}"></script>

</body>

</html>
