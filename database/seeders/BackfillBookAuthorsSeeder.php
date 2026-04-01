<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BackfillBookAuthorsSeeder extends Seeder
{
    /**
     * 全書籍に著者名を設定する（ja_JP Faker。再実行のたびに名前は変わる）。
     */
    public function run(): void
    {
        $faker = fake('ja_JP');

        foreach (Book::query()->orderBy('id')->cursor() as $book) {
            $book->update(['author' => $faker->name()]);
        }
    }
}
