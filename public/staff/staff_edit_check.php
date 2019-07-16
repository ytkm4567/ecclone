<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ECClone</title>
</head>
<body>

<?php

require_once('../common.php');

$post = sanitize($_POST);
$staff_code = $post['code'];
$staff_name = $post['name'];
$staff_pass = $post['pass'];
$staff_pass2 = $post['pass2'];

// スタッフ名が空か
if($staff_name === '') {
    print 'スタッフ名が入力されていません。<br>';
} else {
    print 'スタッフ名：'.$staff_name.'<br>';
}

// パスワードが空か
if($staff_pass === '') {
    print 'パスワードが入力されていません。<br>';
}

// パスワード入力が一致するか
if($staff_pass !== $staff_pass2) {
    print 'パスワードが一致しません。<br>';
}

// 入力が不正な場合戻るボタンのみ表示する
if($staff_name === '' || $staff_pass === '' || $staff_pass !== $staff_pass2) {
    print '<form>';
    print '<input type="button" onclick="history.back()" value="戻る">';
    print '</form>';
} else {
    $staff_pass = password_hash($staff_pass, PASSWORD_DEFAULT);
    print '<form method="post" action="staff_edit_done.php">';
    print '<input type="hidden" name="code" value="'.$staff_code.'">';
    print '<input type="hidden" name="name" value="'.$staff_name.'">';
    print '<input type="hidden" name="pass" value="'.$staff_pass.'">';
    print '<br />';
    print '<input type="button" onclick="history.back()" value="戻る">';
    print '<input type="submit" value="OK">';
    print '</form>';
}

?>
</body>
</html>