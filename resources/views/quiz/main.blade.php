@extends('layout')

@section('content')

<div class='container'>
    
    <p>{{ $quest->question }}</p>
    
    <form>
    
    @foreach($answers as $answer) 
    <div>
        @if($quest->type === 1)
        
        <input type='radio' value='{{ $answer->id }}' id='{{ $answer->id }}' name='answer'>
        <label for='{{ $answer->id }}'> {{ $answer->answer }}</label>
        
        @else
            
        <input type='checkbox' value='{{ $answer->id }}' id='{{ $answer->id }}' name='answer'>
        <label for='{{ $answer->id }}'> {{ $answer->answer }}</label>
        
        @endif
    </div>
    @endforeach
    
    <input type='submit' value='Dalej' name='next'>
    </form>
    
</div>


@endsection