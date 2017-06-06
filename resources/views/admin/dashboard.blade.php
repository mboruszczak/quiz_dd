@extends('layouts.app')

@section('content')
<section class="container">
    <div class="row">
        <a href="./add" class="btn btn-lg btn-success">Dodaj Quiz <i class="fa fa-plus-circle"></i></a>
        
        @foreach($quiz_list as $quiz)
        
            <div class="mdl-card mdl-card--border mdl-shadow--8dp quiz-card mt-5">
                <div class="mdl-card__title">
                    <h2 class="mdl-card__title-text">{{ $quiz->title }}</h2>
                </div>
                <hr class="mx-3">
                    <div class="mdl-card__supporting-text">
                        <p>{{ $quiz->teaser }} </p>
                    </div>
                <div class="mdl-card__actions mb-3">
                    <a href="{{ $quiz->id }}/edit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent wide-btn">Edytuj</a>
                </div>
            </div>
        
        @endforeach
        
    </div>
    {{ $quiz_list->links() }}
</section>
@endsection