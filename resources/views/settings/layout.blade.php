@extends('layout')

@section('body')
<section class="dashboard-content settings-content">
  <div class="column-settings">
    <h1>Settings</h1>
    <ul class="settings-choices">
      <li><a href="/settings/profile"><?php echo file_get_contents( 'svg/settings/user.svg' ); ?>{{ __('general.profile') }}</a></li>
      <li><a href="/settings/account"><?php echo file_get_contents( 'svg/settings/email.svg' ); ?>{{ __('general.account') }}</a></li>
      <li><a href="/settings/preferences"><?php echo file_get_contents( 'svg/settings/sliders.svg' ); ?>{{ __('general.preferences') }}</a></li>
    </ul>
    @yield('settings_title')
    <form method="POST" action="/settings" enctype="multipart/form-data">
      {{ csrf_field() }}
      @yield('settings_body')
    </form>
  </div>
</section>
@endsection
