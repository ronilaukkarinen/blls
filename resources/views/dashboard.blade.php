@extends('layout')

@section('title', 'Dashboard')

@section('body')

    <?php echo 'Hello world'; ?>

    <div class="test">
        Test content
    </div>

@endsection

@section('scripts')
    <script>
        new Chartist.Line('.ct-chart', {
            labels: [{!! implode(',', range(1, $daysInMonth)) !!}],
            series: [[{!! implode(',', $dailyBalance) !!}]]
        }, {
            showPoint: false,
            lineSmooth: false
        });
    </script>
@endsection
