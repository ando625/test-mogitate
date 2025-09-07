# test-mogi


## 環境開発

1. git clone git@github.com:Estra-Coachtech/laravel-docker-template.git クローン

2. DockerDesktopアプリ立ち上げ

3. docker compose up -d --build

- platform: linux/x86_64  エラーが出たらymlのmysqlとphpmyadminに追加
  mysql:
    image: mysql:8.0.26
    platform: linux/x86_64
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: laravel_db
      MYSQL_USER: laravel_user
      MYSQL_PASSWORD: laravel_pass

4. docker compose exec php bash

5. composer install　　　　phpコンテナ内で実行
   composer -v
   cp .env.example .env　　初期状態では `.env.example` が用意されているので、以下のコマンドでコピーして `.env` を作成してください。

   .env以下の環境変数を追加
   DB_CONNECTION=mysql
   DB_HOST=mysql
   DB_PORT=3306
   DB_DATABASE=laravel_db
   DB_USERNAME=laravel_user
   DB_PASSWORD=laravel_pass

5. アプリケーションキーの作成
   php artisan key:generate

6. マイグレーションの実行
   php artisan migrate

7. シーディング実行
   php artisan db:seed





URL
開発環境：http://localhost/
phpMyAdmin:：http://localhost:8080/