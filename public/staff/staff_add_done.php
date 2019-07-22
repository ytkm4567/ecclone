<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ECClone</title>
</head>
<body>

<?php

require_once('../common.php');
require_once('../common.php');
require_once('../mysqlconf.php');

session_start();
session_regenerate_id(true);

check_csrf_token();
staff_login_check();

try {
    $post = sanitize($_POST);
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
    $sql = 'INSERT INTO mst_staff(name, password) VALUES (?, ?)';
    // PDOStatmentオブジェクトを生成
    $stmt = $dbh->prepare($sql);
    $data[] = $staff_name;
    $data[] = $staff_pass;
    // SQL文を実行
    $stmt->execute($data);

    /*
     * データベースからの切断
     */
    $dbh = null;

    print $staff_name.'さんを追加しました。<br />';
} catch(Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    print $e;
    exit();
}
?>

<a href="staff_list.php">戻る</a>
</body>
</html>
