@extends('layouts.app')

@section('content')
<div class="col">
    <div class="card">
        <div class="card-header">Reset Password</div>
        <div class="card-block">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form role="form" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                    <label for="email">E-Mail Address</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <p class="form-text text-muted">{{ $errors->first('email') }}</p>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
            </form>
        </div>
    </div>
</div>
@endsection
