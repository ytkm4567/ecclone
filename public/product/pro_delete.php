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

try {
    $pro_code = $_GET['procode'];

    $dbh = new_pdo();

    $sql = 'SELECT name,price,image FROM mst_product WHERE code=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $pro_code;
    $stmt->execute($data);

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $pro_name = $rec['name'];
    $pro_price = $rec['price'];
    $pro_image_name = $rec['image'];

    $dbh = null;

    if($pro_image_name == '') {
        $disp_image = '';
    } else {
        $disp_image = '<img src="./images/'.$pro_image_name.'">';
    }
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

商品削除<br />
<br>
商品コード<br>
<?php print $pro_code; ?>
<br>
<br>
商品名<br>
<?php print $pro_name;?><br>
価格<br>
<?php print $pro_price;?><br>
<?php print $disp_image;?><br>
この商品を削除してよろしいですか？<br>
<br>
<form method="post" action="pro_delete_done.php">
    <input type="hidden" name="code" value="<?php print $pro_code; ?>">
    <input type="hidden" name="image_name" value="<?php print $pro_image_name; ?>">
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
</form>
</body>
</html>
