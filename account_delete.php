<?php
//このファイルはユーザーにアカウント削除する時の確認をさせる。
//処理はaccount_kill.phpにさせる。
require_once __DIR__ . '/login_check.php';
session_start();
$token = bin2hex(random_bytes(20)); //ランダムなバイト列（２０）を16進数に変換する
$_SESSION['token'] = $token;
?>

<form action='account_kill.php' method='post'>
    <p>
        <label for='password'>パスワードを入力してください:</label>
        <input type='text' name='password'>
    </p>

    <p class='button'>
        <input type='hidden' name='token' value='<?php echo $token ?>'>
        <input type='submit' value='削除する'>
    </p>
</form>