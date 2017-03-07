@extends('layouts.app')

@section('content')
<div class="col">
    <div class="card">
        <div class="card-header">Registration</div>
        <div class="card-block">
            <form role="form" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                    <label for="name">Name</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                    @if ($errors->has('name'))
                        <p class="form-text text-muted">{{ $errors->first('name') }}</p>
                    @endif
                </div>
        
                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                    <label for="email">E-Mail Address</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <p class="form-text text-muted">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                </div>
        
                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                        @if ($errors->has('password'))
                            <p class="form-text text-muted">
                                {{ $errors->first('password') }}
                            </p>
                        @endif
                </div>
        
                <div class="form-group">
                    <label for="password-confirm">Confirm Password</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
</div>
@endsection