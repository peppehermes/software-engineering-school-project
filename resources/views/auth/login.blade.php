@extends('layouts.layout')

@section('content')
    <div class="error-pagewrap">
        <div class="error-page-int">
            <div class="text-center m-b-md custom-login">
                <h3>LOGIN</h3>
            </div>
            <div class="content-error">
                <div class="hpanel">
                    <div class="panel-body">
                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf
                            <div class="form-group">
                                <label class="control-label" for="username">{{ __('E-Mail Address') }}</label>
                                <input type="email"  title="Please enter you username" required="" value="{{ old('email') }}" name="email" @error('email') is-invalid @enderror id="username" class="form-control" autocomplete="email" autofocus>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">{{ __('Password') }}</label>
                                <input type="password" title="Please enter your password"  name="password" id="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="checkbox login-checkbox">
                                <label>
                                    <input type="checkbox" class="i-checks" name="remember" {{ old('remember') ? 'checked' : '' }}>  {{ __('Remember Me') }}</label>
                                <p class="help-block small">(if this is a private computer)</p>
                            </div>
                            <button class="btn btn-success btn-block loginbtn" type="submit">{{ __('Login') }}</button>
                            @if (Route::has('password.request'))
                                <label class="hover">
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                </label>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            <div class="text-center login-footer">
                <p>Copyright © 2019. All rights reserved</p>
            </div>
        </div>
    </div>
@endsection
