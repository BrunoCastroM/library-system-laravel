@extends('layouts.app')

@section('title', 'Catálogo de Livros')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Título com espaçamento superior -->
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mt-8 mb-6">Catálogo de Livros</h1>

    <!-- Alerta de Sucesso -->
    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative dark:bg-green-800 dark:border-green-600 dark:text-green-200">
            {{ session('success') }}
        </div>
    @endif

    <!-- Alerta de Erro -->
    @if (session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative dark:bg-red-800 dark:border-red-600 dark:text-red-200">
            {{ session('error') }}
        </div>
    @endif

    <!-- Formulário de Pesquisa -->
    <form method="GET" action="{{ route('books.index') }}" class="flex items-center mb-4">
        <input 
            type="text" 
            name="search" 
            placeholder="Pesquisar por título, autor ou gênero"
            value="{{ request('search') }}"
            class="w-full md:w-1/3 px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700"
        >
        <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Pesquisar
        </button>
    </form>

    <!-- Link para Criar Novo Livro - Somente Admin -->
    @if (auth()->user()->role === 'admin')
        <a href="{{ route('books.create') }}" class="inline-block mb-4 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
            Adicionar Novo Livro
        </a>
    @endif

    <!-- Tabela de Livros -->
<div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow-md">
    <table class="w-full table-auto border-collapse text-left">
        <thead>
            <tr class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                <th class="px-4 py-2">Título</th>
                <th class="px-4 py-2">Autor</th>
                <th class="px-4 py-2">Gênero</th>
                <th class="px-4 py-2">Ano</th>
                <th class="px-4 py-2">Detalhes</th>
                @if (auth()->user()->role === 'admin')
                    <th class="px-4 py-2">Ações</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
                <!-- Linha principal do livro -->
                <tr class="border-b hover:bg-gray-100 dark:hover:bg-gray-700">
                    <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $book->title }}</td>
                    <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $book->author->first_name }} {{ $book->author->last_name }}</td>
                    <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $book->genre }}</td>
                    <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $book->publication_year }}</td>
                    <td class="px-4 py-2">
                        <!-- Botão dropdown com Alpine.js -->
                        <div x-data="{ open: false }">
                            <button @click="open = ! open" 
                                    class="text-gray-700 dark:text-gray-200 hover:underline focus:outline-none">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <!-- Detalhes ocultos -->
                            <div x-show="open" x-transition class="mt-2 bg-gray-100 dark:bg-gray-700 p-4 rounded-md shadow">
                                <p class="text-gray-700 dark:text-gray-200"><strong>Idioma:</strong> {{ $book->language }}</p>
                                <p class="text-gray-700 dark:text-gray-200"><strong>ISBN:</strong> {{ $book->isbn }}</p>
                                <p class="text-gray-700 dark:text-gray-200"><strong>Observações:</strong> {{ $book->notes }}</p>
                            </div>
                        </div>
                    </td>
                    @if (auth()->user()->role === 'admin')
                        <td class="px-4 py-2 flex space-x-6">
                            <!-- Botão Editar -->
                            <a href="{{ route('books.edit', $book->id) }}" class="text-blue-600 hover:underline dark:text-blue-400">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- Formulário para Deletar Livro -->
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline dark:text-red-400" onclick="return confirm('Tem certeza que deseja excluir este livro?');">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


    <!-- Paginação -->
    <div class="mt-6">
        {{ $books->links('pagination::tailwind') }}
    </div>
</div>
@endsection
