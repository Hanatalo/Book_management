<?php

//ログイン画面を表示する
session_start();
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/header.php';
?>
<form method='post' action='login.php' class='loginform'>
    <p>
        <label for="username">ユーザ名:</label>
        <input type='text' name='username'>
    </p>
    <p>
        <label for="password">パスワード:</label>
        <input type='password' name='password'>
    </p>
    <input type='submit' value='送信する'>
</form>
<?php

if (!empty($_SESSION['login'])) {
    echo "ログイン済です<br>";
    echo "<a href=index.php>リストに戻る</a>";
    exit;
}
if ((empty($_POST['username'])) || (empty($_POST['password']))) {
    echo "ユーザ名、パスワードを入力してください。";
    exit;
}

try {
    $dbh = db_open();
    $sql = "SELECT password FROM users WHERE username = :username"; //一致するユーザー名からパスワードを取得
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":username", $_POST['username'], PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC); //resultフィールド名をキーとして配列を格納
    //該当データが存在しない場合
    if (!$result) {
        echo "ログインに失敗しました。";
        exit;
    }
    //パスワードが一致したらIDを発行してlogin状態にする
    if (password_verify($_POST['password'], $result['password'])) {
        session_regenerate_id(true); //セッションIDを再生成する
        $_SESSION['login'] = true; //ログイン状態にする
        $_SESSION['this_user'] = $_POST['username'];
        echo "ログインします";
        header("Location: index.php"); //index.phpに移動
    } else {
        echo 'ログインに失敗しました。'; //パスワードが一致しないので終了
        exit;
    }
} catch (PDOException $e) {
    //echo "エラー!: " . str2html($e->getMessage());
    exit;
}

header("Location: index.php");
