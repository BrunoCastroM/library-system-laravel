@extends('layouts.app')

@section('title', 'Editar Livro')

@section('content')
<h1>Editar Livro</h1>

<form method="POST" action="{{ route('books.update', $book->id) }}">
    @csrf
    @method('PATCH')

    <div>
        <label>Título:</label>
        <input type="text" name="title" value="{{ old('title', $book->title) }}" required>
    </div>

    <div>
        <label>Gênero:</label>
        <input type="text" name="genre" value="{{ old('genre', $book->genre) }}" required>
    </div>

    <div>
        <label>Idioma:</label>
        <input type="text" name="language" value="{{ old('language', $book->language) }}" required>
    </div>

    <div>
        <label>ISBN:</label>
        <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}" required>
    </div>

    <div>
        <label>Ano de Publicação:</label>
        <input type="number" name="publication_year" value="{{ old('publication_year', $book->publication_year) }}" required>
    </div>

    <div>
        <label>Autor:</label>
        <select name="author_id" required>
            @foreach($authors as $author)
                <option value="{{ $author->id }}" {{ $book->author_id == $author->id ? 'selected' : '' }}>
                    {{ $author->first_name }} {{ $author->last_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Observações:</label>
        <textarea name="notes">{{ old('notes', $book->notes) }}</textarea>
    </div>

    <button type="submit">Atualizar Livro</button>
</form>

<form method="POST" action="{{ route('books.destroy', $book->id) }}" style="margin-top: 10px;">
    @csrf
    @method('DELETE')
    <button type="submit" style="color: red;">Excluir Livro</button>
</form>
@endsection
