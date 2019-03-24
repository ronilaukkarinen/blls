@extends('settings.layout')

@section('settings_title')
    <h2 class="title-larger">{{ __('general.preferences') }}</h2>
@endsection

@section('settings_body')
    <div class="box">
        <div class="box__section">
            <div class="input input--small">
                <label>{{ __('settings.language') }}</label>
                <select name="language">
                    @foreach ($languages as $key => $value)
                        <option value="{{ $key }}" @if (Auth::user()->language === $key) selected @endif>{{ $value }}</option>
                    @endforeach
                </select>
                @include('partials.validation_error', ['payload' => 'language'])
            </div>
            <div class="input input--small">
                <label>{{ __('settings.currency') }}</label>
                <select name="currency">
                    @foreach ($currencies as $currency)
                        <option value="{{ $currency->id }}" {{ Auth::user()->currency_id == $currency->id ? 'selected' : '' }}>{!! $currency->symbol !!} &middot; {{ $currency->name }}</option>
                    @endforeach
                </select>
                @include('partials.validation_error', ['payload' => 'currency'])
            </div>
            <div class="input input--small">
                <label>{{ __('settings.ebillingprovider') }}</label>
                <select name="ebillprovider" id="ebillprovider">
                  <option value="Osuuspankki">Osuuspankki</option>
                </select>
            </div>
            <button class="button">{{ __('actions.save') }}</button>
        </div>
    </div>
@endsection
