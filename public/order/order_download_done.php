<?php
require_once(dirname ( __FILE__ ).'/../common.php');
require_once(dirname ( __FILE__ ).'/../mysqlconf.php');

session_start();
session_regenerate_id(true);
check_staff_login();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ECClone</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="/css/stylesheet.css">
</head>
<body>

<?php include(dirname ( __FILE__ ).'/../staff_navbar.php'); ?>

<?php

try {
    $year = $_POST['year'];
    $month = $_POST['month'];
    $day = $_POST['day'];

    $dbh = new_pdo();

    $sql = '
    SELECT
        dat_sales.code,
        dat_sales.date,
        dat_sales.code_member,
        dat_sales.name AS dat_sales_name,
        dat_sales.email,
        dat_sales.postal1,
        dat_sales.postal2,
        dat_sales.address,
        dat_sales.tel,
        dat_sales_product.code_product,
        mst_product.name AS mst_product_name,
        dat_sales_product.price,
        dat_sales_product.quantity
    FROM
        dat_sales, dat_sales_product, mst_product
    WHERE
        dat_sales.code=dat_sales_product.code_sales
        AND dat_sales_product.code_product=mst_product.code
        AND substr(dat_sales.date,1,4)=?
        AND substr(dat_sales.date,6,2)=?
        AND substr(dat_sales.date,9,2)=?
    ';
    $stmt = $dbh->prepare($sql);
    $data[]=$year;
    $data[]=$month;
    $data[]=$day;
    $stmt->execute($data);

    $dbh = null;

    $csv = '注文コード,注文日時,会員番号,お名前,メール,郵便番号,住所,TEL,商品コード,商品名,価格,数量';
    $csv.="\n";
    while(true) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if($rec==false) {
            break;
        }
        $csv.=$rec['code'];
        $csv.=',';
        $csv.=$rec['date'];
        $csv.=',';
        $csv.=$rec['code_member'];
        $csv.=',';
        $csv.=$rec['dat_sales_name'];
        $csv.=',';
        $csv.=$rec['email'];
        $csv.=',';
        $csv.=$rec['postal1'].'-'.$rec['postal2'];
        $csv.=',';
        $csv.=$rec['address'];
        $csv.=',';
        $csv.=$rec['tel'];
        $csv.=',';
        $csv.=$rec['code_product'];
        $csv.=',';
        $csv.=$rec['mst_product_name'];
        $csv.=',';
        $csv.=$rec['price'];
        $csv.=',';
        $csv.=$rec['quantity'];
        $csv.="\n";
    }

    $filename = './'.$year.'_'.$month.'_'.$day.'_'.bin2hex(openssl_random_pseudo_bytes(8)).'.csv';

    $file = fopen($filename,'w');
    $csv = mb_convert_encoding($csv, 'SJIS', 'UTF-8');
    fputs($file, $csv);
    fclose($file);

} catch(Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
?>

<div class="card card-margin">
  <h5 class="card-header alert-success">注文データダウンロード</h5>
  <div class="card-body">
    下のボタンからダウンロードしてください。<br>
    <a href="<?php print $filename; ?>" class="btn btn-primary btn-margin">注文データのダウンロード</a>
    <a href="/order/order_download.php" class="btn btn-success btn-margin">日付選択へ</a>
    </form>
   </div>
</div>

<a href="/staff_login/staff_top.php" class="btn btn-secondary btn-margin">ショップ管理トップへ</a>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>