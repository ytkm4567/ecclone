<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ECClone</title>
</head>
<body>

<?php

require_once('../common.php');
require_once('../mysqlconf.php');

session_start();
session_regenerate_id(true);

check_csrf_token();
check_staff_login();

try {
    $post = sanitize($_POST);
    $staff_code = $post['code'];
    $staff_name = $post['name'];
    $staff_pass = $post['pass'];

    // 入力が不正な場合戻るボタンのみ表示する
    if($staff_name === '' || $staff_pass === '') {
        print '入力が不正です。';
        print '<form>';
        print '<input type="button" onclick="history.back()" value="戻る">';
        print '</form>';
        exit();
    }

    // データベースへの接続
    $dbh = new_pdo();

    /*
     * SQL文の実行
     */
    $sql = 'UPDATE mst_staff SET name=?, password=? WHERE code=?';
    // PDOStatmentオブジェクトを生成
    $stmt = $dbh->prepare($sql);
    $data[] = $staff_name;
    $data[] = $staff_pass;
    $data[] = $staff_code;
    // SQL文を実行
    $stmt->execute($data);

    /*
     * データベースからの切断
     */
    $dbh = null;

    print '修正しました。<br><br>';

} catch(Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    print $e;
    exit();
}
?>

<a href="staff_list.php">戻る</a>
</body>
</html>
