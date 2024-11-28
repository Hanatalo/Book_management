<?php
//ログアウト状態を作る
session_start();
$_SESSION = array(); //セッション変数を初期化する
session_destroy();  //セッションを破棄する
header("Location: login.php");//ログイン画面まで戻る
