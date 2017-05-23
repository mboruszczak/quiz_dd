@extends('layout')

@section('content')

<section class='container pt-4'>
    <div class="jumbotron white-bg mdl-shadow--8dp">
        <div class="mdl-card__title">
            <h1 class="display-3">{{ $quiz->title }}</h1>
        </div>
        <hr class="my-4">
        <div class="mdl-card__supporting-text">
                <p class="lead">Ilość pytań: {{ $quiz->num_of_questions }}</p>
                <p class="lead">Próg zaleczenia: {{ $quiz->treshold }}%</p>
        </div>
        <div class="mdl-card__actions">
            <!-- <a href="{{ $quiz->id }}/q/1" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent wide-btn">START</a> -->
            <form method="post" action="{{ url('/quiz_main') }}">
            <input type="hidden" name="tq" value="{{ $quiz->id  }}">
            <input type="hidden" name="cq" value="1">
            {{ csrf_field() }}
            <button type='submit' name='start' value='start' id="submit-btn" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent wide-btn">START</button>
            </form>
        </div>
    </div>
</section>

@endsection