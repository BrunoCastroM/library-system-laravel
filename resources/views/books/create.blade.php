@extends('layouts.app')

@section('title', 'Adicionar Novo Livro')

@section('content')
<div class="container">
    <h1>Adicionar Novo Livro</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('books.store') }}">
        @csrf

        <div>
            <label for="title">Título:</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required>
        </div>

        <div>
            <label for="author_id">Autor:</label>
            <select name="author_id" id="author_id" required>
                <option value="">Selecione o autor</option>
                @foreach(\App\Models\Author::all() as $author)
                    <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
                        {{ $author->first_name }} {{ $author->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="genre">Gênero:</label>
            <input type="text" name="genre" id="genre" value="{{ old('genre') }}" required>
        </div>

        <div>
            <label for="language">Idioma:</label>
            <input type="text" name="language" id="language" value="{{ old('language') }}" required>
        </div>

        <div>
            <label for="isbn">ISBN:</label>
            <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}" required>
        </div>

        <div>
            <label for="publication_year">Ano de Publicação:</label>
            <input type="number" name="publication_year" id="publication_year" value="{{ old('publication_year') }}" required>
        </div>

        <div>
            <label for="notes">Observações:</label>
            <textarea name="notes" id="notes">{{ old('notes') }}</textarea>
        </div>

        <button type="submit">Salvar Livro</button>
    </form>
</div>
@endsection
