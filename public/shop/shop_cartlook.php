<?php
require_once('../common.php');
require_once('../mysqlconf.php');

session_start();
session_regenerate_id(true);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ECClone</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">ECClone</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="../index.php">ホーム<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../shop/shop_list.php">商品一覧</a>
      </li>
    </ul>
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <?php member_login_check()?>
      </li>
    </ul>
  </div>
</nav>

<?php
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

    // 商品情報をデータベースから読み出し
    foreach($cart as $key => $val) {
        $sql = 'SELECT code,name,price,image FROM mst_product WHERE code=?';
        $stmt = $dbh->prepare($sql);
        $data[0] = $val;
        $stmt->execute($data);

        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        $pro_name[] = $rec['name'];
        $pro_price[] = $rec['price'];
        if($rec['image']=='') {
            $pro_image[] = '<img src="../product/images/no_image.jpg">';
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

<form method="post" action="quantity_change.php">
  <div class="table-responsive">
    <table class="table table-condensed">
      <thead class="thead-dark">
        <tr>
          <th scope="col">商品</th>
          <th scope="col">商品画像</th>
          <th scope="col">価格</th>
          <th scope="col">数量</th>
          <th scope="col">小計</th>
          <th scope="col">削除</th>
        </tr>
      </thead>
      <tbody>
      <?php for($i=0;$i<$max;$i++) { ?>
        <tr>
          <th scope="col"><?php print $pro_name[$i]; ?></th>
          <td><?php print $pro_image[$i]; ?></td>
          <td><?php print $pro_price[$i]; ?>円</td>
          <td><input type="number" name="quantity<?php print $i; ?>" value="<?php print $quantity[$i]; ?>" style="width: 80px;"></td>
          <td><?php print $pro_price[$i]*$quantity[$i]; ?>円</td>
          <td><input type="checkbox" name="sakujo<?php print $i; ?>"></td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>

  <div class="row" style="position: relative; ">
    <input type="hidden" name="max" value="<?php print $max; ?>">
    <input type="submit" value="数量変更" class="btn btn-warning" style="margin: 20px;">
    <a href="shop_list.php" class="btn btn-secondary" style="margin: 20px;">商品一覧に戻る</a>
    <a href="shop_form.php" class="btn btn-primary" style="margin: 20px; position: absolute; right:0;">ご購入手続きへ進む</a>
  </div>
</form>
<br>

<?php
if(isset($_SESSION["member_login"])==true) {
    print '<a href="shop_kantan_check.php">かんたん注文へ進む</a>';
}
?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
