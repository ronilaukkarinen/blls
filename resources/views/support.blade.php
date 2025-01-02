@extends('layout')

@section('title', 'Dashboard')

@section('body')

<?php
// Set locale
$lang = Config::get('app.locale');

if ('fi' == $lang) :
    setlocale(LC_TIME, 'fi_FI.UTF8');
endif;

if ('local' == App::environment()) :
    setlocale(LC_TIME, 'fi_FI');
endif;
?>

<section class="dashboard-content">

  <div class="column-support">
    <h1>{{ __('dashboard.support') }}</h1>
  </div>

</section>

<script>
// Set moment.js to current language
moment.locale('{{ Config::get('app.locale') }}');
</script>

@endsection
