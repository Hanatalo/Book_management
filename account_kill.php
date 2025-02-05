
<?php
require_once __DIR__ . '/token_check.php';
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/error_check.php';
include __DIR__ . '/inc/header.php';

//入力されているかチェックする
if (empty($_POST['username']) || empty($_POST['password'])) {
    echo '未入力欄があります';
    header("Location:account_delete.php");
    exit;
}
try {
    //PDOオブジェクトの作成
    $dbh = db_open();

    $sql = "SELECT password FROM users WHERE username = :username"; //一致するユーザー名からパスワードを取得
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":username", $_POST['username'], PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC); //resultフィールド名をキーとして配列を格納
    //該当データが存在しない場合

    if (!$result) {
        echo "該当アカウントを削除できませんでした。";
        exit;
    }
    //パスワードが一致したらアカウントを削除する
    if (password_verify($_POST['password'], $result['password'])) {

        $sql = "DELETE FROM users WHERE users . username = :username";
        $stmt->execute();
        echo "アカウントが削除されました。<br>";
        echo "<a href='index.php'>リストへ戻る</a>";
    } else {
        echo 'ログインに失敗しました。'; //パスワードが一致しないので終了
        exit;
    }
} catch (PDOException $e) {
    echo "エラー!: " . str2html($e->getMessage());
    exit;
}
?>

<?php include __DIR__ . '/inc/footer.php'; ?>
