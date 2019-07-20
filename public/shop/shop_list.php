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
if(isset($_SESSION['member_login'])==false) {
    print 'ようこそ、ゲスト様　';
    print '<a href="../member/member_login.html">ログイン画面へ</a><br>';
    print '<br>';
} else {
    print 'ようこそ'.$_SESSION['member_name'].'様';
    print '<a href="../member/member_logout.html">ログアウト</a><br>';
    print '<br>';
}

require_once('../mysqlconf.php');

try {
    $dbh = new_pdo();

    $sql = 'SELECT code,name,price FROM mst_product WHERE 1';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $dbh = null;

    print '商品一覧<br><br>';

    while(true) {
        // SQL statementの結果から配列を生成して格納
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if($rec==false) {
            break;
        }
        print '<a href="shop_product.php?procode='.$rec['code'].'">';
        print $rec['name'];
        print '---'.$rec['price'].'円';
        print '</a>';
        print '<br>';
    }

} catch(Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

print '<br>';
print '<a href="shop_cartlook.php">カートを見る</a><br>';
?>

</body>
</html>
