
<?php
//new_account.phpで入力されたデータを処理する
//SQLを実行してデータを追加する
require_once __DIR__ . '/token_check.php';
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/header.php';

//全部入力されているかチェックする
if (
    (empty($_POST['username'])) || empty($_POST['password']) || empty($_POST['password1'])
) {
    echo "未入力欄があります。";
    header("Location:new_account.php");
    exit;
}

//パスワードの打ち間違えの確認をチェックする
if ($_POST['password'] === $_POST['password1']) {

    //打ち間違えが認められない場合、そのパスワードをハッシュ化する
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
} else {
    echo 'パスワードが一致していません。';
    header("Location:new_account.php");
    exit;
}

try {
    //PDOオブジェクトの作成
    $dbh = db_open();
    //booksテーブルの各フィールドに値：valueを入れる
    $sql = "INSERT INTO users (id, username, password) VALUES (NULL, :username, :password)";
    //後からsql文を実行するように準備する
    $stmt = $dbh->prepare($sql); //プリペアードステートメント　。ここでは$sqlは実行されない。

    //PDOStatementオブジェクトののbindParamメソッドで各値をはめ込む。
    $stmt->bindParam(":username", $_POST['username'], PDO::PARAM_STR);
    $stmt->bindParam(":password", $password, PDO::PARAM_STR);
    //ここで各値がプレースホルダーと置換された状態でSQL文が実行される
    //$stmt->execute(array(':username' => $_POST['username'], ':password' => password_hash($_POST['password'], PASSWORD_DEFAULT)));
    $stmt->execute();
    echo "アカウントの作成に成功しました。<br>";
    echo "<a href='index.php'>リストへ戻る</a>";
} catch (PDOException $e) {
    echo "エラー原因: " . str2html($e->getMessage()) . "<br>";
    exit;
}
?>
<?php include __DIR__ . '/inc/footer.php';
