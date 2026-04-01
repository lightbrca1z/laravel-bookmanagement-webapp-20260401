<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('author_details', function (Blueprint $table) {
        $table->foreignId('author_id')->constrained()->onDelete('cascade')->primary(); // 主キーに
        $table->string('email', 100)->nullable();
        $table->string('address', 100)->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('author_details');
    }
};
