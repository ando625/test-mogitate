# test-mogi


# 環境構築手順（Docker + Laravel）

このリポジトリは、Docker と Laravel 環境で動作するアプリケーションです。  
以下の手順でセットアップしてください。

---

## 1. リポジトリのクローン

git clone git@github.com:estra-inc/confirmation-test-contact-form.git
cd confirmation-test-contact-form

---

## 2. Docker コンテナの起動

Docker Desktop を起動して、以下を実行します：

docker-compose up -d --build



## 3. Laravel 環境構築

### 3-1. PHP コンテナに入る

docker-compose exec php bash

### 3-2. Composer で依存関係をインストール

composer install

### 3-3. .env ファイル作成

cp .env.example .env

.env に以下の環境変数を設定します：

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

### 3-4. アプリケーションキー生成

php artisan key:generate

### 3-5. データベース準備

- マイグレーション実行
php artisan migrate

- シーディング実行
php artisan db:seed

---

## 5. 注意事項

- Docker の MySQL データは Git には含めないよう .gitignore に設定済みです。  
- Mac M1/M2 でビルドエラーが出た場合は、platform: linux/x86_64 を追加してください。


## 4. 利用技術（実行環境）

- PHP: 8.3.0  
- Laravel: 8.83.27  
- MySQL: 8.0.26  

---

![ER図](public/images/er-diagram.png)



URL
開発環境：http://localhost/

phpMyAdmin:：http://localhost:8080/