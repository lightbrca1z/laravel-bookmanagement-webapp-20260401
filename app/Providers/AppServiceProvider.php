<?php

namespace App\Providers;

use App\Models\Book;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::bind('book', function (string $value) {
            return Book::query()
                ->whereKey($value)
                ->where('user_id', auth()->id())
                ->firstOrFail();
        });
    }
}
