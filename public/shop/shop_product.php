<?php
require_once(dirname ( __FILE__ ).'/../common.php');
require_once(dirname ( __FILE__ ).'/../mysqlconf.php');

session_start();
session_regenerate_id(true);
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

<?php

include(dirname ( __FILE__ ).'/../member_navbar.php');

try {
    $pro_code = $_GET['procode'];

    $dbh = new_pdo();

    $sql = 'SELECT name,price,image FROM mst_product WHERE code=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $pro_code;
    $stmt->execute($data);

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $pro_name = $rec['name'];
    $pro_price = $rec['price'];
    $pro_image_name = $rec['image'];

    $dbh = null;

    if($pro_image_name == '') {
        $disp_image = '/product/images/no_image.jpg';
    } else {
        $disp_image = '/product/images/'.$pro_image_name;
    }
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

<div class="card card-margin">
  <div class="row no-gutters">
    <div class="col-md-4">
    <img src="<?php print $disp_image; ?>" class="card-img-top" alt="<?php print $pro_name; ?>">
    </div>
    <div class="col-md-6">
      <div class="card-body">
        <h5 class="card-title"><?php print $pro_name; ?></h5>
        <p class="card-text">価格 : <?php print $pro_price; ?>円</p>
        <p class="card-text"><small class="text-muted">商品コード : <?php print $pro_code; ?></small></p>
      </div>
    </div>
    <div class="col-md-2 posi-rela">
      <div class="card-body">
        <a class="btn btn-primary btn-lg btn-to-cart" href="/shop/shop_cartin.php?procode=<?php print $pro_code; ?>" role="button">カートに入れる</a>
      </div>
    </div>
  </div>
</div>

<form>
    <input type="button" class="btn btn-secondary btn-margin" onclick="history.back()" value="戻る">
</form>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
