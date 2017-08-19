<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="LaunchPad is a community at Purdue University, of students dedicated to learning, building, and growing together. We provide a one-on-one, semester-long mentorship program to help freshmen students hit the ground running. Our goal is to ensure that every incoming student is equipped with the knowledge and connections they’ll need to get the most out of their time at Purdue.">
    <meta property="og:description" content="LaunchPad is a community of students dedicated to learning, building, and growing together. We provide a one-on-one, semester-long mentorship program to help freshmen students hit the ground running by providing guidance, knowledge, and connections." />
    <meta name="author" content="LaunchPad Purdue">
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
                      <a class="nav-link" href="#mission">Mission</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#sponsors">Sponsors</a>
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
                      <a href="#mission" class="btn btn-circle page-scroll">
                          <i class="fa fa-angle-double-down animated"></i>
                      </a>
                  </div>
              </div>
          </div>
      </div>
  </header>
  <div class="about_wrap">
    <section id="mission" class="container content-section text-center">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <h1>MISSION</h1>
                <div style="text-align: left">
                  LaunchPad is a community of students dedicated to learning, building, and growing together. We provide a one-on-one, semester-long mentorship program to help freshmen students hit the ground running. We pair each incoming student with a talented upperclassman who will introduce them to the CS community at Purdue and guide them in creating a technical project of their choosing. Throughout the semester, we host events to foster a sense of community and to build technical skills. Our goal is to ensure that every incoming student is equipped with the knowledge and connections they’ll need to get the most out of their time at Purdue.
                </div>
            </div>
        </div>
    </section>
  </div>
  <div class="sponsors_wrap">
    <section id="sponsors" class="container content-section-less-pad text-center">
      <div class="row">
        <div class="col-md-12">
          <h1>SPONSORS</h1>
          <div class="row">
          	<div class="col-md-6">
              <a href="https://careers.google.com/students/" target="_blank"><img src="{{asset('img/google.svg')}}" class="s-logo img-fluid" style="max-height: 80px"></a>
            </div>
          	<div class="col-md-6">
              <a href="https://www.capitalonecareers.com/search-jobs" target="_blank"><img src="{{asset('img/capitalone.png')}}" class="s-logo img-fluid" style="max-height: 80px"></a>
            </div>
            <br/><br/>
            <div class="col-md-6" style="margin-top: 40px;">
              <a href="https://www.bloomberg.com/" target="_blank"><img src="{{asset('img/bloomberg-logo.png')}}" class="s-logo img-fluid" style="max-height: 60px"></a>
            </div>
            <div class="col-md-6" style="margin-top: 40px;">
              <a href="http://techpoint.org/techpoint-x/" target="_blank"><img src="{{asset('img/techpoint.png')}}" class="s-logo img-fluid"></a>
            </div>
            <div class="col-md-12" style="margin-top:50px">
              <a href="https://mimirhq.com/" target="_blank"><img src="{{asset('img/mimir.svg')}}" style="max-height:90px;"></a>
            </div>
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
                <p>Learn useful and marketable skills outside of the classroom, like communication, teamwork, and mobile and web development.</p>
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
              <img src="{{asset('storage/uploads/' . $mentor->image)}}" alt="Card image cap">
              <div class="card-text">
                  <h5 class="mentor-heading">{{$mentor->name}} <small class="text-muted">{{$mentor->tagline}}</small></h5>
                  <div class="row">
                      <div class="col-6">
                      <a href="#" class="btn btn-secondary btn-sm profile-btn" data-toggle="modal" data-target="#exampleModal" data-name="{{$mentor->name}}" data-tagline="{{$mentor->tagline}}" data-about="{{$mentor->about}}" data-url="{{asset('storage/uploads/' . $mentor->image)}}">View Profile</a>
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
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-17806840-31', 'auto');
  ga('send', 'pageview');

  </script>
</body>
</html>