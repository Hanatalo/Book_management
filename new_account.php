<?php
//このファイルはユーザーに追加するデータを入力させて、create_account.phpに値を渡す
session_start();
$token = bin2hex(random_bytes(20)); //ランダムなバイト列（２０）を16進数に変換する
$_SESSION['token'] = $token;

?>
<?php include __DIR__ . '/inc/header.php'; ?>

<form action='create_account.php' method='post'>
    <p>
        <label for='username'>ユーザーネーム:</label>
        <input type='text' name='username'>
    </p>
    <p>
        <label for='password'>パスワード:</label>
        <input type='text' name='password'>
    </p>
    <p>
        <label for='password1'>パスワードを再入力:</label>
        <input type='text' name='password1'>
    </p>

    <p class='button'>
        <input type='hidden' name='token' value='<?php echo $token ?>'>
        <input type='submit' value=' 送信する'>
    </p>
</form>
<?php include __DIR__ . '/inc/footer.php'; ?>