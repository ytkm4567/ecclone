<?php
require_once(dirname ( __FILE__ ).'/../common.php');
require_once(dirname ( __FILE__ ).'/../mysqlconf.php');

session_start();
session_regenerate_id(true);
check_csrf_token();
check_staff_login();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ECClone</title>
</head>
<body>

<?php
try {
    $post = sanitize($_POST);
    $pro_code = $post['code'];
    $pro_image_name = $post['image_name'];

    // データベースへの接続
    $dbh = new_pdo();

    /*
     * SQL文の実行
     */
    $sql = 'DELETE FROM mst_product WHERE code=?';
    // PDOStatmentオブジェクトを生成
    $stmt = $dbh->prepare($sql);
    $data[] = $pro_code;
    // SQL文を実行
    $stmt->execute($data);

    /*
     * データベースからの切断
     */
    $dbh = null;

    if($pro_image_name !== '') {
        unlink('/product/images/'.$pro_image_name);
    }

    print '削除しました。<br><br>';

} catch(Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    print $e;
    exit();
}
?>

<a href="/product/pro_list.php">戻る</a>
</body>
</html>
