<?php
require_once(dirname ( __FILE__ ).'/../common.php');

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
check_csrf_token();
check_staff_login();

include(dirname ( __FILE__ ).'/../staff_navbar.php');

$post = sanitize($_POST);

$pro_code = $post['code'];
$pro_name = $post['name'];
$pro_price = $post['price'];
$pro_image_name_old = $post['image_name_old'];
$pro_image = $_FILES['image'];

$error_msg = '';
$form_contents = '下記の通りに修正します。<br>';

// 商品名が空か
if($pro_name === '') {
    $error_msg .= '商品名が入力されていません。<br>';
} else {
    $form_contents .= '商品名：'.$pro_name.'<br>';
}

// 価格が空か
if(preg_match('/\A[0-9]+\z/', $pro_price) === 0) {
    $error_msg .= '価格は半角英数字で入力してください。<br>';
} else {
    $form_contents .= '価格：'.$pro_price.'<br>';
}

// 画像がアップロードされている場合のみ
if($pro_image['size'] > 0) {
    if($pro_image['size'] > 1000000) {
        $error_msg .= 'ファイルサイズが大きすぎます。';
    } else {
        move_uploaded_file($pro_image['tmp_name'], dirname ( __FILE__ ).'/images/'.$pro_image['name']);
        $form_contents .= '<img src="/product/images/'.$pro_image['name'].'"><br>';
    }
}

// 入力が不正な場合戻るボタンのみ表示する
if($pro_name === '' || preg_match('/\A[0-9]+\z/', $pro_price) === 0 || $pro_image['size'] > 1000000) {
    print '<div class="card card-margin">';
    print '<h5 class="card-header alert-danger">入力にエラーがあります。</h5>';
    print '<div class="card-body">';
    print $error_msg;
    print '</div></div>';
    print '<form>';
    print '<input type="button" class="btn btn-secondary btn-margin" onclick="history.back()" value="戻る">';
    print '</form>';
} else {
    print '<form method="post" action="/product/pro_edit_done.php">';
    print '<input type="hidden" name="code" value="'.$pro_code.'">';
    print '<input type="hidden" name="name" value="'.$pro_name.'">';
    print '<input type="hidden" name="price" value="'.$pro_price.'">';
    print '<input type="hidden" name="image_name_old" value="'.$pro_image_name_old.'">';
    print '<input type="hidden" name="image_name" value="'.$pro_image['name'].'">';
    generate_csrf_token();
    print '<div class="card card-margin">';
    print '<h5 class="card-header alert-success">入力内容を確認してください。</h5>';
    print '<div class="card-body">';
    print $form_contents;
    print '</div></div>';
    print '<input type="button" class="btn btn-secondary btn-margin" onclick="history.back()" value="戻る">';
    print '<input type="submit" class="btn btn-primary btn-to-decide" value="OK">';
    print '</form>';
}

?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
