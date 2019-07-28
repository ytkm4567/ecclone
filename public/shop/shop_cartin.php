<?php
require_once(dirname ( __FILE__ ).'/../common.php');
require_once(dirname ( __FILE__ ).'/../mysqlconf.php');

session_start();
session_regenerate_id(true);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ECClone</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="/css/stylesheet.css">
</head>
<body>

<?php

include(dirname ( __FILE__ ).'/../member_navbar.php');

try {
    $pro_code = $_GET['procode'];

    // カートにすでに商品が入っている場合、
    if (isset($_SESSION['cart'])==true) {
        $cart = $_SESSION['cart'];  // すでに入っている商品をcartへ一時退避
        $quantity = $_SESSION['quantity'];
        if(in_array($pro_code,$cart)==true) {
            print '<div class="card card-margin">';
            print '<h5 class="card-header alert-danger">その商品はすでにカートに入っています。</h5>';
            print '<div class="card-body">';
            print '<a href="shop_list.php" class="btn btn-secondary">商品一覧に戻る</a>';
            print '</div></div>';
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

<div class="card card-margin">
  <h5 class="card-header alert-success">カートに商品を追加しました。</h5>
  <div class="card-body">
    <a href="/shop/shop_list.php" class="btn btn-secondary">商品一覧に戻る</a>
    <a href="/shop/shop_cartlook.php" class="btn btn-primary">カートの中身を確認する</a>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
