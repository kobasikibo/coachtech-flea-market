# coachtechフリマ（フリマサービス）

## 環境構築
**Dockerビルド**
1. `git clone git@github.com:kobasikibo/coachtech-flea-market.git`
2. DockerDesktopアプリを立ち上げる
3. `docker-compose up -d --build`

> *`unknown variable ‘default-authentication-plugin`のメッセージが表示されビルドができないことがあります。
エラーが発生する場合は、compose.yamlファイルの「mysql」内ある「command」の項目を削除、または修正してください*
``` bash
mysql:
    image:
    environment:
    command:（この項目を削除、または修正）
            mysqld --default-authentication-plugin=mysql_native_password（MySQL8.0以降はこちらの設定が必要ない場合や異なる設定が必要な場合があります。）
    volumes:
```

**Laravel環境構築**
1. `docker-compose exec php bash`
2. `composer -v`
3. `composer create-project --prefer-dist laravel/laravel .`
4. 「.env.example」ファイルを 「.env」ファイルに命名を変更。
5. .envに以下の環境変数を追加
``` text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
6. アプリケーションキーの作成
``` bash
php artisan key:generate
```
7. マイグレーションの実行
``` bash
php artisan migrate
```
8. シーディングの実行
``` bash
php artisan db:seed
```

## 使用技術(実行環境)
- PHP8.3.11
- Laravel11.23.5
- MySQL9.0.1

## ER図
![ER](src/database/diagrams/er_diagram.png)

## URL
- 開発環境：http://localhost/
- phpMyAdmin:：http://localhost:8081/
