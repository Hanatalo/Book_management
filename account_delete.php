<?php
require_once __DIR__ . '/login_check.php';
require_once __DIR__ . '/inc/functions.php';
//PDOオブジェクトの作成

try {
    //PDOオブジェクトの作成
    $dbh = db_open();

    $sql = "DELETE FROM users WHERE users.username = :username";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":username", $_SESSION['this_user'], PDO::PARAM_STR);
    $stmt->execute();
    echo "<br>アカウントを削除しました。<br>";
    echo "<a href='index.php'>リストに戻る</a>";
    $result = $stmt->fetch(PDO::FETCH_ASSOC); //resultフィールド名をキーとして配列を格納
    //該当データが存在しない場合
} catch (PDOException $e) {
    echo "エラー!: " . str2html($e->getMessage());
    exit;
}
