@extends('layout')

@section('title', 'Reset Password')

@section('body')
    <div class="login-wrapper">
        <div class="box">

        <h1 class="logo"><?php echo file_get_contents( 'svg/dashboard/logo.svg' ); ?>blls</h1>
        <h2 class="text-center mb-3">Reset Password</h2>
        <p class="login-desc">Forgot password? Reset below.

        <div class="box">
            <div class="box__section">
                <form method="POST">
                    {{ csrf_field() }}
                    @if ($token)
                        <input type="hidden" name="token" value="{{ $token }}" />
                        <div class="input">
                            <label class="screen-reader-text">Password</label>
                            <input type="password" name="password" placeholder="Password" />
                        </div>
                        <div class="input">
                            <label class="screen-reader-text">Verify Password</label>
                            <input type="password" name="password_confirmation" placeholder="Verify password" />
                        </div>
                    @else
                        <div class="input">
                            <label class="screen-reader-text">E-mail</label>
                            <input type="email" name="email" placeholder="E-mail" />
                        </div>
                    @endif
                    <button class="button">Submit</button>

                    <hr>
                    <div class="field links">
                      <a href="/login">{{ __('login.back_to_login') }}</a> {{ __('login.or_conjuction') }} <a href="/register">{{ __('login.new_user_question') }}</a>
                    </div>

                </form>
              </div>
        </div>
    </div>
    </div>
@endsection
