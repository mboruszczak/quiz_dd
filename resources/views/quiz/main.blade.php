@extends('layout')

@section('content')

<section class='container pt-4'>
    <div class="jumbotron white-bg mdl-shadow--8dp">
        <div class="mdl-card__title">
            <h3 class="mdl-card__title-text">{{ $quest->question }}</h3>
        </div>
        <hr class="my-4">
        <form method="post" action="{{ url('/quiz') }}/{{ $quiz_id  }}/q/{{ $next_quest  }}">
        {{ csrf_field() }}

        @foreach($answers as $answer) 
        <div class="mdl-card__supporting-text">
            @if($quest->type === 1)
            
            <label for='{{ $answer->id }}' class="mdl-radio mdl-js-radio mdl-js-ripple-effect">
                <input type='radio' value='{{ $answer->id }}' id='{{ $answer->id }}' name='answer[]' class="mdl-radio__button">
                <span class="mdl-radio__label">{{ $answer->answer }}</span>
            </label>

            @else

            
            <label for='{{ $answer->id }}' class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">  
                <input type='checkbox' value='{{ $answer->id }}' id='{{ $answer->id }}' name='answer[]'  class="mdl-checkbox__input">
                <span class="mdl-checkbox__label">{{ $answer->answer }}</span>
            </label>

            @endif
        </div>
        @endforeach
        <div class="mdl-card__actions flex-end">
            <button type='submit' name='next' disabled="disabled" id="submit-btn" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent wide-btn">Dalej</button>
        </div>
        </form>
    </div>
</section>




@endsection