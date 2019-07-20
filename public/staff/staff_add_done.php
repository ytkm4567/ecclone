<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ECClone</title>
</head>
<body>

<?php

session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false) {
    print 'ログインが必要です。<br>';
    print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
    exit();
} else {
    print $_SESSION['staff_name'];
    print 'さんログイン中<br>';
    print '<br>';
}

require_once('../common.php');
require_once('../mysqlconf.php');

try {
    $post = sanitize($_POST);
    $staff_name = $post['name'];
    $staff_pass = $post['pass'];

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
