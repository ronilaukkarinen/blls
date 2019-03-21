@extends('settings.layout')

@section('settings_title')
    <h2 class="mb-3">{{ __('general.preferences') }}</h2>
@endsection

@section('settings_body')
    <div class="box">
        <div class="box__section">
            <div class="input input--small">
                <label>{{ __('fields.language') }}</label>
                <select name="language">
                    @foreach ($languages as $key => $value)
                        <option value="{{ $key }}" @if (Auth::user()->language === $key) selected @endif>{{ $value }}</option>
                    @endforeach
                </select>
                @include('partials.validation_error', ['payload' => 'language'])
            </div>
            <div class="input input--small">
                <label>{{ __('fields.currency') }}</label>
                <select name="currency">
                    @foreach ($currencies as $currency)
                        <option value="{{ $currency->id }}" {{ Auth::user()->currency_id == $currency->id ? 'selected' : '' }}>{!! $currency->symbol !!} &middot; {{ $currency->name }}</option>
                    @endforeach
                </select>
                @include('partials.validation_error', ['payload' => 'currency'])
            </div>
            <button class="button">{{ __('actions.save') }}</button>
        </div>
    </div>
@endsection
