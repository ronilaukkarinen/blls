@extends('layout')

@section('body')
    <div class="login-wrapper">
        <div class="box">

        <h2 class="text-center mb-3">{{ __('login.logintitle') }}</h2>
        <p class="login-desc">{{ __('login.logindesc') }}</p>

        @if (session('alert_type') && session('alert_message'))
            @include('partials.alerts.' . session('alert_type'), ['payload' => ['classes' => 'mb-2', 'message' => session('alert_message')]])
        @endif

            <div class="box__section">
                <form method="POST">
                    {{ csrf_field() }}
                    <div class="input">
                        <label class="screen-reader-text">{{ __('login.email') }}</label>
                        <input type="email" name="email" placeholder="{{ __('login.email') }}" value="{{ old('email') }}" />
                    </div>
                    <div class="input">
                        <label class="screen-reader-text">{{ __('login.password') }}</label>
                        <input type="password" name="password" placeholder="{{ __('login.password') }}" />
                    </div>
                    <div class="row row--separate" style="justify-content: space-between;">
                        <div class="row__column row__column--compact">
                            <button class="button">{{ __('login.login') }}</button>
                        </div>
                        <div class="row__column row__column--compact row__column--middle" style="display: none;">
                            <a href="/reset-password">{{ __('login.forgot_password_question') }}</a>
                            <a href="/register">{{ __('login.new_user_question') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
