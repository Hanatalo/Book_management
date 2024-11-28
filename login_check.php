<?php
//ログイン状態をチェックして、未ログインの場合はログインさせる。
//すでにログインしている場合はindex.phpに飛ばす
if (!isset($_SESSION)) {
    session_start();
}
if (empty($_SESSION['login'])) {
    echo " このページにアクセスするには<a href='login.php'> ログイン</a> が必要です。";
    exit;
}
echo "<!-- ログイン中-->";
