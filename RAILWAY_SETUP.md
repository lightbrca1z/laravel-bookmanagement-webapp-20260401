# Railway デプロイ設定ガイド

## 必要な設定

### 1. 環境変数（LaravelサービスのVariablesタブ）

RailwayのLaravelサービスの**Variables**タブで以下を設定してください：

#### 必須の環境変数

```
APP_DEBUG=false
APP_ENV=production
APP_KEY=base64:c7PqhDZ8cYaOlPwW5YpZLRMyaN6KkGm+oTAC+ivRzzU=
APP_NAME="Laravel Book Management"
DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST}
DB_PORT=${MYSQLPORT}
DB_DATABASE=${MYSQLDATABASE}
DB_USERNAME=${MYSQLUSER}
DB_PASSWORD=${MYSQLPASSWORD}
```

#### オプションの環境変数（推奨）

```
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
```

**重要：**
- MySQLサービスとLaravelサービスを接続してください（MySQLサービスを選択 → Connect → Laravelサービスを選択）
- 接続後、`MYSQLHOST`、`MYSQLDATABASE`などの変数が自動的に利用可能になります
- `DB_CHARSET`と`DB_COLLATION`はデフォルト値がありますが、明示的に設定することを推奨します

### 2. Build Command（Settingsタブ → Build）

Settingsタブの**Build Command**に以下を設定：

```bash
composer install --no-dev --optimize-autoloader && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

### 3. Deploy Command または Release Command（Settingsタブ → Deploy）

Settingsタブの**Deploy Command**または**Release Command**に以下を設定：

```bash
php artisan migrate --force
```

### 4. Custom Start Command（Settingsタブ → Start）

**空欄のまま**にしてください（Procfileの`web:`コマンドが使用されます）

または、設定する場合は：

```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```

## Procfile

現在のProcfileは正しく設定されています：

```
web: php artisan serve --host=0.0.0.0 --port=$PORT
```

## トラブルシューティング

### 500エラーが発生する場合

1. **環境変数を確認**
   - `APP_KEY`が設定されているか
   - MySQLサービスと接続されているか
   - データベース接続情報が正しいか

2. **ログを確認**
   - Railwayダッシュボード → サービスの**Deployments**タブ → 最新のデプロイのログを確認

3. **一時的にデバッグモードを有効化**
   - `APP_DEBUG=true`に設定してエラーの詳細を確認
   - 原因が分かったら`APP_DEBUG=false`に戻す

4. **マイグレーションが実行されているか確認**
   - Deploy Commandでマイグレーションが実行されているか確認

### データベース接続エラー

- MySQLサービスが起動しているか確認
- LaravelサービスとMySQLサービスが接続されているか確認
- 環境変数で`${MYSQLHOST}`などの形式が正しいか確認（`${{MYSQLHOST}}`ではなく`${MYSQLHOST}`）

## デプロイ手順

1. 上記の環境変数とコマンドをRailwayのUIで設定
2. Gitリポジトリにプッシュ（Railwayが自動的にデプロイ）
3. または、Railwayダッシュボードで手動デプロイ
