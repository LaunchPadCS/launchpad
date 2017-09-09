@extends('layouts.app')

@section('bottom_js')
    <style>
        .social {
            font-size: 15px;
        }
        .profile-holder {
            border: 1px solid rgba(0,0,0,.125);
            border-radius: .25rem;
            padding: 10px;
            margin: 5px;
        }
        .caption {
            margin-top: 10px;
        }
    </style>
    <script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/masonry.pkgd.min.js') }}"></script>
    <script>
        var $container = $('.masonry-container');
        $container.imagesLoaded( function () {
            $container.masonry({
                columnWidth: '.item',
                itemSelector: '.item'
            });   
        });  
        $('a[data-toggle=tab]').each(function () {
            var $this = $(this);
            $this.on('shown.bs.tab', function () {
                $container.imagesLoaded( function () {
                    $container.masonry({
                        columnWidth: '.item',
                        itemSelector: '.item'
                    });   
                });  
            });
        });
        $(".readMore").click(function(){
            $("#infoModalLabel").html($(this).data('name'));
            $("#text").html($(this).data('description'));
            $("#image").attr('src', $(this).data('url'));
            if($(this).data('fb') != '') {
                $("#fb").html('<i class="fa fa-facebook-official fa-2x" aria-hidden="true"></i> ' + $(this).data('fb'));
            } else {
                $("#fb").html('');
            }
            if($(this).data('instagram') != '') {
                $("#instagram").html('<i class="fa fa-instagram fa-2x" aria-hidden="true"></i> ' + $(this).data('instagram'));
            } else {
                $("#instagram").html('');
            }
            if($(this).data('snapchat') != '') {
                $("#snapchat").html('<i class="fa fa-snapchat fa-2x" aria-hidden="true"></i> ' + $(this).data('snapchat'));
            } else {
                $("#snapchat").html('');
            }
        });
</script>
@stop

