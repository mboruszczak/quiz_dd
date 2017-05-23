@extends('layout')

@section('content')

<section class="container pt-4">
    <div class="jumbotron white-bg mdl-shadow--8dp">
        <div class="mdl-card__title-text">
            @if($score['status'] == 1)

                <h1>Gratulacje! <i class='fa fa-thumbs-up fa-2x success-badge' aria-hidden='true'></i></h1>
                
            @else

                <h1>Porażka! <i class="fa fa-thumbs-down failure-badge" aria-hidden="true"></i></h1>
                
            @endif
        </div>
        <hr class="my-4">
        <div class="mdl-card__supporting-text">
            <h3>Twój wynik: {{ $score['score'] }}%</h3>
        </div>
        <div class="mdl-card__actions">
            <a href="{{ url('/home') }}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent wide-btn">OK</a>
        </div>
    </div>
   
</section>

@endsection