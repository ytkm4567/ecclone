<?php
session_start();
session_regenerate_id(true);

if(isset($_SESSION['login'])==true) {
  header('Location:/staff_login/staff_top.php');
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ECClone</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="/css/stylesheet.css">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<div class="card page-title-margin">
  <div class="card-header">スタッフログイン</div>
</div>

<form method="post" action="/staff_login/staff_login_check.php">
  <div class="card card-margin card-bottom-padding">
    <div class="form-group">
      <label for="code">スタッフコード：</label>
      <input type="text" name="code" class="form-control my-form" placeholder="コードを入力してください。">
    </div>
    <div class="form-group">
      <label for="pass">パスワード：</label>
      <input type="password" name="pass" class="form-control my-form" placeholder="パスワードを入力してください。">
    </div>
    <div class="btn-set-center">
      <input type="submit" class="btn btn-primary btn-to-login" value="ログイン">
    </div>
  </div>
</form>

<a href="/index.php" class="btn btn-secondary btn-margin">ホーム画面へ</a> 

</body>
</html>
