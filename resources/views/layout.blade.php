<!DOCTYPE html>
<html>
<head>
  <title>{{ View::hasSection('title') ? View::getSection('title') . ' - ' . config('app.name') : config('app.name') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
  <link rel="manifest" href="images/site.webmanifest">
  <link rel="mask-icon" href="images/safari-pinned-tab.svg" color="#244e81">
  <link rel="shortcut icon" href="images/favicon.png">
  <meta name="msapplication-TileColor" content="#2b5797">
  <meta name="msapplication-config" content="images/browserconfig.xml">
  <meta name="theme-color" content="#1b3b62">

  <script src="/js/app.js"></script>
  <link rel="stylesheet" href="/css/app{{ app()->environment('production') ? '.min' : '' }}.css" />
</head>
@if (Auth::check())
  <body class="<?php echo strtolower(View::getSection('title')); ?>">
@else
  <body class="login">
@endif
  <div id="app">
    <div class="dashboard">
      @if (Auth::check())

      <aside class="dashboard-status-bar">
        <header>
          <h1 class="logo"><a href="/dashboard" {!! (Request::path() == 'dashboard') ? 'class="active"' : '' !!}><span class="screen-reader-text">{{ __('dashboard.app_name') }}</span><?php echo file_get_contents('svg/dashboard/logo.svg'); ?></a></h1>
        </header>

        <ul class="navigation-menu">
          <li><a href="/paid" data-balloon="{{ __('dashboard.paidpage') }}" data-balloon-pos="right"><span class="screen-reader-text">{{ __('dashboard.paidpage') }}</span><?php echo file_get_contents('svg/dashboard/check.svg'); ?></a></li>
          <li><a href="/settings" data-balloon="{{ __('dashboard.settings') }}" data-balloon-pos="right"><span class="screen-reader-text">{{ __('dashboard.settings') }}</span><?php echo file_get_contents('svg/dashboard/settings.svg'); ?></a></li>
          <li style="display: none;"><a href="/support" data-balloon="{{ __('dashboard.support') }}" data-balloon-pos="right"><span class="screen-reader-text">{{ __('dashboard.support') }}</span><?php echo file_get_contents('svg/dashboard/support.svg'); ?></a></li>
          <li><a href="/logout" data-balloon="{{ __('dashboard.log_out') }}" data-balloon-pos="right"><span class="screen-reader-text">{{ __('dashboard.log_out') }}</span><?php echo file_get_contents('svg/dashboard/logout.svg'); ?></a></li>
        </ul>
      </aside>
      @endif
      @yield('body')
      @if (Auth::check())
        <footer class="app-footer">
          <div class="footer-content">
            <span class="version">♥ <a href="{{ config('app.github_url') }}" target="_blank" rel="noopener noreferrer">{{ config('app.name') }} is open source - you are running v{{ config('app.version', '0.1.0') }}</a> &mdash; <a href="{{ config('app.coffee_url') }}" target="_blank" rel="noopener noreferrer">Support development</a></span>
          </div>
        </footer>
      @endif
    </div>
  </div>
  @yield('scripts')
</body>
</html>
