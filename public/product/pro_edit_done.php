<?php
require_once('../common.php');
require_once('../mysqlconf.php');

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
    $pro_name = $post['name'];
    $pro_price = $post['price'];
    $pro_image_name_old = $post['image_name_old'];
    $pro_image_name = $post['image_name'];

    // 入力が不正な場合戻るボタンのみ表示する
    if($pro_name === '' || preg_match('/\A[0-9]+\z/', $pro_price) === 0 || $pro_image['size'] > 1000000) {
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
    $sql = 'UPDATE mst_product SET name=?, price=?, image=? WHERE code=?';
    // PDOStatmentオブジェクトを生成
    $stmt = $dbh->prepare($sql);
    $data[] = $pro_name;
    $data[] = $pro_price;
    $data[] = $pro_image_name;
    $data[] = $pro_code;
    // SQL文を実行
    $stmt->execute($data);

    /*
     * データベースからの切断
     */
    $dbh = null;

    if($pro_image_name_old !== $pro_image_name) {
        if($pro_image_name_old !== '') {
            unlink('./images/'.$pro_image_name_old);
        }
    }

    print 'コード番号'.$pro_code.'の'.$pro_name.'を編集しました。<br>';
} catch(Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    print $e;
    exit();
}
?>

<a href="pro_list.php">戻る</a>
</body>
</html>
