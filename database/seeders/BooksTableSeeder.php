<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owner = User::query()->where('userid', 'test1')->firstOrFail();
        $categories = Category::all();

        foreach ($categories as $category) {
            Book::factory(2)->create([
                'category_id' => $category->id,
                'user_id' => $owner->id,
            ]);
        }
    }
}
