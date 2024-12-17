@extends('layouts.app')

@section('title', 'Catálogo de Livros')

@section('content')
<h1>Catálogo de Livros</h1>

<!-- Alerta de Sucesso -->
@if (session('success'))
    <div style="color: green; background-color: #d4edda; padding: 10px; margin-bottom: 10px; border: 1px solid #c3e6cb; border-radius: 4px;">
        {{ session('success') }}
    </div>
@endif

<!-- Alerta de Erro -->
@if (session('error'))
    <div style="color: red; background-color: #f8d7da; padding: 10px; margin-bottom: 10px; border: 1px solid #f5c6cb; border-radius: 4px;">
        {{ session('error') }}
    </div>
@endif

<!-- Formulário de Pesquisa -->
<form method="GET" action="{{ route('books.index') }}">
    <input type="text" name="search" placeholder="Pesquisar por título, autor ou gênero" value="{{ request('search') }}">
    <button type="submit">Pesquisar</button>
</form>

<!-- Link para Criar Novo Livro - Somente Admin -->
@if (auth()->user()->role === 'admin')
    <a href="{{ route('books.create') }}" class="btn btn-primary" style="margin: 10px 0; display: inline-block;">
        Adicionar Novo Livro
    </a>
@endif

<!-- Tabela de Livros -->
<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; margin-top: 10px;">
    <thead>
        <tr>
            <th>Título</th>
            <th>Autor</th>
            <th>Gênero</th>
            <th>Ano</th>
            @if (auth()->user()->role === 'admin') <!-- Somente admin verá a coluna Ações -->
                <th>Ações</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($books as $book)
            <tr>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author->first_name }} {{ $book->author->last_name }}</td>
                <td>{{ $book->genre }}</td>
                <td>{{ $book->publication_year }}</td>
                @if (auth()->user()->role === 'admin') <!-- Somente admin verá os botões de Ações -->
                    <td>
                        <!-- Botão Editar -->
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-warning">Editar</a>

                        <!-- Formulário para Deletar Livro -->
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este livro?');">
                                Excluir
                            </button>
                        </form>
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Paginação -->
<div style="margin-top: 15px;">
    {{ $books->links() }}
</div>
@endsection
