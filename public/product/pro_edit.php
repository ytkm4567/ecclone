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
check_staff_login();

include(dirname ( __FILE__ ).'/../staff_navbar.php');

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
    $pro_image_name_old = $rec['image'];

    $dbh = null;

    if($pro_image_name_old == '') {
        $disp_image = '<img src="/product/images/no_image.jpg">';
    } else {
        $disp_image = '<img src="/product/images/'.$pro_image_name_old.'">';
    }
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

<form method="post" action="/product/pro_edit_check.php" enctype="multipart/form-data">
<div class="card card-margin">
  <h5 class="card-header alert-success">商品情報修正</h5>
  <div class="card-body">
    下記の商品を修正します。<br>
    商品コード：<?php print $pro_code; ?><br>
    <input type="hidden" name="code" value="<?php print $pro_code; ?>">
    <input type="hidden" name="image_name_old" value="<?php print $pro_image_name_old; ?>">
    <br>
    <div class="form-group">
        <label for="name">商品名：</label>
        <input type="text" name="name" class="form-control my-form" placeholder="商品名を入力してください。" value="<?php print $pro_name;?>">
    </div>
    <div class="form-group">
        <label for="price">価格：</label>
        <input type="text" name="price" class="form-control my-form" placeholder="パスワードを入力してください。" value="<?php print $pro_price;?>">
    </div>
    <?php print $disp_image; ?>
    <div class="form-group">
        <label for="image">商品画像：</label>
        <input type="file" name="image">
    </div>
    <?php generate_csrf_token(); ?>
    <a href="/product/pro_list.php" class="btn btn-secondary btn-margin">戻る</a>
    <input type="submit" class="btn btn-primary btn-to-decide" value="入力内容の確認">
</form>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
