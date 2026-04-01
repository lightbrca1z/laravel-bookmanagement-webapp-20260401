<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Author;

class AuthorBookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $books = Book::all();
        $authors = Author::all();

        foreach($books as $book){
            $authorIds = $authors
            -> random(2)
            -> pluck('id')
            -> all();
            
            //書籍にランダムに抜き出した2件の著者のID配列を関連付ける
            //既存の関連付けを保持しつつ、新しいものを追加（重複を防ぐ）
            $book->authors()->syncWithoutDetaching($authorIds);
        }
    }
}
