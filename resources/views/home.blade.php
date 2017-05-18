@extends('layouts.app')

@section('content')
<section class="container">
    <div class="row">
        <div class="col-md-8 col-sm-offset-2">

                        @foreach ($quiz_list as $quiz)
                        
                        <div class="mdl-card mdl-card--border mdl-shadow--8dp quiz-card">
                            <div class="mdl-card__title">
                                <h2 class="mdl-card__title-text">{{ $quiz->title }}</h2>
                                @if($quiz->status == 1)
                                    <i class='fa fa-thumbs-up fa-2x success-badge' aria-hidden='true'></i>
                                @elseif($quiz->status == 0)
                                    <i class="fa fa-thumbs-down fa-2x failure-badge" aria-hidden="true"></i>
                                @else
                                @endif
                            </div>
                            <hr class="mx-3">
                            <div class="mdl-card__supporting-text">
                                <p>{{ $quiz->teaser }} </p>
                            </div>
                            <div class="mdl-card__actions mb-3">
                                <a href="quiz/{{ $quiz->id }}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent wide-btn">START</a>
                            </div>
                        </div>
                        @endforeach

        </div>
    </div>
</section>
@endsection
