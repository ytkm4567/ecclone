<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ECClone</title>
</head>
<body>

<?php

require_once(dirname ( __FILE__ ).'/../common.php');

session_start();
session_regenerate_id(true);
check_staff_login();
?>

スタッフが選択されていません。<br>
<a href="/staff/staff_list.php">戻る</a>

</body>
</html>