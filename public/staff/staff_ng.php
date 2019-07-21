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

スタッフが選択されていません。<br>
<a href="staff_list.php">戻る</a>

</body>
</html>