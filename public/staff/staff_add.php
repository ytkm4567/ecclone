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

スタッフ追加<br>
<br>
<form method="post" action="staff_add_check.php">
    スタッフ名を入力してください。<br>
    <input type="text" name="name" style="width:200px"><br>
    パスワードを入力してください。<br>
    <input type="password" name="pass" style="width:100px"><br>
    パスワードをもう一度入力してください。<br>
    <input type="password" name="pass2" style="width:100px"><br>
    <br>
    <?php generate_csrf_token(); ?>
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
</form>
</body>
</html>
