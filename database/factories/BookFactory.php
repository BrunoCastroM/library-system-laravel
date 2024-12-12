<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'genre' => $this->faker->word,
            'language' => 'Portuguese',
            'isbn' => $this->faker->isbn13,
            'publication_year' => $this->faker->year,
            'notes' => $this->faker->text,
            'author_id' => Author::factory(),
        ];
    }
}
