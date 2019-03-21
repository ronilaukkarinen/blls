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
<body>
  <div id="app">
    <div class="dashboard">
      @if (Auth::check())

      <aside class="dashboard-status-bar">
        <header>
          <h1 class="logo"><a href="/dashboard" {!! (Request::path() == 'dashboard') ? 'class="active"' : '' !!}><span class="screen-reader-text">{{ __('fields.app_name') }}</span><?php echo file_get_contents( 'svg/dashboard/logo.svg' ); ?></a></h1>
        </header>

        <ul class="navigation-menu">
          <li><a href="/settings"><span class="screen-reader-text">{{ __('pages.settings') }}</span><?php echo file_get_contents( 'svg/dashboard/settings.svg' ); ?></a></li>
          <li><a href="/logout"><span class="screen-reader-text">{{ __('pages.log_out') }}</span><?php echo file_get_contents( 'svg/dashboard/logout.svg' ); ?></a></li>
        </ul>
      </aside>
      @endif
      @yield('body')
    </div>
  </div>
  @yield('scripts')
</body>
</html>
