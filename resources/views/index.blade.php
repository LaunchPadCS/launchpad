<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>LaunchPad</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{asset('css/home.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Biryani|Lato" rel="stylesheet">
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
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title"><span id="modalLabel" style="text-transform: uppercase;"></span> <small class="text-muted" id="modalTag"></small></h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <img src="" id="modalImg" style="max-width:300px" class="img-fluid img-thumbnail mx-auto d-block"><hr/>
          <span id="modalAbout"></span>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
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
                  <li class="nav-item">
                      <a class="nav-link" href="{{ action('PageController@showApplicationForm') }}">Apply</a>
                  </li>                
              </ul>
          </div>
      </div>
  </nav>
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
  <div class="about_wrap">
    <section id="about" class="container content-section text-center">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <h1>About</h1>
                <div style="text-align: left">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus vitae lobortis velit, iaculis blandit mauris. Aenean facilisis aliquet orci a tincidunt. Nullam non venenatis justo, non vehicula neque. Suspendisse iaculis a massa sit amet rutrum. Vestibulum eu erat elit. Nunc et ipsum egestas, porta orci sed, dapibus neque. Cras elementum finibus nulla. Nunc eleifend, urna ut lobortis blandit, nulla turpis feugiat est, eget ullamcorper mi ex eget odio. Fusce ac orci sit amet tellus venenatis vulputate. Quisque commodo diam turpis, ut fermentum eros viverra quis. Duis efficitur maximus tortor eget dictum. Integer iaculis felis non tempor aliquet. Nulla facilisi.
                </div>
            </div>
        </div>
    </section>
  </div>

  <div class="goals_wrap">
    <section id="goals" class="container content-section text-center">
      <div class="row">
        <div class="col-md-12">
          <h1>Goals</h1>
          <div class="row">
            <div class="col-md-3">
              <div class="goals-box">
                <i class="fa fa-heart fa-4x" aria-hidden="true"></i>
                <h3>MENTORSHIP</h3>
                <p>Navigate your first semester with the help of an experienced upperclassman.</p>
              </div>
            </div>
            <div class="col-md-3">
              <div class="goals-box">
                <i class="fa fa-code-fork fa-4x" aria-hidden="true"></i>
                <h3>LEARN</h3>
                <p>Learn useful and marketable skills outside of the classroom, like mobile and web development.</p>
              </div>
            </div>
            <div class="col-md-3">
              <div class="goals-box">
                <i class="fa fa-globe fa-4x" aria-hidden="true"></i>
                <h3>COMMUNITY</h3>
                <p>Gain a sense of belonging, and join a community of passionate and driven students.</p>
              </div>
            </div>
            <div class="col-md-3">
              <div class="goals-box">
                <i class="fa fa-wrench fa-4x" aria-hidden="true"></i>
                <h3>BUILD</h3>
                <p>Build a side project from scratch with the help of your mentor.</p>
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
        <h1 class="text-center">Mentors</h1>
          <div class="row">
          @foreach($admins as $admin)
            <div class="card">
              <img src="{{asset('storage/uploads/' . $admin->image)}}" alt="Card image cap" class="img-fluid">
              <div class="card-text">
                  <h5 class="mentor-heading">{{$admin->name}} <small class="text-muted">{{$admin->tagline}}</small></h5>
                  <div class="row">
                      <div class="col-6">
                      <a href="#" class="btn btn-secondary btn-sm profile-btn" data-toggle="modal" data-target="#exampleModal" data-name="{{$admin->name}}" data-tagline="{{$admin->tagline}}" data-about="{{$admin->about}}" data-url="{{asset('storage/uploads/' . $admin->image)}}">View Profile</a>
                      </div>
                      <div class="col-sm-6 text-right hidden-sm-down">
                        @if($admin['fb'])
                          <a href="https://www.facebook.com/{{$admin['fb']}}" class="social_link"><i class="fa fa-facebook-official fa-2x" aria-hidden="true"></i></a>
                        @endif
                        @if($admin['github'])
                          <a href="http://github.com/{{$admin['github']}}" class="social_link"><i class="fa fa-github-square fa-2x" aria-hidden="true"></i></a>
                        @endif
                        @if($admin['linkedin'])
                          <a href="{{$admin['linkedin']}}" class="social_link"><i class="fa fa-linkedin-square fa-2x" aria-hidden="true"></i></a>
                        @endif
                        @if($admin['website'])
                          <a href="{{$admin['website']}}" class="social_link"><i class="fa fa-globe fa-2x" aria-hidden="true"></i></a>
                        @endif
                      </div>
                      <div class="col-sm-12 hidden-md-up">
                        @if($admin['fb'])
                          <a href="https://www.facebook.com/{{$admin['fb']}}" class="social_link"><i class="fa fa-facebook-official fa-2x" aria-hidden="true"></i></a>
                        @endif
                        @if($admin['github'])
                          <a href="http://github.com/{{$admin['github']}}" class="social_link"><i class="fa fa-github-square fa-2x" aria-hidden="true"></i></a>
                        @endif
                        @if($admin['linkedin'])
                          <a href="{{$admin['linkedin']}}" class="social_link"><i class="fa fa-linkedin-square fa-2x" aria-hidden="true"></i></a>
                        @endif
                        @if($admin['website'])
                          <a href="{{$admin['website']}}" class="social_link"><i class="fa fa-globe fa-2x" aria-hidden="true"></i></a>
                        @endif
                      </div>
                  </div>
              </div>
            </div>
          @endforeach
          @foreach($mentors as $mentor)
            <div class="card">
              <img src="{{asset('storage/uploads/' . $mentor->image)}}" alt="Card image cap" class="img-fluid">
              <div class="card-text">
                  <h5 style="margin-top:0px">{{$mentor->name}} <small class="text-muted">{{$mentor->tagline}}</small></h5>
                  <div class="row">
                      <div class="col-6">
                      <a href="#" class="btn btn-secondary btn-sm">View Profile</a>
                      </div>
                      <div class="col-sm-6 text-right hidden-sm-down">
                        @if($mentor['fb'])
                          <a href="https://www.facebook.com/{{$mentor['fb']}}" class="social_link"><i class="fa fa-facebook-official fa-2x" aria-hidden="true"></i></a>
                        @endif
                        @if($mentor['github'])
                          <a href="http://github.com/{{$mentor['github']}}" class="social_link"><i class="fa fa-github-square fa-2x" aria-hidden="true"></i></a>
                        @endif
                        @if($mentor['linkedin'])
                          <a href="{{$mentor['linkedin']}}" class="social_link"><i class="fa fa-linkedin-square fa-2x" aria-hidden="true"></i></a>
                        @endif
                        @if($mentor['website'])
                          <a href="{{$mentor['website']}}" class="social_link"><i class="fa fa-globe fa-2x" aria-hidden="true"></i></a>
                        @endif
                      </div>
                      <div class="col-sm-12 hidden-md-up">
                        @if($mentor['fb'])
                          <a href="https://www.facebook.com/{{$mentor['fb']}}" class="social_link"><i class="fa fa-facebook-official fa-2x" aria-hidden="true"></i></a>
                        @endif
                        @if($mentor['github'])
                          <a href="http://github.com/{{$mentor['github']}}" class="social_link"><i class="fa fa-github-square fa-2x" aria-hidden="true"></i></a>
                        @endif
                        @if($mentor['linkedin'])
                          <a href="{{$mentor['linkedin']}}" class="social_link"><i class="fa fa-linkedin-square fa-2x" aria-hidden="true"></i></a>
                        @endif
                        @if($mentor['website'])
                          <a href="{{$mentor['website']}}" class="social_link"><i class="fa fa-globe fa-2x" aria-hidden="true"></i></a>
                        @endif
                      </div>
                  </div>
              </div>
            </div>
          @endforeach
          </div>
        </div>
      </div>
    </section>

  <footer>
    <div class="container">
      <div class="row">
        <div class="col-6 text-right offset-6">
          <a href="https://www.facebook.com/launchpadcs/" class="footer_link"><i class="fa fa-facebook-official fa-2x" aria-hidden="true"></i></a>
          &nbsp;
          <a href="#" class="footer_link"><i class="fa fa-twitter-square fa-2x" aria-hidden="true"></i></a>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="{{ asset('js/tether.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <script src="{{asset('js/jquery.easing.min.js')}}"></script>
  <script src="{{asset('js/grayscale.js')}}"></script>
  <script>
    $('#exampleModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var modal = $(this)
      modal.find('#modalLabel').html(button.data('name'))
      modal.find('#modalAbout').html(button.data('about'))
      modal.find('#modalTag').html(button.data('tagline'))
      modal.find('#modalImg').attr('src', button.data('url'))
    })
  </script>
</body>
</html>