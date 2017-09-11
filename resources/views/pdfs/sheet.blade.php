<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
.item {
	padding: 10px;
}
*{
  box-sizing: border-box;
}
body{
  margin: 0;
  font:   16px/1.3 'Roboto', sans-serif;
  color:  #333;
}
h1, h2{
  font-weight:200;
}

[class^=mad-icon-]{
  display: inline-block;
  vertical-align: top;
  border-radius: 50%;
  background: #999 50% / cover;
  color: #fff;
}

ul.mad-list{
  display: table;
  width: 100%;
  padding: 8px 0; /* 8 padding T/B */
  margin: 0;
  list-style: none;
}
ul.mad-list li{
  display: table-row;
  height: 48px; /* that's actually min-height for rows */
}
ul.mad-list li > *{
  /* Align always to middle */
  display: table-cell;
  margin: 0;
  padding: 0;
  vertical-align: middle;
}
ul.mad-list li > *:first-child{
  /* Whoever is the first child it needs 16px left space */
  padding-left: 16px;
  /*background: rgba(0,255,0,0.05);*/
}
ul.mad-list .mad-list-icon{
  /* Always left-align! Don't center icons */
  width: 72px; /* 72-16 but we already use box-sizing */
}
ul.mad-list .mad-list-text{
	padding-left: 10px;
  /*background: rgba(0,0,255,0.05);*/
}
ul.mad-list .mad-list-icon-secondary{
  /* Secundary actions will have already 16 right padding 
  since it's :last-child but it needs also a left 16*/
  padding-left: 5px;
  width: 1px; /* Always h-center align content */
  text-align: center; /* Just to make sure if we use combinations of larger icons */
/*  background: rgba(255,0,255,0.05)*/
}
/*
Special classes
*/
.border-bottom{
  border-bottom:1px solid rgba(0,0,0,0.1);
}
.profilepic {
	height: 73px;
}
.snap {
	height: 73px;
}
</style>
<ul class="mad-list">
@foreach($data as $user)
  <li>
    <div class="mad-list-icon">
      <img src="{{asset('storage/uploads/' . $user->image)}}" class="profilepic">   
    </div>
    <div class="mad-list-text border-bottom">
      <p>
        <b>{{$user->name}}</b><br>
        {{$user->about}}
      </p>
    </div>
       @if($user->snapchat)
     	<div class="mad-list-icon-secondary">
     		<img src="{{asset('storage/snap/' . $user->snapchat)}}" class="snap">
     	</div>
        @endif       
  </li>
@endforeach
</ul>