<?php
require_once('../common.php');
require_once('../mysqlconf.php');

session_start();
session_regenerate_id(true);

member_login_check();
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

    // カートにすでに商品が入っている場合、
    if (isset($_SESSION['cart'])==true) {
        $cart = $_SESSION['cart'];  // すでに入っている商品をcartへ一時退避
        $quantity = $_SESSION['quantity'];
        if(in_array($pro_code,$cart)==true) {
            print 'その商品はですでにカートに入っています。<br>';
            print '<a href="shop_list.php">商品一覧に戻る</a>';
            exit();
        }
    }
    $cart[] = $pro_code;
    $quantity[] = 1;
    $_SESSION['cart'] = $cart;
    $_SESSION['quantity'] = $quantity;


} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

カートに追加しました。<br>
<br>
<a href="shop_list.php">商品一覧に戻る</a>

</body>
</html>
