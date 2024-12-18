@extends('layouts.app')

@section('title', 'Adicionar Novo Livro')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Título -->
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mt-8 mb-6">Adicionar Novo Livro</h1>

    <!-- Exibe mensagens de erro -->
    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative dark:bg-red-800 dark:border-red-600 dark:text-red-200">
            <h4 class="font-semibold mb-2">Por favor, corrija os erros abaixo:</h4>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulário -->
    <form method="POST" action="{{ route('books.store') }}" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        @csrf

        <!-- Título -->
        <div class="mb-4">
            <label for="title" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Título</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required 
                   class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
        </div>

        <!-- Autor -->
        <div class="mb-4">
            <label for="author_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Autor</label>
            <select name="author_id" id="author_id" required
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                <option value="">Selecione o autor</option>
                @foreach (\App\Models\Author::all() as $author)
                    <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
                        {{ $author->first_name }} {{ $author->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Gênero -->
        <div class="mb-4">
            <label for="genre" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Gênero</label>
            <input type="text" name="genre" id="genre" value="{{ old('genre') }}" required
                   class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
        </div>

        <!-- Idioma -->
        <div class="mb-4">
            <label for="language" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Idioma</label>
            <input type="text" name="language" id="language" value="{{ old('language') }}" required
                   class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
        </div>

        <!-- ISBN -->
        <div class="mb-4">
            <label for="isbn" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">ISBN</label>
            <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}" required
                   class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
        </div>

        <!-- Ano de Publicação -->
        <div class="mb-4">
            <label for="publication_year" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Ano de Publicação</label>
            <input type="number" name="publication_year" id="publication_year" value="{{ old('publication_year') }}" required
                   class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
        </div>

        <!-- Observações -->
        <div class="mb-6">
            <label for="notes" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Observações</label>
            <textarea name="notes" id="notes" rows="4"
                      class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">{{ old('notes') }}</textarea>
        </div>

        <!-- Botão -->
        <button type="submit" 
                class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Salvar Livro
        </button>
    </form>
</div>
@endsection
