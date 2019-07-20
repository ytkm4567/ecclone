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

require_once('../mysqlconf.php');

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
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
</form>
</body>
</html>
