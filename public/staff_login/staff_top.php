<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ECClone</title>
</head>
<body>

<?php

require_once('../common.php');

session_start();
session_regenerate_id(true);
staff_login_check();

?>

ショップ管理トップメニュー<br>
<br>
<a href="../staff/staff_list.php">スタッフ管理</a><br>
<br>
<a href="../product/pro_list.php">商品管理</a><br>
<br>
<a href="../order/order_download.php">注文ダウンロード</a>
<br>
<a href="staff_logout.php">ログアウト</a><br>
</body>
</html>
