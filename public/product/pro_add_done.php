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
staff_login_check();

require_once('../common.php');
require_once('../mysqlconf.php');

try {
    $post = sanitize($_POST);
    $pro_name = $post['name'];
    $pro_price = $post['price'];
    $pro_image_name = $post['image_name'];

    // データベースへの接続
    $dbh = new_pdo();

    /*
     * SQL文の実行
     */
    $sql = 'INSERT INTO mst_product(name, price, image) VALUES (?, ?, ?)';
    // PDOStatmentオブジェクトを生成
    $stmt = $dbh->prepare($sql);
    $data[] = $pro_name;
    $data[] = $pro_price;
    $data[] = $pro_image_name;
    // SQL文を実行
    $stmt->execute($data);

    /*
     * データベースからの切断
     */
    $dbh = null;

    print $pro_name.'を追加しました。<br>';
} catch(Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    print $e;
    exit();
}
?>

<a href="pro_list.php">戻る</a>
</body>
</html>
