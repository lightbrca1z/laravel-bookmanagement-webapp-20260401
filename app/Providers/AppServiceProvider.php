<?php

namespace App\Providers;

use App\Http\Controllers\Auth\LoginController;
use App\Models\Book;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
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
        $this->configurePublicUrlForHostedEnvironment();
        $this->registerLoginRoutesIfMissing();

        Route::bind('book', function (string $value) {
            return Book::query()
                ->whereKey($value)
                ->where('user_id', auth()->id())
                ->firstOrFail();
        });
    }

    /**
     * Railway 等: プロキシ越しの公開 URL と APP_URL のずれを補う。
     * （config:cache 後は env('APP_URL') が使えない場合があるため config を参照する）
     */
    /**
     * routes/web.php が未更新のデプロイ（初期 Laravel の welcome のみ等）でも /login を生やす。
     */
    private function registerLoginRoutesIfMissing(): void
    {
        if (! Route::has('login')) {
            Route::middleware(['web', 'guest'])->get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        }

        if (! Route::has('login.attempt')) {
            Route::middleware(['web', 'guest'])->post('/login', [LoginController::class, 'login'])->name('login.attempt');
        }
    }

    private function configurePublicUrlForHostedEnvironment(): void
    {
        $railwayDomain = env('RAILWAY_PUBLIC_DOMAIN');

        if (is_string($railwayDomain) && $railwayDomain !== '') {
            $publicUrl = 'https://'.trim($railwayDomain, '/');
            $current = rtrim((string) config('app.url'), '/');
            if ($current === '' || str_contains($current, 'localhost') || str_starts_with($current, 'http://127.')) {
                config(['app.url' => $publicUrl]);
            }
        }

        $appUrl = rtrim((string) config('app.url'), '/');
        if ($appUrl !== '' && str_starts_with($appUrl, 'https://')) {
            URL::forceScheme('https');
            URL::forceRootUrl($appUrl);
            if (config('session.secure') === null) {
                config(['session.secure' => true]);
            }
        }
    }
}
