@extends('layouts.app')

@section('content')
<section class="container">
    @if($action > 0)
        <div class="alert alert-success" role="alert">
            <strong>Quiz Dodany!</strong> Teraz dodaj do niego kilka pytań.
        </div>
    @elseif($action === 0)
        <div class="alert alert-danger" role="alert">
            <strong>Taki quiz już istnieje</strong>
        </div>
    @endif
    <div class="row">
        <form method="post" action="add">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="title">Nazwa Quizu</label>
                <input id="title" class="form-control" type="text" name="title" required>
            </div>
            <div class="form-group">
                <label for="teaser">Krótki opis</label>
                <textarea id="teaser" class="form-control" name="teaser" required></textarea>
            </div>
            <div class="form-group">
                <label for="treshold">Próg zaliczenia (min. 30 max 100)</label>
                <input id="treshold" class="form-control" type="number" min="30" max="100" name="treshold" required>
            </div>
            <button class="btn btn-lg btn-primary" type="submit" name="add" value="add">Zapisz <i class="fa fa-save"></i></button>
        </form>
    </div>
</section>
@endsection