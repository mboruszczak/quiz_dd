@extends('layout')

@section('content')

<section class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            @if($score['pass'] == true)

                <h1>Gratulacje!</h1>

            @else

                <h1>Porażka!</h1>

            @endif
            <h2>Twój wynik: {{ $score['score'] }}%</h2>
        </div>
    </div>
</section>

@endsection