# アプリケーション概要
　フリマアプリ<br>
 　　会員登録をし、認証済みのユーザーはほかのユーザーが出品した商品を購入することができる。また、商品を出品することができ、商品ごとにコメントを送ったり、マイリスト登録をしたりすることができる。<br>

# 主な機能
  ・会員登録、ログイン機能、ログアウト機能<br>
　・メール認証<br>
　・商品一覧表示<br>
　・マイリスト表示<br>
　・出品した商品と購入した商品一覧を表示するマイページ<br>
　・プロフィール編集<br>
　・出品機能<br>
　・いいねボタンによるマイリスト追加及び解除<br>
　・コメント機能<br>
　・購入機能<br>
　・stripeによるコンビニ支払い、カード支払い機能<br>
# 環境構築
1.フリーマーケット用ディレクトリの作成、移動<br>
    mkdir free-market<br>
    cd free-market<br>
  2.フリーマーケットをクローン<br>
    git clone git@github.com:aoimita0619-prog/free-market.git<br>
  3.ディレクトリの移動<br>
    cd free-market<br>
  4.パッケージをインストール<br>
  　 docker-compose up -d --build<br> 
　5.Laravel環境構築<br>
 　docker-compose exec php bash<br>
　 composer install<br>
  6.envファイル作成<br>
  　cp .env.example .env<br>
  7.アプリケーションキーの作成<br>
   php artisan key:generate<br>
  6.データベースのマイグレーションとシーダーを実行<br>
   php artisan migrate:fresh --seed<br>
  7.シンボリックリンクの作成<br>
   php artisan storage:link
stripe設定<br>
1.	stripe dashboardにログインし、テスト環境に切り替える<br>
2.	開発者→APIキーから公開可能キー（pk_test_...）とシークレットキー（sk_test_...）を取得する。.envに公開可能キーとシークレットキーを以下のように書く。<br>
STRIPE_KEY=pk_test_xxxxxxxxx<br>
STRIPE_SECRET=sk_test_xxxxxxxxx<br>
3.	LaravelにStripe PHP SDKを入れる<br>
docker compose exec php bash<br>
composer require stripe/stripe-php<br>
4.	stripe CLIをダウンロード（ダウンロード済の場合、省略）<br>
curl -L https://github.com/stripe/stripe-cli/releases/latest/download/stripe_linux_x86_64.tar.gz -o stripe.tar.gz<br>
ファイルを展開する<br>
tar -xvf stripe.tar.gz<br>
stripeをコマンドで使えるようにする<br>
sudo mv stripe /usr/local/bin/stripe<br>
5.	Stripeにログイン<br>
stripe login<br>
ブラウザを開き、Your pairing code is: xxxx-xxxx-xxxxに書かれているコードを入力する<br>
6. Webhookを使う<br>
    stripe listen --forward-to localhost/stripe/webhook<br>
    実行すると、Ready! Your webhook signing secret is whsec_...と出てくるので、envに以下のように書く<br>
　　STRIPE_WEBHOOK_SECRET=whsec_...<br>

# 実行環境
  ・PHP 8.1<br>
  ・Laravel 8.83.29<br>
  ・MySQL8.0.26<br>
  ・nginx1.21.1<br>
  ・mailhog<br>
  ・stripe<br>
  ・webhook<br>
 
# ER図
　<img width="561" height="711" alt="ER" src="https://github.com/user-attachments/assets/7201054b-6106-43eb-8604-368c41835e2d" />

# URL
  ・商品一覧画面（トップ）:http://localhost/<br>
  ・ログイン画面:http://localhost/login<br>
  ・ユーザー登録画面:http://localhost/register<br>
　・phpMyAdmin: http://localhost:8080/<br>
  ・MailHog: http://localhost:8025/<br>

# テーブル設計
・usersテーブル<br>
　ユーザーアカウントの情報を管理するテーブル<br>
・itemsテーブル<br>	
　出品された商品の情報を管理するテーブル<br>
・conditionsテーブル<br>
　商品の状態の種類を管理するテーブル<br>
・categoriesテーブル<br>
　商品のカテゴリーの情報を管理するテーブル<br>
・item_categoryテーブル<br>
　出品された商品とカテゴリーの中間テーブル<br>
・commentsテーブル<br>
　商品に送られたコメントの情報を管理するテーブル<br>
・facoritesテーブル<br>
　商品のマイリスト情報を管理するテーブル<br>
・purchasesテーブル<br>
　購入された商品の情報を管理するテーブル<br>
# テストユーザー情報
・ユーザー１<br>
name：テストユーザー<br>
email：test@example.com<br>
password：password<br>
post_code：111-1111<br>
address：東京都新宿区西新宿1-1-1<br>
building：テストビル101<br>
・ユーザー２<br>
name：山田太郎<br>
email：user@example.com<br>
password：password<br>
post_code：222-2222<br>
address：大阪府堺市堺区2-2-2<br>
building：なし<br>
・ユーザー３<br>　
name：高橋花子<br>
email：usera@example.com<br>
password：password<br>
post_code：333-3333<br>
address：愛知県名古屋市中区錦3-3<br>
building：テストハウス303<br>
・ユーザー２<br>　
name：田中次郎<br>
email：userb@example.com<br>
password：password<br>
post_code：444-4444<br>
address：福岡県福岡市中央区天神44<br>
building：天神テストビル444<br>
# テストについて
主に以下の機能をテストした<br>。
・会員登録<br>
　名前、メールアドレス、パスワード、確認用パスワードを入力して、アカウントが作成できる<br>
・メール認証<br>
　アカウント作成後、メールが届き、認証できる<br>
・ログイン機能<br>
　会員登録したアカウントでログインできる<br>
・出品機能<br>
　必要項目を入力し、出品ができる<br>
・マイリスト機能<br>
　商品詳細画面で、いいねボタンを押すと、マイリスト一覧に表示され、再度押すと解除される<br>
・コメント機能<br>
　商品詳細画面で、コメントを送信できる<br>
・プロフィール編集機能<br>
　プロフィールを編集できる<br>
・購入機能<br>
　支払方法を選択し、商品を購入することができる<br>
・画像アップロード機能<br>
　画像をアップロードすることができ、画面に反映される<br>
・バリデーション<br>
　会員登録、ログイン、出品、プロフィール編集を行う際に、入力に不備があった場合、バリデーションが表示される。<br>


