<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; // Importa o modelo Book
use App\Models\Author; // Importa o modelo Author

class BookController extends Controller
{
    /**
     * Exibe a lista de livros com filtro de pesquisa.
     */
    public function index(Request $request)
    {
        $query = Book::with('author'); // Carrega livros com seus autores

        // Verifica se há algum termo de pesquisa
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhereHas('author', function($q) use ($search) {
                      $q->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%');
                  })
                  ->orWhere('genre', 'like', '%' . $search . '%');
            });
        }

        // Paginação com 10 livros por página
        $books = $query->paginate(10);

        return view('books.index', compact('books'));
    }

    /**
     * Exibe o formulário para criar um novo livro.
     */
    public function create()
    {
        // Busca todos os autores para o dropdown
        $authors = Author::all();

        return view('books.create', compact('authors'));
    }

    /**
     * Armazena um novo livro no banco de dados.
     */
    public function store(Request $request)
    {
        // Validação dos dados do formulário
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string|max:100',
            'language' => 'required|string|max:50',
            'isbn' => 'required|string|unique:books|size:13',
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            'notes' => 'nullable|string',
            'author_id' => 'required|exists:authors,id',
        ]);

        // Criação do livro no banco de dados
        Book::create($validated);

        // Redireciona para a listagem com uma mensagem de sucesso
        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso!');
    }

    /**
     * Exibe o formulário para editar um livro existente.
     */
    public function edit(Book $book)
    {
        // Busca todos os autores para o dropdown
        $authors = Author::all();

        return view('books.edit', compact('book', 'authors'));
    }

    /**
     * Atualiza um livro existente no banco de dados.
     */
    public function update(Request $request, Book $book)
    {
        // Validação dos dados do formulário
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string|max:100',
            'language' => 'required|string|max:50',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            'notes' => 'nullable|string',
            'author_id' => 'required|exists:authors,id',
        ]);

        // Atualiza o livro no banco de dados
        $book->update($validated);

        // Redireciona para a listagem com uma mensagem de sucesso
        return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso!');
    }

    /**
     * Remove um livro do banco de dados.
     */
    public function destroy(Book $book)
    {
        // Deleta o livro
        $book->delete();

        // Redireciona para a listagem com uma mensagem de sucesso
        return redirect()->route('books.index')->with('success', 'Livro deletado com sucesso!');
    }
}
