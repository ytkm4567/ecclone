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

<?php include(dirname ( __FILE__ ).'/../member_navbar.php'); ?>

<div class="card page-title-margin">
  <div class="card-header">商品一覧</div>
</div>

<div class="container">
  <div class="row">
<?php
try {
    $dbh = new_pdo();

    $sql = 'SELECT code,name,price,image FROM mst_product WHERE 1';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $dbh = null;

    while(true) {
        // SQL statementの結果から配列を生成して格納
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if($rec==false) {
            break;
        }
        print '<div class="col-sm-4">';
        print '<div class="card product-card">';
        if($rec['image'] == '') {
            print '<img src="/product/images/no_image.jpg" class="card-img-top" alt="'.$rec['name'].'">';
        } else {
            print '<img src="/product/images/'.$rec['image'].'" class="card-img-top" alt="'.$rec['name'].'">';
        }
        print '<div class="card-body">';
        print '<h5 class="card-title">'.$rec['name'].'</h5>';
        print '<p class="card-text">'.$rec['price'].'円</p>';
        print '<a href="/shop/shop_product.php?procode='.$rec['code'].'" class="btn btn-primary">商品詳細</a>';
        print '</div></div></div>';
    }

} catch(Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
?>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
