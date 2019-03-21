@extends('layout')

@section('body')
    <div class="wrapper my-3">
        <h2>{{ $recurring->description }}</h2>
        <div class="row my-3">
            <div class="row__column row__column--compact">
                @if ($recurring->due_days)
                    <span style="border-radius: 5px; background: #D8F9E8; color: #51B07F; padding: 5px 10px; font-size: 14px; font-weight: 600;"><i class="fas fa-check fa-xs"></i> Active</span>
                @else
                    <span style="border-radius: 5px; background: #FFE7EC; color: #F25C68; padding: 5px 10px; font-size: 14px; font-weight: 600;"><i class="fas fa-times fa-xs"></i> Inactive</span>
                @endif
            </div>
        </div>
    </div>
@endsection
