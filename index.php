<?php

//メイン画面
//主にデータベースに格納されている本の一覧を表示する
//機能は次の４つ：　更新、追加、ホームに戻る（このページ）、ログアウト

require_once __DIR__ . '/login_check.php';
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/header.php';
try {
    //PDOオブジェクト生成
    $dbh = db_open();
    //booksテーブルから全てのフィールドの値を抽出する
    $sql = 'SELECT * FROM books';
    //上記で抽出したデータを格納する
    $statement = $dbh->query($sql);
?>
    <table>
        <tr>
            <th>更新</th>
            <th>書籍名</th>
            <th>ISBN</th>
            <th>価格</th>
            <th>出版日</th>
            <th>著者名</th>
        </tr>
        <?php while ($row = $statement->fetch()): /*抽出されたPDOStatementオブジェクトから１行ずつ取得していく*/ ?>
            <tr>
                <td><a href="edit.php?id=<?php echo (int) $row['id']; ?>">更新</a></td>
                <td><?php echo str2html($row['title']) ?></td>
                <td><?php echo str2html($row['isbn']) ?></td>
                <td><?php echo str2html($row['price']) ?></td>
                <td><?php echo str2html($row['publish']) ?></td>
                <td><?php echo str2html($row['author']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php   //db_open()でthrowされたエラーを表示
} catch (PDOException $e) {
    //    echo "エラー原因: " . str2html($e->getMessage());
    exit;
}
?>
<?php include __DIR__ . '/inc/footer.php';
