<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('author', 100)->nullable()->after('title');
            $table->string('isbn', 13)->nullable()->after('author');
            $table->date('published_at')->nullable()->after('price');
            $table->text('description')->nullable()->after('published_at');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['author', 'isbn', 'published_at', 'description']);
        });
    }
};
