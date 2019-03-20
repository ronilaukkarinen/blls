@extends('emails.template')

@section('content')
    <a href="{{ config('app.url') }}/reset-password?token={{ $token }}">Click here to change your password</a>
@endsection
