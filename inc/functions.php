<?php

//このファイル内にはデータベースのテーブル名、テーブルに登録されたユーザー名、それに対応するパスワード
//が書き込まれていない。今後自分でテーブルを作成して登録したユーザー名、パスワードを
//それぞれ書き込んでから使って。





//入力された文字列を無害化する
function str2html(string $string): string
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
//PDOオブジェクトを作る
function db_open(): PDO
{
    $user = "データベースのユーザー名を入力する";  //ユーザー名を書き込むこと
    //パスワードはハッシュ値の方がいいよ。
    $password = "対応するパスワードを入力する。基本的にハッシュ値がいい"; //パスワードを書き込むこと

    //オプション
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //エラーが出た時にPDOExceptionをthrow
        PDO::ATTR_EMULATE_PREPARES => false, //プリペアードステートメントを無効
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => false, //マルチクエリを無効
    ];
    //PDOオブジェクトの新規作成
    //テーブル名を入力すること。　例： dename=sample_db;
    $dbh = new PDO('mysql:host=localhost;dbname=自分で作ったテーブルの名前', $user, $password, $opt);

    return $dbh;
}
