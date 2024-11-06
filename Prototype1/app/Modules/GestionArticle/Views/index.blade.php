<!-- resources/views/Modules/GestionArticle/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Liste des Articles</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulaire de recherche -->
    <div class="mb-3">
        <input type="text" id="search" class="form-control" placeholder="Rechercher un article...">
    </div>

    <!-- Filtre par catégorie -->
    <div class="mb-3">
        <select id="categoryFilter" class="form-control">
            <option value="">Filtrer par catégorie</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Contenu</th>
                <th>Catégorie</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="articles-table">
            @foreach($articles as $article)
                <tr>
                    <td>{{ $article->title }}</td>
                    <td>{{ Str::limit($article->content, 50) }}</td>
                    <td>{{ $article->category->name }}</td>
                    <td>
                        <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-primary btn-sm">Modifier</a>
                        <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Ajouter les liens de pagination -->
    <div class="d-flex justify-content-center">
        {{ $articles->links('pagination::bootstrap-5') }}
    </div>

    <script>
        // Recherche des articles
        $('#search').on('keyup', function () {
            let query = $(this).val();
            $.get("{{ route('articles.search') }}", { query: query }, function (data) {
                let articlesHtml = '';
                data.forEach(function(article) {
                    articlesHtml += `<tr><td>${article.title}</td><td>${article.content}</td><td>${article.category.name}</td></tr>`;
                });
                $('#articles-table').html(articlesHtml);
            });
        });

        // Filtrage des articles par catégorie
        $('#categoryFilter').on('change', function () {
            let categoryId = $(this).val();
            $.get("{{ route('articles.filterByCategory') }}", { category_id: categoryId }, function (data) {
                let articlesHtml = '';
                data.forEach(function(article) {
                    articlesHtml += `<tr><td>${article.title}</td><td>${article.content}</td><td>${article.category.name}</td></tr>`;
                });
                $('#articles-table').html(articlesHtml);
            });
        });
    </script>
@endsection
