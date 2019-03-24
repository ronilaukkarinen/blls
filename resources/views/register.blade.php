@extends('layout')

@section('title', 'Register')

@section('body')
    <div class="login-wrapper">

      <div class="box">

        <h1 class="logo"><?php echo file_get_contents( 'svg/dashboard/logo.svg' ); ?>blls</h1>
        <h2 class="text-center mb-3">Sign up</h2>
        <p class="login-desc"><?php if ( 'local' == App::environment() ) : ?>Just fill your details here.<?php else : ?>Not there yet. Hang tight!<?php endif; ?></p>

            <div class="box__section">
                <form method="POST">
                    <?php if ( 'local' == App::environment() ) : ?>
                    {{ csrf_field() }}
                    <div class="input">
                        <label class="screen-reader-text">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Name" />
                        @include('partials.validation_error', ['payload' => 'name'])
                    </div>
                    <div class="input">
                        <label class="screen-reader-text">E-mail</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="E-mail" />
                        @include('partials.validation_error', ['payload' => 'email'])
                    </div>
                    <div class="input">
                        <label class="screen-reader-text">Password</label>
                        <input type="password" name="password" placeholder="Password" />
                        @include('partials.validation_error', ['payload' => 'password'])
                    </div>
                    <div class="input">
                        <label class="screen-reader-text">Verify password</label>
                        <input type="password" name="password_confirmation" placeholder="Verify password" />
                        @include('partials.validation_error', ['payload' => 'password_confirmation'])
                    </div>
                    <div class="input currency-selection">
                        <label>Currency</label>
                        <select name="currency">
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency->id }}" {{ old('currency') == $currency->id ? 'selected' : '' }}>{!! $currency->symbol !!} &middot; {{ $currency->name }}</option>
                            @endforeach
                        </select>
                        @include('partials.validation_error', ['payload' => 'currency'])
                    </div>
                    <button class="button">Sign up</button>
                    <?php endif; ?>

                    <hr>
                    <div class="field links">
                      <a href="/reset-password">{{ __('login.forgot_password_question') }}</a> {{ __('login.or_conjuction') }} <a href="/login">{{ __('login.wantlogin') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
