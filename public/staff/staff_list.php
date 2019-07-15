<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ECClone</title>
</head>
<body>

<?php

require_once('../mysqlconf.php');

try {
    $dbh = new_pdo();

    $sql = 'SELECT code,name FROM mst_staff WHERE 1';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $dbh = null;

    print 'スタッフ一覧<br><br>';

    print '<form method="post" action="staff_branch.php">';
    while(true) {
        // SQL statementの結果から配列を生成して格納
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if($rec==false) {
            break;
        }
        print '<input type="radio" name="staffcode" value="'.$rec['code'].'">';
        print $rec['name'];
        print '<br>';
    }
    print '<input type="submit" name="disp" value="参照">';
    print '<input type="submit" name="add" value="追加">';
    print '<input type="submit" name="edit" value="修正">';
    print '<input type="submit" name="delete" value="削除">';
    print '</form>';
} catch(Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
?>

<br>
<a href="../staff_login/staff_top.php">トップメニューへ</a><br>
</body>
</html>
