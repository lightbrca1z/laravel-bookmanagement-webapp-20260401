<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\AuthorDetail;

class AuthorsTableSeeder extends Seeder
{
    public function run(): void
    {
        $authors = Author::factory(6)->create();
        foreach ($authors as $author) {
            AuthorDetail::factory()->create(['author_id' => $author->id]);
        }
    }
}