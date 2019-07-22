<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ECClone</title>
</head>
<body>

<?php

require_once('../common.php');
require_once('../mysqlconf.php');

session_start();
session_regenerate_id(true);
check_staff_login();

try {
    $staff_code = $_GET['staffcode'];

    $dbh = new_pdo();

    $sql = 'SELECT name FROM mst_staff WHERE code=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $staff_code;
    $stmt->execute($data);

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $staff_name = $rec['name'];

    $dbh = null;
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

スタッフ削除<br />
<br>
スタッフコード<br>
<?php print $staff_code; ?>
<br>
<br>
スタッフ名<br>
<?php print $staff_name;?><br>
このスタッフを削除してよろしいですか？<br>
<br>
<form method="post" action="staff_delete_done.php">
    <input type="hidden" name="code" value="<?php print $staff_code; ?>">
    <?php generate_csrf_token(); ?>
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
</form>
</body>
</html>
