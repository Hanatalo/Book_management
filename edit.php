<?php
//更新ボタンを押したところの行に値を格納する
//その後の処理をupdate.phpに渡す
session_start();
require_once __DIR__ . '/login_check.php';
require_once __DIR__ . '/inc/functions.php';


$token = bin2hex(random_bytes(20));
$_SESSION['token'] = $token;

if (empty($_GET['id'])) {
    echo "更新ボタンをクリックしてください";
    exit;
}
//IDは１１項目までしか用意していない。
if (!preg_match('/\A\d{1,11}+\z/u', $_GET['id'])) {
    echo "不正な値が入力されました。";
    exit;
}

$id = (int) $_GET['id']; //index.phpで更新ボタンが押されたところのidを取得する

$dbh = db_open();
$sql = "SELECT id, title, isbn, price, publish, author FROM books WHERE id = :id"; //booksテーブルからid＝:idとなっている行だけ抽出
$stmt = $dbh->prepare($sql); //後でsql文を実行する

$stmt->bindParam(":id", $id, PDO::PARAM_INT); //クリックした部分のidをsql文に組み込む。　上記のsql文の:idを＄idと置換する
$stmt->execute(); //sqlを実行する　
$result = $stmt->fetch(PDO::FETCH_ASSOC); //結果をフィールド名がキーとなる配列で格納

//一つも該当するデータが存在しない場合　→ 基本的には発生しないが、urlに直打ちでidをした場合などに存在しないidにアクセスする。その場合はexit
if (!$result) {
    echo "指定したデータはありません。";
    exit;
}
//上でPDO：：GETCH_ASSOCパラメータを指定しているから、以下のコードでは$resultのキーにフィールド名が使える。
//抽出したものを無害化して各変数に格納する
$title = str2html($result['title']);
$isbn = str2html($result['isbn']);
$price = str2html($result['price']);
$publish = str2html($result['publish']);
$author = str2html($result['author']);
$id = str2html($result['id']);

//値が格納された状態で編集できる画面が表示される

$html_form = <<<EOD
<form action='update.php' method='post' class='editform'>
    <p>
    <label for='title'>タイトル:</label>
    <input type='text' name='title' value='$title'>
    </p>
    <p>
    <label for='isbn'>ISBN:</label>
    <input type='text' name='isbn' value='$isbn'>
    </p>
    <p>
    <label for='price'>価格:</label>
    <input type='text' name='price' value='$price'>
    </p>
    <p>
    <label for='published'>出版日:</label>
    <input type='text' name='publish' value='$publish'>
    </p>
    <p>
    <label for='author'>著者:</label>
    <input type='text' name='author' value='$author'>
    </p>
    <p class='button'>
    <input type='hidden' name='id' value='$id'>
    <input type='hidden' name='token' value='$token'>
    <input type='submit' value='送信する'>
    </p>
</form>
EOD;

include __DIR__ . '/inc/header.php';
echo $html_form;
include __DIR__ . '/inc/footer.php';
