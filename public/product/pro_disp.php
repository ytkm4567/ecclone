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

require_once('../mysqlconf.php');

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

    if($pro_image_name === '') {
        $disp_image = '';
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
