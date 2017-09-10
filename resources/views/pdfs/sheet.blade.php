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

/* Material Design Lists - by Roko CB
 - https://www.google.com/design/spec/components/lists.html
 - http://stackoverflow.com/a/33312676/383904
*/

/*
Material Design - Icons
*/

[class^=mad-icon-]{
  display: inline-block;
  vertical-align: top;
  border-radius: 50%;
  background: #999 50% / cover;
  color: #fff;
}

/*
Material Design - Lists
*/

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
ul.mad-list li > *:last-child{
  /* Whoever is the last child it needs 16 right space */
  padding-right: 16px;
}
ul.mad-list .mad-list-icon{
  /* Always left-align! Don't center icons */
  width: 72px; /* 72-16 but we already use box-sizing */
}
ul.mad-list .mad-list-text{
	padding-left: 10px;
  /*background: rgba(0,0,255,0.05);*/
}

/*
Special classes
*/
.border-bottom{
  border-bottom:1px solid rgba(0,0,0,0.1);
}

</style>
<ul class="mad-list">
@foreach($data as $user)
  <li>
    <div class="mad-list-icon">
      <img src="{{asset('storage/uploads/' . $user->image)}}" style="height:73px;">
    </div>
    <div class="mad-list-text border-bottom">
      <p>
        <b>{{$user->name}}</b><br>
        {{$user->about}}
      </p>
    </div>
  </li>
@endforeach
</ul>