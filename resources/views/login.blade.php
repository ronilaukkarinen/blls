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
                        <label>Sähköposti</label>
                        <input type="email" name="email" value="{{ old('email') }}" />
                    </div>
                    <div class="input">
                        <label>Salasana</label>
                        <input type="password" name="password" />
                    </div>
                    <div class="row row--separate" style="justify-content: space-between;">
                        <div class="row__column row__column--compact">
                            <button class="button">Kirjaudu</button>
                        </div>
                        <div class="row__column row__column--compact row__column--middle">
                            <a href="/reset_password">Pääsikö unohtumaan?</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box__section box__section--highlight text-center">
                <a href="/register">Uusi Hillon käyttäjä?</a>
            </div>
        </div>
    </div>
@endsection
