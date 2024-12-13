@extends('layouts.app')

@section('title', 'Catálogo de Livros')

@section('content')
<h1>Catálogo de Livros</h1>

<form method="GET" action="{{ route('books.index') }}">
    <input type="text" name="search" placeholder="Pesquisar por título, autor ou gênero" value="{{ request('search') }}">
    <button type="submit">Pesquisar</button>
</form>


<table>
    <thead>
        <tr>
            <th>Título</th>
            <th>Autor</th>
            <th>Gênero</th>
            <th>Ano</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($books as $book)
            <tr>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author->first_name }} {{ $book->author->last_name }}</td>
                <td>{{ $book->genre }}</td>
                <td>{{ $book->publication_year }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $books->links() }}
@endsection
