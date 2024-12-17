<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; // Importa o modelo Book
use App\Models\Author; // Importa o modelo Author
use Illuminate\Support\Facades\Log; // Importa o Log para registrar erros

class BookController extends Controller
{
    /**
     * Exibe a lista de livros com filtro de pesquisa.
     */
    public function index(Request $request)
    {
        $query = Book::with('author'); // Carrega livros com seus autores

        // Verifica se há algum termo de pesquisa
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('genre', 'like', '%' . $search . '%')
                  ->orWhereHas('author', function($q) use ($search) {
                      $q->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%');
                  });
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
        $authors = Author::all();
        return view('books.create', compact('authors'));
    }

    /**
     * Armazena um novo livro no banco de dados.
     */
    public function store(Request $request)
    {
        try {
            // Validação dos dados do formulário
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'genre' => 'required|string|max:100',
                'language' => 'required|string|max:50',
                'isbn' => 'required|string|unique:books|size:13',
                'publication_year' => 'required|integer|min:1|max:' . date('Y'),
                'notes' => 'nullable|string',
                'author_id' => 'required|exists:authors,id',
            ], [
                'title.required' => 'O título é obrigatório.',
                'isbn.unique' => 'O ISBN deve ser único.',
                'author_id.exists' => 'O autor selecionado não é válido.',
                'publication_year.max' => 'O ano de publicação não pode ser maior que o ano atual.',
                'publication_year.min' => 'O ano de publicação não pode ser inferior a 1.',
            ]);

            // Criação do livro
            Book::create($validated);

            return redirect()->route('books.index')->with('success', 'Livro criado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar livro: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'data' => $request->all(),
            ]);
            return redirect()->route('books.index')->with('error', 'Ocorreu um erro ao criar o livro. Verifique os logs.');
        }
    }

    /**
     * Exibe o formulário para editar um livro existente.
     */
    public function edit(Book $book)
    {
        $authors = Author::all();
        return view('books.edit', compact('book', 'authors'));
    }

    /**
     * Atualiza um livro existente no banco de dados.
     */
    public function update(Request $request, Book $book)
    {
        try {
            // Validação dos dados do formulário
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'genre' => 'required|string|max:100',
                'language' => 'required|string|max:50',
                'isbn' => 'required|string|unique:books,isbn,' . $book->id . '|size:13',
                'publication_year' => 'required|integer|min:1|max:' . date('Y'),
                'notes' => 'nullable|string',
                'author_id' => 'required|exists:authors,id',
            ], [
                'title.required' => 'O título é obrigatório.',
                'isbn.unique' => 'O ISBN deve ser único.',
                'author_id.exists' => 'O autor selecionado não é válido.',
                'publication_year.max' => 'O ano de publicação não pode ser maior que o ano atual.',
                'publication_year.min' => 'O ano de publicação não pode ser inferior a 1.',
            ]);

            // Atualização do livro
            $book->update($validated);

            return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar livro: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'book_id' => $book->id,
                'data' => $request->all(),
            ]);
            return redirect()->route('books.index')->with('error', 'Ocorreu um erro ao atualizar o livro. Verifique os logs.');
        }
    }

    /**
     * Remove um livro do banco de dados.
     */
    public function destroy(Book $book)
    {
        try {
            $book->delete();

            return redirect()->route('books.index')->with('success', 'Livro deletado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao deletar livro: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'book_id' => $book->id,
            ]);
            return redirect()->route('books.index')->with('error', 'Ocorreu um erro ao deletar o livro. Verifique os logs.');
        }
    }
}
