@extends('settings.layout')

@section('settings_title')
    <h2 class="title-larger">{{ __('general.account') }}</h2>
@endsection

@section('settings_body')
    <div class="box">
        <div class="box__section">
            <div class="input input--small">
                <label>{{ __('settings.email') }}</label>
                <input type="text" name="email" value="{{ Auth::user()->email }}" />
            </div>
            <div class="row">
                <div class="row__column input">
                    <label>{{ __('settings.password') }}</label>
                    <input type="password" name="password" />
                    @include('partials.validation_error', ['payload' => 'password'])
                </div>
                <div class="row__column input ml-2">
                    <label>{{ __('actions.verify') }} {{ __('settings.password') }}</label>
                    <input type="password" name="password_confirmation" />
                    @include('partials.validation_error', ['payload' => 'password_confirmation'])
                </div>
            </div>
            <button class="button">{{ __('actions.save') }}</button>
        </div>
    </div>
@endsection
