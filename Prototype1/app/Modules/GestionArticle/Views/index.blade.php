@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des Articles</h1>

        <a href="{{ route('articles.create') }}" class="btn btn-primary mb-3">Créer un nouvel article</a>

        @if($articles->isEmpty())
            <p>Aucun article disponible pour le moment.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Contenu</th>
                        <th>Date de création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <td>{{ $article->id }}</td>
                            <td>{{ $article->title }}</td>
                            <td>{{ Str::limit($article->content, 50) }}</td>
                            <td>{{ $article->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('articles.show', $article->id) }}" class="btn btn-info btn-sm">Voir</a>
                                <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning btn-sm">Éditer</a>
                                <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
