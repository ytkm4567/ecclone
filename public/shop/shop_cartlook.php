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
    if(isset($_SESSION['cart'])==true) {
        $cart = $_SESSION['cart'];
        $quantity = $_SESSION['quantity'];
        $max = count($cart);
    } else {
        $max = 0;
    }
    
    if($max===0) {
        print 'カートに商品が入っていません。<br>';
        print '<br>';
        print '<a href="shop_list.php">商品一覧へ戻る</a>';
        exit();
    }

    $dbh = new_pdo();

    foreach($cart as $key => $val) {
        $sql = 'SELECT code,name,price,image FROM mst_product WHERE code=?';
        $stmt = $dbh->prepare($sql);
        $data[0] = $val;
        $stmt->execute($data);

        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        $pro_name[] = $rec['name'];
        $pro_price[] = $rec['price'];
        if($rec['image']=='') {
            $pro_image[] = '';
        } else {
            $pro_image[] = '<img src="../product/images/'.$rec['image'].'">';
        }
    }

    $dbh = null;
    
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

カートの中身<br>
<br>
<form method="post" action="quantity_change.php">
<table border="1">
        <tr>
            <td>商品</td>
            <td>商品画像</td>
            <td>価格</td>
            <td>数量</td>
            <td>小計</td>
            <td>削除</td>
        </tr>
        <?php for($i=0;$i<$max;$i++) { ?>
        <tr>
            <td><?php print $pro_name[$i]; ?></td>
            <td><?php print $pro_image[$i]; ?></td>
            <td><?php print $pro_price[$i]; ?>円</td>
            <td><input type="text" name="quantity<?php print $i; ?>" value="<?php print $quantity[$i]; ?>"></td>
            <td><?php print $pro_price[$i]*$quantity[$i]; ?>円</td>
            <td><input type="checkbox" name="sakujo<?php print $i; ?>"></td>
        </tr>
        <?php } ?>
        </table>

    <input type="hidden" name="max" value="<?php print $max; ?>">
    <input type="submit" value="数量変更"><br>
    <input type="button" onclick="history.back()" value="戻る">
</form>
<br>
<a href="shop_form.html">ご購入手続きへ進む</a><br>
</body>
</html>
