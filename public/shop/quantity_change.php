<?php

session_start();
session_regenerate_id(true);

require_once('../common.php');

$post = sanitize($_POST);

$max = $post['max'];
for($i=0;$i<$max;$i++) {
    if(preg_match("/\A[0-9]+\z/", $post['quantity'.$i])==0) {
        print '数量に誤りがあります。';
        print '<a href="shop_cartlook.php">カートに戻る</a>';
        exit();
    }
    if($post['quantity'.$i]<1 || 10<$post['quantity'.$i]) {
        print '数量は必ず1個以上、10個までです。';
        print '<a href="shop_cartlook.php">カートに戻る</a>';
        exit();
    }
    $quantity[] = $post['quantity'.$i];
}

$cart = $_SESSION['cart'];

for($i=$max;$i>=0;$i--) {
    if(isset($post['sakujo'.$i])==true) {
        array_splice($cart, $i, 1);
        array_splice($quantity, $i, 1);
    }
}

$_SESSION['cart'] = $cart;
$_SESSION['quantity'] = $quantity;

header('Location:shop_cartlook.php');
exit();