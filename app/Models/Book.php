<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'genre',
        'language',
        'isbn',
        'publication_year',
        'notes',
        'author_id',
    ];

    // Definir a relação com o autor
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
