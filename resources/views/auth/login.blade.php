@extends('layouts.app')

@section('content')
<div class="col">
    <div class="card">
        <div class="card-header">Login</div>
        <div class="card-block">
            <form role="form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                    <label for="email">E-Mail Address</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <p class="form-text text-muted">{{ $errors->first('email') }}</p>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                    @if ($errors->has('password'))
                        <p class="form-text text-muted">{{ $errors->first('password') }}</p>
                    @endif   
                </div>
                <div class="form-check">
                     <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
                <a class="btn btn-link" href="{{ route('password.request') }}">Forgot Your Password?</a>
            </form>
        </div>
    </div>
</div>
@endsection
