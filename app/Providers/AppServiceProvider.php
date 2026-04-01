<?php

namespace App\Providers;

use App\Models\Book;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
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
        $this->configureRailwaySessionDriver();
        $this->configureSessionDriverWhenDatabaseUnavailable();
        $this->configurePublicUrlForHostedEnvironment();

        Route::bind('book', function (string $value) {
            return Book::query()
                ->whereKey($value)
                ->where('user_id', auth()->id())
                ->firstOrFail();
        });
    }

    /**
     * Railway では複数レプリカや一時ストレージの影響で file セッションがリクエスト間で共有されず、
     * ログイン POST で CSRF トークル不一致（419）になりやすい。cookie ドライバは同一ホスト内で安定する。
     * （getenv: config:cache 後も実環境の変数を参照できる）
     */
    private function configureRailwaySessionDriver(): void
    {
        $railwayEnv = getenv('RAILWAY_ENVIRONMENT');
        if ($railwayEnv === false || $railwayEnv === '') {
            return;
        }

        if (config('session.driver') === 'file') {
            config(['session.driver' => 'cookie']);
        }
    }

    /**
     * SESSION_DRIVER=database なのに sessions テーブルが無いと、ログイン時の regenerate() で 500 になる。
     */
    private function configureSessionDriverWhenDatabaseUnavailable(): void
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        try {
            $table = (string) config('session.table', 'sessions');
            if (! Schema::hasTable($table)) {
                config(['session.driver' => 'cookie']);
            }
        } catch (\Throwable) {
            config(['session.driver' => 'cookie']);
        }
    }

    /**
     * Railway 等: プロキシ越しの公開 URL と APP_URL のずれを補う。
     * （config:cache 後は env('APP_URL') が使えない場合があるため config を参照する）
     */
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
