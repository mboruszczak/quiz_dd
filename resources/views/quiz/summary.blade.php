@extends('layout')

@section('content')

<section class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            @if($score['status'] == 1)

                <h1>Gratulacje!</h1>

            @else

                <h1>Porażka!</h1>

            @endif
            <h2>Twój wynik: {{ $score['score'] }}%</h2>
            <a href="{{ url('/home') }}" class="btn btn-lg btn-primary">OK</a>
        </div>
    </div>
</section>

@endsection