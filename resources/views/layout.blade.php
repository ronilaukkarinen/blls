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
<body class="theme-{{ Auth::check() ? Auth::user()->theme : 'light' }}">
  <div id="app">
    <div class="dashboard">
      @if (Auth::check())

      <aside class="dashboard-status-bar">
        <header>
          <h1 class="logo"><a href="/dashboard"><span class="screen-reader-text">{{ __('fields.app_name') }}</span><?php echo file_get_contents( 'svg/dashboard/logo.svg' ); ?></a></h1>
        </header>

        <ul class="navigation__menu temp-hidden">
          <li>
            <a href="/dashboard" {!! (Request::path() == 'dashboard') ? 'class="active"' : '' !!}><span class="hidden ml-05">{{ __('general.dashboard') }}</span></a>
          </li>
          <li>
            <a href="/recurrings" {!! (Request::path() == 'recurrings') ? 'class="active"' : '' !!}><span class="hidden ml-05">{{ __('models.recurrings') }}</span></a>
          </li>
          <li>
            <a href="/tags" {!! (Request::path() == 'tags') ? 'class="active"' : '' !!}><span class="hidden ml-05">{{ __('models.tags') }}</span></a>
          </li>
          <li>
            <a href="/reports" {!! (Request::path() == 'reports') ? 'class="active"' : '' !!}><span class="hidden ml-05">Reports</span></a>
          </li>
        </ul>
        <ul class="navigation__menu temp-hidden">
          <li>
            <dropdown>
              <span slot="button">
                <img src="{{ Auth::user()->avatar }}" class="avatar mr-05" /> <i class="fas fa-caret-down fa-sm"></i>
              </span>
              <ul slot="menu" v-cloak>
                <li>
                  <a href="/imports">{{ __('models.imports') }}</a>
                </li>
                <li>
                  <a href="/settings">{{ __('pages.settings') }}</a>
                </li>
                <li>
                  <a href="/logout">{{ __('pages.log_out') }}</a>
                </li>
              </ul>
            </dropdown>
          </li>
        </ul>
      </aside>
      @endif
      @yield('body')
    </div>
  </div>
  @yield('scripts')
</body>
</html>
