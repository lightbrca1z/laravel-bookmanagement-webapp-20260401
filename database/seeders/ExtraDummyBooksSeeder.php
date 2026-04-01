<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class ExtraDummyBooksSeeder extends Seeder
{
    /**
     * BookmanagerDummyDataSeeder 実行後を想定。書籍を 20 件追加する。
     * Faker を使わない（本番 --no-dev でも動く）。
     */
    public function run(): void
    {
        $owner = User::query()->where('userid', 'test1')->first();
        if ($owner === null) {
            throw new RuntimeException('ExtraDummyBooksSeeder: user test1 が見つかりません。先に BookmanagerDummyDataSeeder を実行してください。');
        }

        $categoryIds = Category::query()->pluck('id');
        if ($categoryIds->isEmpty()) {
            throw new RuntimeException('ExtraDummyBooksSeeder: categories がありません。');
        }

        $authorIdList = Author::query()->pluck('id')->all();

        foreach (range(1, 20) as $i) {
            $book = Book::query()->create([
                'user_id' => $owner->id,
                'category_id' => (int) $categoryIds->random(),
                'title' => $this->titleFor($i),
                'author' => $this->authorNameFor($i),
                'isbn' => $this->isbn13For($i),
                'price' => random_int(890, 9890),
                'published_at' => now()->subDays(random_int(60, 2400))->format('Y-m-d'),
                'description' => $this->descriptionFor($i),
            ]);

            if ($authorIdList !== []) {
                $maxPick = min(3, count($authorIdList));
                $pickCount = random_int(1, $maxPick);
                $shuffled = $authorIdList;
                shuffle($shuffled);
                $book->authors()->attach(array_slice($shuffled, 0, $pickCount));
            }
        }
    }

    private function titleFor(int $i): string
    {
        $parts = [
            'API設計ノート', 'データモデリング入門', 'UIレビュー手順', 'チーム運営ログ',
            '読書メモ集', '要件整理テンプレ', 'テスト観点リスト', 'デプロイチェック',
            'セキュリティ覚書', 'パフォーマンス記録', 'リファクタリング日誌', '設計レビュー抄',
            'ユーザー調査メモ', 'KPIダッシュボード案', '障害対応記録', 'コード規約ドラフト',
            'アクセシビリティ指針', 'キャッシュ戦略メモ', 'ログ設計ノート', 'マイグレーション手順',
        ];

        return sprintf('%s（追加 #%02d）', $parts[$i - 1], $i);
    }

    private function authorNameFor(int $i): string
    {
        $names = [
            '佐藤 誠', '鈴木 あかり', '高橋 健', '田中 みどり', '伊藤 直樹',
            '渡辺 さくら', '山本 大輔', '中村 結衣', '小林 翔', '加藤 麻衣',
            '吉田 拓海', '山田 花子', '佐々木 涼', '松本 恵', '井上 剛',
            '木村 優子', '林 修平', '清水 舞', '森 亮', '池田 奈々',
        ];

        return $names[$i - 1];
    }

    private function isbn13For(int $i): string
    {
        $base = str_pad((string) (978000000000 + $i * 137), 12, '0', STR_PAD_LEFT);

        return $base.$this->isbn13CheckDigit($base);
    }

    private function isbn13CheckDigit(string $first12): string
    {
        $sum = 0;
        for ($p = 0; $p < 12; $p++) {
            $d = (int) $first12[$p];
            $sum += ($p % 2 === 0) ? $d : $d * 3;
        }

        return (string) ((10 - ($sum % 10)) % 10);
    }

    private function descriptionFor(int $i): string
    {
        return "追加シード用のダミー本文です（#{$i}）。一覧・詳細表示の確認用に複数行の説明を入れています。\n\nRailway 本番の db:seed でも Faker なしで動作するよう静的生成しています。";
    }
}
