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
- 会員登録、ログイン、ログアウト
- メール認証
- ユーザー情報取得
- ユーザー飲食店お気に入り一覧取得
- ユーザー飲食店予約情報取得
- ユーザー飲食店予約履歴情報取得（来店済のみ）
- 飲食店一覧取得
- 飲食店詳細取得
- 店舗お気に入り追加、削除
- 飲食店予約情報追加、日時および人数変更、削除
- エリア検索
- ジャンル検索
- 店名検索
- 評価機能（５段階評価およびコメント投稿）
- 来店時照合用QRコード表示
- リマインダー（予約当日の朝に予約情報のリマインダーメール送付）
- 有料サービスの決済

＜管理者のみ＞
- 店舗代表者登録
- 利用者全員へのお知らせメール送付

＜店舗代表者のみ＞
- 店舗テキスト情報登録（１ユーザーにつき１店舗）
- 店舗画像登録（１画像）
- 店舗情報更新
- 予約一覧取得（１日単位で表示）
- 予約者へのお知らせメール送付


## 使用技術
- PHP 8.3.0
- Laravel 11.28.1
- nginx 1.24.0
- MySQL 10.11.6

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
3. （暫定）\src\vendor内の３ファイルに修正を加えるため、PHPコンテナから出て`sudo chmod 777 -R .`を実行の上、以下のi~ⅵの修正をしてください。
   1. \src\vendor\laravel\fortify\config\fortify.phpの57行目を　'register'=>'thanks',　に修正
   2. ![alt text](/readme-img/fortify.png)
   3. \src\vendor\laravel\fortify\routes\routes.phpの77行目をコメントアウト（または削除）し、76行目の最後にセミコロンを追加
   4. ![alt text](/readme-img/route.png)
   5. \src\vendor\laravel\fortify\src\Http\Controllers\RegisteredUserController.phpの＄this->guard->login(＄user);をif (＄user->role == "general"){＄this->guard->login($user);}に修正
   6. ![alt text](/readme-img/controller.png)
4. `cp .env.sample .env` 新しく.envファイルを作成。(または、「.env.example」ファイルを 「.env」ファイルに命名を変更。)
5. .envを以下の環境変数に修正、追加

``` text
APP_FAKER_LOCALE=ja_JP

~中略~

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

~中略~

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="info@example.com"
MAIL_FROM_NAME="${APP_NAME}"

~中略~（以下、追加項目）

STRIPE_KEY=pk_test_51QA9jAK8zirmmtBqSTkynQElpZp1hPYwJ5TgKQSNIpa3iLCh9DoEsoyJMyKRC38siqwE1ggiXFBze8oh8p0dt5zw005Nyp17N5
STRIPE_SECRET=sk_test_51QA9jAK8zirmmtBqOOoTm8ko6Ske34B1dSmzqjlkLtBjqIJ2Io7KVaKhnHXpV3MvP3qXwFUUwSkM0TGA3Ut6WcpI00JI4N56Jq
STRIPE_PRICE_ID=price_1QAjNuK8zirmmtBqjNLwb0tJ
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

9. シンボリックリンク(店舗代表による画像追加)
``` bash
php artisan storage:link
```


**アプリケーションへのアクセス確認**
http://localhost/

※Permission deniedというエラーが発生した場合は、phpコンテナから一度出て次のコマンドをを実行してください。
```
sudo chmod -R 777 src/*
```


## 管理者アカウント（テストユーザー）
- （メールアドレス）admin@sample.com
- （パスワード）password

## 機能詳細説明・補足
- **＜評価機能＞**  
　予約したお店に来店した後に、利用者が店舗を5段階評価とコメントができます。
- **＜来店済ステータスへの変更＞**  
　評価機能を有効にするためには、利用者の来店状況ステータスを来店済に変更する必要がなります。現在、暫定的に店舗代表者専用Owner-pageの予約一覧画面の「来店済にする」ボタンを押下することで利用者のステータスを変更できます。
- **＜レスポンシブデザイン＞**  
　タブレット・スマートフォン用のレスポンシブデザインを採用しています。（ブレイクポイントは768px）
- **＜管理画面＞**  
　管理者と店舗代表者にはそれぞれ専用の管理画面が用意されています。画面左上のメニューアイコンに管理者はAdmin-page、店舗代表者はOwner-pageが表示されます。
- **＜管理者用管理画面　Admin-page＞**  
　店舗代表者登録後に認証のためのメールが登録したアドレスへ送付されます。店舗代表者側でメールの確認、認証を行っていただいてください。
　利用者へのお知らせメールは、アプリに登録されている全利用者（固定）へ送付されます。
- **＜店舗代表者用管理画面　Owner-page＞**  
　初回（店舗未登録時）は店舗登録フォームが表示されますので、店舗登録をする必要があります。店舗画像については、初回登録時に登録しないこともできます（その場合はNOW　PRINTING画像が代わりに登録されます）。店舗画像を含め、店舗情報は随時更新可能です。
　利用者へのお知らせメールは予約者にのみ送付することが可能です。
- **＜リマインダー＞**  
　タスクスケジューラーを利用して、予約当日の朝に予約情報のリマインダーを送ることができます。
※php artisan command:sendEmailsで即時送信処理
- **＜QRコード＞**  
　予約ID情報のみを埋め込んでいます。
- **＜決済機能＞**  
　アプリの有料サービス（買い切り型）の決済をStripeを利用して行うことができます。決済が完了すると、マイページのユーザーステータスが一般会員からプレミアム会員に変わります。  
　【テスト決済情報】  
　・テスト用カード番号は4242 4242 4242 4242を使用 。  
　・有効な将来の日付を使用 (12/34 など)。  
　・任意の 3 桁のセキュリティーコードを使用。  

## URL
- 開発環境：http://localhost/
- phpMyAdmin:：http://localhost:8080/
- mailhog::http://localhost:8025/