@section('content')
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="infoModalLabel">title</h4>
      </div>
      <div class="modal-body" id="modal-body"> 
        <img id="image" src="" class="img-responsive" style="margin: 0 auto;max-width:400px">
        <hr/>
        <div id="fb" class="social"></div>
        <div id="instagram" class="social"></div>
        <div id="snapchat" class="social"></div>
        <hr/>
        <div id="text"></div>
        <hr/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="col">
    <div class="card">
        <div class="card-header">LaunchPad Community</div>
        <div class="card-block">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a href="#team" aria-controls="team" role="tab" data-toggle="tab" class="nav-link">Team</a>
                </li>
                <li class="nav-item">
                    <a href="#mentors" aria-controls="mentors" role="tab" data-toggle="tab" class="nav-link active" id="mentors-tab" aria-expanded="true">Mentors</a>
                </li>
                <li class="nav-item">
                    <a href="#mentees" aria-controls="mentees" role="tab" data-toggle="tab" class="nav-link">Mentees</a>
                </li>
            </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show" id="team" role="tabpanel" aria-labelledby="team-tab">
                            <br/>
                            <div class="row masonry-container">
                                @for($i = 0; $i < count($team); $i++)
                                    <div class="col-sm-6 col-md-6 item">
                                        <div class="profile-holder">
                                            @if($team[$i]['image'])
                                                <img src="{{asset('storage/uploads/' . $team[$i]['image'])}}" class="img-fluid rounded" style="display: block;margin: 0 auto;">
                                            @else
                                                <img src="{{asset('storage/uploads/default.png')}}" class="img-fluid rounded" style="display: block;margin: 0 auto;">
                                            @endif
                                            <div class="caption">
                                                <h3>{{$team[$i]['name']}}</h3>
                                                <p>{{$team[$i]['tagline']}}<p>
                                                <p><a href="#" class="btn btn-primary readMore" role="button" data-name="{{$team[$i]['name']}}" data-url="{{asset('storage/uploads/' . $team[$i]['image'])}}" data-description="{{$team[$i]['about']}}" data-fb="{{$team[$i]['fb'] or ''}}" data-instagram="{{$team[$i]['instagram'] or ''}}" data-snapchat="{{$team[$i]['snapchat'] or ''}}" data-toggle="modal" data-target="#infoModal">Read More</a></p>
                                                @if($team[$i]['fb'] || $team[$i]['instagram'] || $team[$i]['snapchat'])<hr/>@endif
                                                @if($team[$i]['fb'])
                                                    <a href="https://facebook.com/{{$team[$i]['fb']}}"><i class="fa fa-facebook-official" aria-hidden="true"></i> {{$team[$i]['fb']}}</a>
                                                @endif
                                                @if($team[$i]['instagram'])
                                                    @if($team[$i]['fb'])<br/>@endif
                                                    <a href="https://instagram.com/{{$team[$i]['instagram']}}"><i class="fa fa-instagram" aria-hidden="true"></i> {{$team[$i]['instagram']}}</a>
                                                @endif
                                                @if($team[$i]['snapchat'])
                                                    @if($team[$i]['fb'] || $team[$i]['instagram'])<br/>@endif
                                                    <i class="fa fa-snapchat" aria-hidden="true"></i> {{$team[$i]['snapchat']}}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <div class="tab-pane fade show active" id="mentors" role="tabpanel" aria-labelledby="mentors-tab">
                            <br/>
                            <div class="row masonry-container">
                                @for($i = 0; $i < count($mentors); $i++)
                                    <div class="col-sm-6 col-md-4 item">
                                        <div class="profile-holder">
                                            @if($mentors[$i]['image'])
                                                <img src="{{asset('storage/uploads/' . $mentors[$i]['image'])}}" class="img-fluid rounded" style="display: block;margin: 0 auto;">
                                            @else
                                                <img src="{{asset('storage/uploads/default.png')}}" class="img-fluid rounded" style="display: block;margin: 0 auto;">
                                            @endif
                                            <div class="caption">
                                                <h3>{{$mentors[$i]['name']}}</h3>
                                                <p>{{$mentors[$i]['tagline']}}<p>
                                                <p><a href="#" class="btn btn-primary readMore" role="button" data-name="{{$mentors[$i]['name']}}" data-url="{{asset('storage/uploads/' . $mentors[$i]['image'])}}" data-description="{{$mentors[$i]['about']}}" data-fb="{{$mentors[$i]['fb'] or ''}}" data-instagram="{{$mentors[$i]['instagram'] or ''}}" data-snapchat="{{$mentors[$i]['snapchat'] or ''}}" data-toggle="modal" data-target="#infoModal">Read More</a></p>
                                                @if($mentors[$i]['fb'] || $mentors[$i]['instagram'] || $mentors[$i]['snapchat'])<hr/>@endif
                                                @if($mentors[$i]['fb'])
                                                    <a href="https://facebook.com/{{$mentors[$i]['fb']}}"><i class="fa fa-facebook-official" aria-hidden="true"></i> {{$mentors[$i]['fb']}}</a>
                                                @endif
                                                @if($mentors[$i]['instagram'])
                                                    @if($mentors[$i]['fb'])<br/>@endif
                                                    <a href="https://instagram.com/{{$mentors[$i]['instagram']}}"><i class="fa fa-instagram" aria-hidden="true"></i> {{$mentors[$i]['instagram']}}</a>
                                                @endif
                                                @if($mentors[$i]['snapchat'])
                                                    @if($mentors[$i]['fb'] || $mentors[$i]['instagram'])<br/>@endif
                                                    <i class="fa fa-snapchat" aria-hidden="true"></i> {{$mentors[$i]['snapchat']}}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="mentees">
                            <br/>
                            content
                            <div class="row masonry-container">
                                @for($i = 0; $i < count($mentees); $i++)
                                    <div class="col-sm-6 col-md-4 item">
                                        <div class="profile-holder">
                                            @if($mentees[$i]['image'])
                                                <img src="{{asset('storage/uploads/' . $mentees[$i]['image'])}}" class="img-fluid rounded" style="display: block;margin: 0 auto;">
                                            @else
                                                <img src="{{asset('storage/uploads/default.png')}}" class="img-fluid rounded" style="display: block;margin: 0 auto;">
                                            @endif
                                            <div class="caption">
                                                <h3>{{$mentees[$i]['name']}}</h3>
                                                <p>{{$mentees[$i]['tagline']}}<p>
                                                <p><a href="#" class="btn btn-primary readMore" role="button" data-name="{{$mentees[$i]['name']}}" data-url="{{asset('storage/uploads/' . $mentees[$i]['image'])}}" data-description="{{$mentees[$i]['about']}}" data-fb="{{$mentees[$i]['fb'] or ''}}" data-instagram="{{$mentees[$i]['instagram'] or ''}}" data-snapchat="{{$mentees[$i]['snapchat'] or ''}}" data-toggle="modal" data-target="#infoModal">Read More</a></p>
                                                @if($mentees[$i]['fb'] || $mentees[$i]['instagram'] || $mentees[$i]['snapchat'])<hr/>@endif
                                                @if($mentees[$i]['fb'])
                                                    <a href="https://facebook.com/{{$mentees[$i]['fb']}}"><i class="fa fa-facebook-official" aria-hidden="true"></i> {{$mentees[$i]['fb']}}</a>
                                                @endif
                                                @if($mentees[$i]['instagram'])
                                                    @if($mentees[$i]['fb'])<br/>@endif
                                                    <a href="https://instagram.com/{{$mentees[$i]['instagram']}}"><i class="fa fa-instagram" aria-hidden="true"></i> {{$mentees[$i]['instagram']}}</a>
                                                @endif
                                                @if($mentees[$i]['snapchat'])
                                                    @if($mentees[$i]['fb'] || $mentees[$i]['instagram'])<br/>@endif
                                                    <i class="fa fa-snapchat" aria-hidden="true"></i> {{$mentees[$i]['snapchat']}}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
        </div>
    </div>
</div>
@endsection