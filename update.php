<?php
require_once __DIR__ . '/token_check.php';
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/error_check.php';
include __DIR__ . '/inc/header.php';
//リンク直打ちか何かでこのページを読み込んだ場合、更新ボタンを押させる
if (empty($_POST['id'])) {
    echo "更新ボタンを押してください。";
    exit;
}
//存在しないIDが選択された場合　→ 通常操作ではこうはならない。
if (!preg_match('/\A\d{0,11}\z/u', $_POST['id'])) {
    echo "不正な入力です。";
    exit;
}
//ユーザーが入力したデータをsel文に格納して実行する
try {
    $dbh = db_open();
    $sql = "UPDATE books SET title = :title , isbn = :isbn, price = :price, publish = :publish, author = :author WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $price = (int) $_POST['price'];
    $id = (int) $_POST['id'];
    $stmt->bindParam(":title", $_POST['title'], PDO::PARAM_STR);
    $stmt->bindParam(":isbn", $_POST['isbn'], PDO::PARAM_STR);
    $stmt->bindParam(":price", $price, PDO::PARAM_INT);
    $stmt->bindParam(":publish", $_POST['publish'], PDO::PARAM_STR);
    $stmt->bindParam(":author", $_POST['author'], PDO::PARAM_STR);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    echo "データの更新に成功しました。<br>";
    echo "<a href='index.php'>書籍一覧に戻る</a>";
} catch (PDOException $e) {
    //echo "エラー!: " . str2html($e->getMessage()) . "<br>";
    exit;
}
?>
<?php include __DIR__ . '/inc/footer.php';
