<?php
require_once('../common.php');
require_once('../mysqlconf.php');

session_start();
session_regenerate_id(true);
staff_login_check();
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
        $disp_image = '<img src="../product/images/no_image.jpg">';
    } else {
        $disp_image = '<img src="./images/'.$pro_image_name.'">';
    }
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

商品修正<br>
<br>
商品コード<br>
<?php print $pro_code; ?>
<br>
<br>
商品名<br>
<?php print $pro_name; ?>
<br>
<br>
価格<br>
<?php print $pro_price; ?>
<br>
<br>
<?php print $disp_image; ?>
<br>
<form>
    <input type="button" onclick="history.back()" value="戻る">
</form>
</body>
</html>
