<?php
//input.phpで入力されたデータを処理する
//SQLを実行してデータを追加する
require_once __DIR__ . '/token_check.php';
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/error_check.php';
include __DIR__ . '/inc/header.php';

try {
    //PDOオブジェクトの作成
    $dbh = db_open();
    //booksテーブルの各フィールドに値：valueを入れる。
    $sql = "INSERT INTO books (id, title, isbn, price, publish, author) VALUES (NULL, :title, :isbn, :price, :publish, :author)";
    //後からsql文を実行するように準備する
    $stmt = $dbh->prepare($sql); //プリペアードステートメント　。ここでは$sqlは実行されない。
    $price = (int) $_POST['price'];
    //PDOStatementオブジェクトののbindParamメソッドで各値をはめ込む。
    $stmt->bindParam(":title", $_POST['title'], PDO::PARAM_STR);
    $stmt->bindParam(":isbn", $_POST['isbn'], PDO::PARAM_STR);
    $stmt->bindParam(":price", $price, PDO::PARAM_INT);
    $stmt->bindParam(":publish", $_POST['publish'], PDO::PARAM_STR);
    $stmt->bindParam(":author", $_POST['author'], PDO::PARAM_STR);
    //ここで各値がプレースホルダーと置換された状態でSQL文が実行される
    $stmt->execute();
    echo "データが追加されました。<br>";
    echo "<a href='index.php'>リストへ戻る</a>";
} catch (PDOException $e) {
    //echo "エラー原因: " . str2html($e->getMessage()) . "<br>";
    exit;
}
?>
<?php include __DIR__ . '/inc/footer.php';
