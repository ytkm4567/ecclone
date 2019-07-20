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

?>

ショップ管理トップメニュー<br>
<br>
<a href="../staff/staff_list.php">スタッフ管理</a><br>
<br>
<a href="../product/pro_list.php">商品管理</a><br>
<br>
<a href="staff_logout.php">ログアウト</a><br>
</body>
</html>
