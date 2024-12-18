<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('register');
});

Route::get('/dashboard', function () {
    return redirect()->route('books.index');
})->middleware(['auth', 'verified'])->name('dashboard');


// Grupo de rotas protegidas por autenticação
Route::middleware('auth')->group(function () {
    // Perfil do usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas acessíveis a todos os usuários autenticados (Catálogo de livros)
    Route::get('/books', [BookController::class, 'index'])->name('books.index');

    // Rotas exclusivas para administradores
    Route::group(['middleware' => function ($request, $next) {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Acesso não autorizado.');
        }
        return $next($request);
    }], function () {
        Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
        Route::post('/books', [BookController::class, 'store'])->name('books.store');
        Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::patch('/books/{book}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    });
});

require __DIR__.'/auth.php';
