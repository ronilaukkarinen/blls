<!DOCTYPE html>
<html>
<head>
  <title>{{ View::hasSection('title') ? View::getSection('title') . ' - ' . config('app.name') : config('app.name') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" href="/images/apple-touch-icon.png">
  <link rel="icon" href="/images/favicon.png">
  <script src="/js/app.js"></script>
  <link rel="stylesheet" href="/css/app.css" />
</head>
@if (Auth::check())
  <body class="<?php echo strtolower( View::getSection( 'title' ) ); ?>">
@else
  <body class="login">
@endif
  <div id="app">
    <div class="dashboard">
      @if (Auth::check())

      <aside class="dashboard-status-bar">
        <header>
          <h1 class="logo"><a href="/dashboard" {!! (Request::path() == 'dashboard') ? 'class="active"' : '' !!}><span class="screen-reader-text">{{ __('dashboard.app_name') }}</span><?php echo file_get_contents( 'svg/dashboard/logo.svg' ); ?></a></h1>
        </header>

        <ul class="navigation-menu">
          <li><a href="/paid" data-balloon="{{ __('dashboard.paidpage') }}" data-balloon-pos="right"><span class="screen-reader-text">{{ __('dashboard.paidpage') }}</span><?php echo file_get_contents( 'svg/dashboard/check.svg' ); ?></a></li>
          <li><a href="/settings" data-balloon="{{ __('dashboard.settings') }}" data-balloon-pos="right"><span class="screen-reader-text">{{ __('dashboard.settings') }}</span><?php echo file_get_contents( 'svg/dashboard/settings.svg' ); ?></a></li>
          <li style="display: none;"><a href="/support" data-balloon="{{ __('dashboard.support') }}" data-balloon-pos="right"><span class="screen-reader-text">{{ __('dashboard.support') }}</span><?php echo file_get_contents( 'svg/dashboard/support.svg' ); ?></a></li>
          <li><a href="/logout" data-balloon="{{ __('dashboard.log_out') }}" data-balloon-pos="right"><span class="screen-reader-text">{{ __('dashboard.log_out') }}</span><?php echo file_get_contents( 'svg/dashboard/logout.svg' ); ?></a></li>
        </ul>
      </aside>
      @endif
      @yield('body')
    </div>
  </div>
  @yield('scripts')
</body>
</html>
