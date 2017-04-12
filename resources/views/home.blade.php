@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                    <ul>
                        
                        @foreach ($quiz_list as $quiz)
                        
                        <li><a href="quiz/{{ $quiz->id }}">{{ $quiz->title }}</a></li>
                        
                        @endforeach
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
