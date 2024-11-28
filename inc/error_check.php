<?php
//ユーザーの入力時のエラーをチェックする

if (empty($_POST['title'])) {
    echo "タイトルを入力してください。";
    exit;
}
if (!preg_match('/\A[[:^cntrl:]]{1,30}\z/u', $_POST['title'])) {
    echo "タイトルが長すぎます。<br>";
    echo "タイトルは30文字までです。";
    exit;
}
if (!preg_match('/\A\d{0,13}\z/', $_POST['isbn'])) {
    echo "ISBN は数字13桁までです。";
    exit;
}
if (!preg_match('/\A\d{0,5}\z/u', $_POST['price'])) {
    echo "不正な数字が入力されました。<br>";
    echo "価格は数字5桁までです。";
    exit;
}
if (empty($_POST['publish'])) {
    echo "日付を入力してください";
    exit;
}
if (!preg_match('/\A\d{4}-\d{1,2}-\d{1,2}\z/u', $_POST['publish'])) {
    echo "日付のフォーマットが違います。<br>";
    echo "日付はyyyy-mm-ddの形式で入力してください。";
    exit;
}
$date = explode('-', $_POST['publish']);
if (!checkdate($date[1], $date[2], $date[0])) {
    echo "正しい日付を入力してください。";
    exit;
}
if (!preg_match('/\A[[:^cntrl:]]{0,30}\z/u', $_POST['author'])) {
    echo "著者名が長すぎます。<br>";
    echo "著者名は30文字以内で入力してください。";
    exit;
}
