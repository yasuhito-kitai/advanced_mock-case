# Rese
Rese（リーズ）は飲食店の検索や情報チェック、予約ができるグルメアプリです。
![alt text](/readme-img/rese.png)

## 作成した目的
Laravelの学習のために作成しました。

## アプリの概要
このアプリは、飲食店の検索、予約、評価をスムーズに行うことができます。
また、店舗側は主に予約状況の確認や管理を行うことができます。

## アプリケーションURL
http://localhost/


## 機能一覧
・会員登録、ログイン、ログアウト
・メール認証
・ユーザー情報取得
・ユーザー飲食店お気に入り一覧取得
・ユーザー飲食店予約情報取得
・ユーザー飲食店予約履歴情報取得（来店済のみ）
・飲食店一覧取得
・飲食店詳細取得
・店舗お気に入り追加、削除
・飲食店予約情報追加、日時および人数変更、削除
・エリア検索
・ジャンル検索
・店名検索
・評価機能（５段階評価およびコメント投稿）
・来店時照合用QRコード表示
・リマインダー（予約当日の朝に予約情報のリマインダーメール送付）
・有料サービスの決済

＜管理者のみ＞
・店舗代表者登録
・利用者全員へのお知らせメール送付

＜店舗代表者のみ＞
・店舗テキスト情報登録（１ユーザーにつき１店舗）
・店舗画像登録（１画像）
・店舗情報更新
・予約一覧取得（１日単位で表示）
・予約者へのお知らせメール送付


## 使用技術
・PHP 8.3.0
・Laravel 11.28.1
・nginx 1.24.0
・MySQL 10.11.6

## テーブル設計
![alt text](/readme-img/usersテーブル.png)
![alt text](/readme-img/areasテーブル.png)
![alt text](/readme-img/genresテーブル.png)
![alt text](/readme-img/shopsテーブル.png)
![alt text](/readme-img/reservationsテーブル.png)
![alt text](/readme-img/favoritesテーブル.png)
![alt text](/readme-img/reviewsテーブル.png)

## ER図
![alt text](/readme-img/er.png)

## 環境構築

**Dockerビルド**

1. DockerDesktopアプリを立ち上げる
2. `git clone https://github.com/yasuhito-kitai/advanced_mock-case.git`
   または`git clone git@github.com:yasuhito-kitai/advanced_mock-case.git`
3. `docker-compose up -d --build`

**Laravel環境構築**
1. `docker-compose exec php bash`
2. `composer install`
3. `cp .env.sample .env` 新しく.envファイルを作成。(または、「.env.example」ファイルを 「.env」ファイルに命名を変更。)
4. .envを以下の環境変数に修正
``` text
APP_FAKER_LOCALE=ja_JP
~
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
~
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="info@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```
   アプリケーションキーの作成
``` bash
php artisan key:generate
```

   マイグレーションの実行
``` bash
php artisan migrate
```

   シーディングの実行
``` bash
php artisan db:seed
```

**アプリケーションにアクセス**
http://localhost/
※Permission deniedというエラーが発生した場合は、phpコンテナから一度出て
```
sudo chmod -R 777 src/*
```
を実行してください。


## URL
- 開発環境：http://localhost/
- phpMyAdmin:：http://localhost:8080/
- mailhog::http://localhost:8025/