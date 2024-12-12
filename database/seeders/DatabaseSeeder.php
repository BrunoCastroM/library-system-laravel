<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Verifique se o e-mail já existe antes de criar um novo usuário
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        // Chama os seeders de autores e livros
        $this->call([
            AuthorsTableSeeder::class,
            BooksTableSeeder::class,
        ]);
    }
}
