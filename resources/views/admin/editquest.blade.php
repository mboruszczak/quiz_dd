@extends('layouts.app')

@section('content')
<section class="container">

    <div class="row">
        <form id="edit_quest_form" method="post" action="">
            {{ csrf_field() }}
            
            <div class="form-group">
                <label>Jednokrotnego wybory
                    <input type="radio" class="form-control" name="quest_type" value="1" {{ $quest['question_type_1'] }} required data-type="single">
                </label>
                <br>
                <label>Wielokrotnego wybory
                    <input type="radio" class="form-control" name="quest_type" value="2" {{ $quest['question_type_2'] }} data-type="multi">
                </label>
            </div>
            
            <div class="form-group">
                <label for="quest">Pytanie</label>
                <textarea id="quest" class="form-control" name="quest" required>{{ $quest['question'] }}</textarea>
            </div>
            
            <label>Odpowiedzi</label>
            <div class="form-group">
                <input type="text" name="answers[]" value="{{ $quest['answer_1']['answer'] }}" required> <input type="checkbox" name="correct[]" {{ $quest['answer_1']['correct'] }} value="0">
            </div>
            <div class="form-group">
                <input type="text" name="answers[]" value="{{ $quest['answer_2']['answer'] }}" required> <input type="checkbox" name="correct[]" {{ $quest['answer_2']['correct'] }} value="1">
            </div>
            <div class="form-group">
                <input type="text" name="answers[]" value="{{ $quest['answer_3']['answer'] }}"> <input type="checkbox" name="correct[]" {{ $quest['answer_3']['correct'] }} value="2">
            </div>
            <div class="form-group">
                <input type="text" name="answers[]" value="{{ $quest['answer_4']['answer'] }}"> <input type="checkbox" name="correct[]" {{ $quest['answer_4']['correct'] }} value="3">
            </div>
           
            <button class="btn btn-lg btn-primary" type="submit" name="edit_quest" value="edit_quest">Zapisz <i class="fa fa-save"></i></button>
        </form>
    </div>
</section>
@endsection