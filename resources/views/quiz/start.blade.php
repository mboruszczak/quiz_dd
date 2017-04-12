@extends('layout')

@section('content')

<div class='container'>
    <h1>{{ $quiz->title }}</h1>
    <p>Ilość pytań: {{ $quiz->num_of_questions }}</p>
    <p>Próg zaleczenia: {{ $quiz->treshold }}%</p>
    <a href='{{ $quiz->id }}/q/1' class='btn btn-primary btn-lg'>START</a>
</div>

@endsection