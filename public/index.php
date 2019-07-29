<?php
require_once(dirname ( __FILE__ ).'/common.php');

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
<?php include(dirname ( __FILE__ ).'/member_navbar.php'); ?>

<div class="jumbotron top-wrapper">
  <h1 class="display-4">新鮮な野菜をいますぐに..</h1>
  <p class="lead">このサイトは野菜のネット販売を想定した、ECサイトです。</p>
  <hr class="my-4">
  <p>いますぐ下のボタンを押して新鮮な野菜の数々を見てみましょう。</p>
  <p>きっとあなたの食卓を美麗に彩る野菜に出会えるはずです。</p>
  <a href="/shop/shop_list.php" class="btn btn-primary btn-lg">商品一覧へ</a>
  <a href="/member/member_login.php" class="btn btn-warning btn-lg btn-margin">会員ログイン</a><br>
</div>

<a href="/staff_login/staff_login.php">管理者ログイン</a>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
