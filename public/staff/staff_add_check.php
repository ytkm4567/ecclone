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
$staff_name = $post['name'];
$staff_pass = $post['pass'];
$staff_pass2 = $post['pass2'];

$error_msg = '';
$form_contents = '下記のスタッフを登録します。<br>';

// スタッフ名が空か
if($staff_name === '') {
    $error_msg .= 'スタッフ名が入力されていません。<br>';
} else {
    $form_contents .= 'スタッフ名：'.$staff_name.'<br>';
}

// パスワードが空か
if($staff_pass === '') {
    $error_msg .= 'パスワードが入力されていません。<br>';
}

// パスワード入力が一致するか
if($staff_pass !== $staff_pass2) {
    $error_msg .= 'パスワードが一致しません。<br>';
}

// 入力が不正な場合戻るボタンのみ表示する
if($staff_name === '' || $staff_pass === '' || $staff_pass !== $staff_pass2) {
    print '<div class="card card-margin">';
    print '<h5 class="card-header alert-danger">入力にエラーがあります。</h5>';
    print '<div class="card-body">';
    print $error_msg;
    print '</div></div>';
    print '<form>';
    print '<input type="button" class="btn btn-secondary btn-margin" onclick="history.back()" value="戻る">';
    print '</form>';
} else {
    $staff_pass = password_hash($staff_pass, PASSWORD_DEFAULT);
    print '<form method="post" action="/staff/staff_add_done.php">';
    print '<input type="hidden" name="name" value="'.$staff_name.'">';
    print '<input type="hidden" name="pass" value="'.$staff_pass.'">';
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
