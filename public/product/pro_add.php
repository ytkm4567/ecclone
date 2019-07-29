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
?>

<form method="post" action="/product/pro_add_check.php" enctype="multipart/form-data">
<div class="card card-margin">
  <h5 class="card-header alert-success">商品追加</h5>
  <div class="card-body">
    <div class="form-group">
        <label for="name">商品名：</label>
        <input type="text" name="name" class="form-control my-form" placeholder="商品名を入力してください。">
    </div>
    <div class="form-group">
        <label for="price">価格：</label>
        <input type="text" name="price" class="form-control my-form" placeholder="価格を入力してください。">
    </div>
    <div class="form-group">
        <label for="image">商品画像</label>
        <br>
        <input type="file" name="image" class="">
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
