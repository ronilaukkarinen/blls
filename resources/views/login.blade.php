@extends('layout')

@section('body')
    <div class="wrapper wrapper--narrow my-3">
        <h2 class="text-center mb-3">Log in</h2>
        @if (session('alert_type') && session('alert_message'))
            @include('partials.alerts.' . session('alert_type'), ['payload' => ['classes' => 'mb-2', 'message' => session('alert_message')]])
        @endif
        <div class="box">
            <div class="box__section">
                <form method="POST">
                    {{ csrf_field() }}
                    <div class="input">
                        <label>{{ __('login.email') }}</label>
                        <input type="email" name="email" value="{{ old('email') }}" />
                    </div>
                    <div class="input">
                        <label>{{ __('login.password') }}</label>
                        <input type="password" name="password" />
                    </div>
                    <div class="row row--separate" style="justify-content: space-between;">
                        <div class="row__column row__column--compact">
                            <button class="button">{{ __('login.login') }}</button>
                        </div>
                        <div class="row__column row__column--compact row__column--middle">
                            <a href="/reset-password">{{ __('login.forgot_password_question') }}</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box__section box__section--highlight text-center">
                <a href="/register">{{ __('login.new_user_question') }}</a>
            </div>
        </div>
    </div>
@endsection
