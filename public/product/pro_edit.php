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
    $pro_image_name_old = $rec['image'];

    $dbh = null;

    if($pro_image_name_old == '') {
        $disp_image = '<img src="../product/images/no_image.jpg">';
    } else {
        $disp_image = '<img src="./images/'.$pro_image_name_old.'">';
    }
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

商品情報修正<br>
<br>
商品コード<br>
<?php print $pro_code; ?>
<br>
<br>
<form method="post" action="pro_edit_check.php" enctype="multipart/form-data">
    <input type="hidden" name="code" value="<?php print $pro_code; ?>">
    <input type="hidden" name="image_name_old" value="<?php print $pro_image_name_old; ?>">
    商品名<br>
    <input type="text" name="name" style="width:200px" value="<?php print $pro_name;?>"> <br>
    価格<br>
    <input type="text" name="price" style="width:50px" value="<?php print $pro_price;?>"><br>
    <br>
    <?php print $disp_image; ?>
    <br>
    画像を選択してください。<br>
    <input type="file" name="image" style="width:400px"><br>
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
</form>
</body>
</html>
