<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            CategoriesTableSeeder::class,
            AuthorsTableSeeder::class,
            BooksTableSeeder::class,
            AuthorBookTableSeeder::class,
            BackfillBookAuthorsSeeder::class,
        ]);
    }
}