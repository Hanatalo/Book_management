<?php
require_once __DIR__ . '/token_check.php';
require_once __DIR__ . '/login_check.php';
require_once __DIR__ . '/inc/functions.php';

//パスワードが入力されていない場合にもう一度入力を促す
if (empty($_POST['password'])) {
    echo "パスワードが未入力です。";
    header("Location: account_delete.php");
    exit;
}

try {
    //PDOオブジェクトの作成
    $dbh = db_open();
    //パスワードを　取得する
    $sql = "SELECT password FROM users WHERE username = :username";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":username", $_SESSION['this_user'], PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($_POST['password'], $result['password'])) {
        $sql = "DELETE FROM users WHERE users.username = :username";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":username", $_SESSION['this_user'], PDO::PARAM_STR);
        $stmt->execute();
        echo "<br>アカウントを削除しました。<br>";
        echo "<a href='index.php'>リストに戻る</a>";
    } else {
        echo "削除に失敗しました。";
        header("Location: account_delete.php");
        exit;
    }
} catch (PDOException $e) {
    echo "エラー!: " . str2html($e->getMessage());
    exit;
}
