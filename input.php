<?php
//このファイルはユーザーに追加するデータを入力させて、add.phpに値を渡す
session_start();
$token = bin2hex(random_bytes(20)); //ランダムなバイト列（２０）を16進数に変換する
$_SESSION['token'] = $token;
?>
<?php require_once __DIR__ . '/login_check.php'; ?>

<?php include __DIR__ . '/inc/header.php'; ?>
<form action='add.php' method='post'>
    <p>
        <label for='title'>タイトル（30文字まで）:</label>
        <input type='text' name='title'>
    </p>
    <p>
        <label for='isbn'>ISBN（13桁までの数字）:</label>
        <input type='text' name='isbn'>
    </p>
    <p>
        <label for='price'> 定価（5桁までの数字）:</label>
        <input type='text' name='price'>
    </p>
    <p>
        <label for='published'> 出版日（YYYY-MM-DD形式）:</label>
        <input type='text' name='publish'>
    </p>
    <p>
        <label for='author'> 著者（30文字まで）:</label>
        <input type='text' name='author'>
    </p>
    <p class='button'>
        <input type='hidden' name='token' value='<?php echo $token ?>'>
        <input type='submit' value=' 送信する'>
    </p>
</form>
<?php include __DIR__ . '/inc/footer.php'; ?>