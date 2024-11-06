@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Créer un Nouvel Article</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('articles.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label for="content">Contenu</label>
                <textarea name="content" id="content" rows="5" class="form-control" required>{{ old('content') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Enregistrer l'article</button>
            <a href="{{ route('articles.index') }}" class="btn btn-secondary mt-3">Annuler</a>
        </form>
    </div>
@endsection
