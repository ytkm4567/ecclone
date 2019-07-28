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

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ろくまる農園</title>
</head>
<body>

ダウンロードしたい注文日を選んでください。<br>
<form method="post" action="order_download_done.php">
    <?php pulldown_year(); ?>
    年
    <?php pulldown_month(); ?>
    月
    <?php pulldown_day(); ?>    
    日<br>
    <br>
    <input type="submit" value="ダウンロードへ">
</form>
</body>
</html>
</body>
</html>
