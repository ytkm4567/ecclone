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

require_once('../common.php');

$post = sanitize($_POST);
$pro_name = $post['name'];
$pro_price = $post['price'];
$pro_image = $_FILES['image'];

// 商品名が空か
if($pro_name === '') {
    print '商品名が入力されていません。<br>';
} else {
    print '商品名：'.$pro_name.'<br>';
}

// 価格が空か
if(preg_match('/\A[0-9]+\z/', $pro_price) === 0) {
    print '価格は半角英数字で入力してください。<br>';
} else {
    print '価格：'.$pro_price.'<br>';
}

// 画像がアップロードされている場合のみ
if($pro_image['size'] > 0) {
    if($pro_image['size'] > 1000000) {
        print 'ファイルサイズが大きすぎます。';
    } else {
        move_uploaded_file($pro_image['tmp_name'], './images/'.$pro_image['name']);
        print '<img src="./images/'.$pro_image['name'].'">';
        print '<br>';
    }
}

// 入力が不正な場合戻るボタンのみ表示する
if($pro_name === '' || preg_match('/\A[0-9]+\z/', $pro_price) === 0 || $pro_image['size'] > 1000000) {
    print '<form>';
    print '<input type="button" onclick="history.back()" value="戻る">';
    print '</form>';
} else {
    print '上記の商品を追加します。';
    print '<form method="post" action="pro_add_done.php">';
    print '<input type="hidden" name="name" value="'.$pro_name.'">';
    print '<input type="hidden" name="price" value="'.$pro_price.'">';
    print '<input type="hidden" name="image_name" value="'.$pro_image['name'].'">';
    print '<br>';
    print '<input type="button" onclick="history.back()" value="戻る">';
    print '<input type="submit" value="OK">';
    print '</form>';
}

?>
</body>
</html>
