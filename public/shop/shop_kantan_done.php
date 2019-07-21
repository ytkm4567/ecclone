<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login'])==false) {
    print 'ログインされていません。<br>';
    print '<a href="shop_list.php">商品一覧へ</a>';
    exit();
}
?>
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

try {
    $post = sanitize($_POST);

    $onamae = $post['onamae'];
    $email = $post['email'];
    $postal1 = $post['postal1'];
    $postal2 = $post['postal2'];
    $address = $post['address'];
    $tel = $post['tel'];

    print $onamae.'様<br>';
    print 'ご注文ありがとうございました。<br>';
    print $email.'にメールを送りましたのでご確認ください。<br>';
    print '商品は以下の住所に発送させていただきます。<br>';
    print $postal1.'-'.$postal2.'<br>';
    print $address.'<br>';
    print $tel.'<br>';

    // 自動返信メールの文章
    $honbun='';
    $honbun.=$onamae."様 \n\nこの度はご注文ありがとうございました。\n";
    $honbun.="\n";
    $honbun.="ご注文商品\n";
    $honbun.="-----------------------------------\n";

    $cart=$_SESSION['cart'];
    $quantity=$_SESSION['quantity'];
    $max=count($cart);

    $dbh = new_pdo();

    for($i=0;$i<$max;$i++) {
        $sql = 'SELECT name,price FROM mst_product WHERE code=?';
        $stmt = $dbh->prepare($sql);
        $data[0] = $cart[$i];
        $stmt->execute($data);

        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        $name = $rec['name'];
        $price = $rec['price'];
        $kakaku[] = $price;
        $suryo = $quantity[$i];
        $shokei = $price * $suryo;

        $honbun.=$name.'';
        $honbun.=$price.'円 x';
        $honbun.=$suryo.'個 =';
        $honbun.=$shokei."円 \n";
    }

    // テーブルロック
    $sql = 'LOCK TABLES dat_sales WRITE, dat_sales_product WRITE, dat_member WRITE';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $lastmembercode = $_SESSION['member_code'];

    // 注文レコードの登録
    $sql = 'INSERT INTO dat_sales(code_member, name, email, postal1, postal2, address, tel) VALUES(?,?,?,?,?,?,?)';
    $stmt = $dbh->prepare($sql);
    $data=array();
    $data[]=$lastmembercode;
    $data[]=$onamae;
    $data[]=$email;
    $data[]=$postal1;
    $data[]=$postal2;
    $data[]=$address;
    $data[]=$tel;
    $stmt->execute($data);

    // 直近に発番された番号を取得
    $sql = 'SELECT LAST_INSERT_ID()';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $lastcode = $rec['LAST_INSERT_ID()'];

    // 注文明細の登録
    for($i=0;$i<$max;$i++) {
        $sql = 'INSERT INTO dat_sales_product(code_sales, code_product, price, quantity) VALUES (?,?,?,?)';
        $stmt = $dbh->prepare($sql);
        $data=array();
        $data[]=$lastcode;
        $data[]=$cart[$i];
        $data[]=$kakaku[$i];
        $data[]=$quantity[$i];
        $stmt->execute($data);
    }

    // テーブルロックの解除
    $sql = 'UNLOCK TABLES';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $dbh = null;


    $honbun.="送料は無料です。\n";
    $honbun.="-----------------------------------\n";
    $honbun.="\n";
    $honbun.="代金は以下の口座にお振り込みください。\n";
    $honbun.="ろくまる銀行 やさい支店 普通口座 1234567\n";
    $honbun.="入金確認が取れ次第、梱包、発送させていただきます。\n";
    $honbun.="\n";

    $honbun.="□□□□□□□□□□□□□□□□□□□\n";
    $honbun.="〜安心野菜のろくまる農園〜\n";
    $honbun.="\n";
    $honbun.="北海道河東郡上士幌町123-4\n";
    $honbun.="電話 01564-2-1234\n";
    $honbun.="メール info@rokumarunouen.co.jp\n";
    $honbun.="□□□□□□□□□□□□□□□□□□□\n";

    //print '<br>';
    //print nl2br($honbun);

    // お客様向けメール
    $title = 'ご注文ありがとうございます。';
    $header = 'From:info@rokumarunouen.co.jp';
    $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
    mb_language('Japanese');
    mb_internal_encoding('UTF-8');
    mb_send_mail($email, $title, $honbun, $header);

    // お店宛てメール
    $title = 'お客様からご注文がありました。';
    $header = 'From:'.$email;
    $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
    mb_language('Japanese');
    mb_internal_encoding('UTF-8');
    mb_send_mail('ytkm555@gmail.com', $title, $honbun, $header);
} catch(Exception $e) {
    print $e.'<br>';
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

<br>
<a href="shop_list.php">商品画面へ</a>
</body>
</html>
