@extends('layouts.app')

@section('content')
<section class="container">
    @if($status > 0)
        <div class="alert alert-success" role="alert">
            <strong>Zapisano zmiany!</strong>
        </div>
    @endif
    <div class="row">
        <form method="post" action="edit">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="title">Nazwa Quizu</label>
                <input id="title" class="form-control" type="text" name="title" value="{{ $quiz->title }}" required>
            </div>
            <div class="form-group">
                <label for="teaser">Krótki opis</label>
                <textarea id="teaser" class="form-control" name="teaser" required>{{ $quiz->teaser }}</textarea>
            </div>
            <div class="form-group">
                <label for="treshold">Próg zaliczenia (min. 30 max 100)</label>
                <input id="treshold" class="form-control" type="number" min="30" max="100" name="treshold" value="{{ $quiz->treshold }}" required>
            </div>
            <button class="btn btn-lg btn-primary" type="submit" name="edit" value="edit">Zapisz <i class="fa fa-save"></i></button>
        </form>
    </div>
    
    <div class="row">
        <form method="post" action="edit">
            {{ csrf_field() }}
            <div class="form-group">
                <label>Jednokrotnego wybory
                    <input type="radio" class="form-control" name="quest-type" value="1" required>
                </label>
                <br>
                <label>Wielokrotnego wybory
                    <input type="radio" class="form-control" name="quest-type" value="2">
                </label>
            </div>
            <div class="form-group">
                <label for="quest">Pytanie</label>
                <textarea id="quest" class="form-control" name="quest" required></textarea>
            </div>
            
            <label>Odpowiedzi</label>
            <div class="form-group">
                <input type="text" name="answer1" required> <input type="checkbox" name="correct1" value="1">
            </div>
            <div class="form-group">
                <input type="text" name="answer2" required> <input type="checkbox" name="correct2" value="1">
            </div>
            <div class="form-group">
                <input type="text" name="answer3" required> <input type="checkbox" name="correct3" value="1">
            </div>
            <div class="form-group">
                <input type="text" name="answer4" required> <input type="checkbox" name="correct4" value="1">
            </div>
            <button class="btn btn-lg btn-warning" type="submit" name="add-quest" value="add-quest">Dodaj pytanie <i class="fa fa-plus-circle"></i></button>
        </form>
    </div>
    
    <div class="row">
        <ul>
        @foreach($questions as $question)
        
        <li><a href="./question/{{ $question->id }}" target="_blank">{{ $question->question }}</a></li>
        
        @endforeach
        </ul>
    </div>
    
</section>
@endsection