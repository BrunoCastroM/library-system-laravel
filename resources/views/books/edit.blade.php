@extends('layouts.app')

@section('title', 'Editar Livro')

@section('content')
<div class="container">
    <h1>Editar Livro</h1>

    <!-- Exibe mensagens de erro -->
    @if ($errors->any())
        <div style="color: red; margin-bottom: 10px;">
            <h4>Por favor, corrija os erros abaixo:</h4>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulário de Edição -->
    <form method="POST" action="{{ route('books.update', $book->id) }}">
        @csrf
        @method('PATCH')

        <div>
            <label for="title">Título:</label>
            <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required>
        </div>

        <div>
            <label for="genre">Gênero:</label>
            <input type="text" name="genre" id="genre" value="{{ old('genre', $book->genre) }}" required>
        </div>

        <div>
            <label for="language">Idioma:</label>
            <input type="text" name="language" id="language" value="{{ old('language', $book->language) }}" required>
        </div>

        <div>
            <label for="isbn">ISBN:</label>
            <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}" required>
        </div>

        <div>
            <label for="publication_year">Ano de Publicação:</label>
            <input type="number" name="publication_year" id="publication_year" value="{{ old('publication_year', $book->publication_year) }}" required>
        </div>

        <div>
            <label for="author_id">Autor:</label>
            <select name="author_id" id="author_id" required>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ old('author_id', $book->author_id) == $author->id ? 'selected' : '' }}>
                        {{ $author->first_name }} {{ $author->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="notes">Observações:</label>
            <textarea name="notes" id="notes">{{ old('notes', $book->notes) }}</textarea>
        </div>

        <button type="submit">Atualizar Livro</button>
    </form>

    <!-- Formulário para Deletar Livro -->
    <form method="POST" action="{{ route('books.destroy', $book->id) }}" style="margin-top: 10px;">
        @csrf
        @method('DELETE')
        <button type="submit" style="color: red;" onclick="return confirm('Tem certeza que deseja excluir este livro?');">
            Excluir Livro
        </button>
    </form>
</div>
@endsection
