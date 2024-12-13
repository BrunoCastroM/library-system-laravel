<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
{
    $query = \App\Models\Book::with('author'); // Carrega livros com seus autores

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

}
