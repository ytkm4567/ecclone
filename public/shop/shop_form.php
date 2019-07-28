<?php
require_once(dirname ( __FILE__ ).'/../common.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ECClone</title>
<style>
  .my-form {
    margin : 0px 10px;
  }
</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<?php include(dirname ( __FILE__ ).'/../member_navbar.php'); ?>

<div class="card" style="margin: 10px 0px;">
  <div class="card-header">お客様情報を入力してください。</div>
</div>

<form method="post" action="/shop/shop_form_check.php">
  <div class="card" style="margin: 15px;">
    <div class="form-group">
      <label for="onamae">お名前：</label>
      <input type="text" name="onamae" class="form-control my-form" placeholder="お名前を入力してください。" style="width:280px">
    </div>
    <div class="form-group">
      <label for="email">メールアドレス：</label>
      <input type="text" name="email" class="form-control my-form" placeholder="メールアドレスを入力してください。" style="width:350px">
    </div>
    <div class="form-group">
      <label for="postal">郵便番号：</label>
      <input type="text" name="postal1" class="form-control my-form" placeholder="郵便番号3桁を入力してください。" style="width:100px">
      <input type="text" name="postal2" class="form-control my-form" placeholder="郵便番号4桁を入力してください。" style="width:130px">
    </div>
    <div class="form-group">
      <label for="address">住所：</label>
      <input type="text" name="address" class="form-control my-form" placeholder="住所を入力してください。" style="width: 95%;">
    </div>
    <div class="form-group">
      <label for="tel">電話番号：</label>
      <input type="text" name="tel" class="form-control my-form" placeholder="電話番号を入力してください。" style="width:150px">
    </div>
    <div class="form-check">
      <input type="radio" name="chumon" class="form-check-input" value="chumonkonkai" checked>
      <label class="form-check-label" for="chumon">今回だけの注文</label>
    </div>
    <div class="form-check">
      <input type="radio" name="chumon" class="form-check-input" value="chumontouroku">
      <label class="form-check-label" for="chumon">会員登録しての注文</label>
    </div>
    <br>
    ※会員登録する方は以下の項目も入力してください。<br>
    <div class="form-group">
      <label for="pass">登録するパスワードを入力してください。：</label>
      <input type="password" name="pass" class="form-control my-form" placeholder="パスワードを入力してください。" style="width:200px">
    </div>
    <div class="form-group">
      <label for="pass2">登録するパスワードをもう一度入力してください。：</label>
      <input type="password" name="pass2" class="form-control my-form" placeholder="パスワードをもう一度入力してください。" style="width:200px">
    </div>
    性別：<br>
    <div class="form-check">
      <input type="radio" name="gender" class="form-check-input" value="male" checked>
      <label class="form-check-label" for="gender">男性</label>
    </div>
    <div class="form-check">
      <input type="radio" name="gender" class="form-check-input" value="female">
      <label class="form-check-label" for="gender">女性</label>
    </div>
    <div class="form-group">
    <label for="birth">生まれ年:</label>
      <select name="birth" class="form-control my-form" style="width: 30%;">
          <option value="1910">1910年代</option>
          <option value="1920">1920年代</option>
          <option value="1930">1930年代</option>
          <option value="1940">1940年代</option>
          <option value="1950">1950年代</option>
          <option value="1960">1960年代</option>
          <option value="1970">1970年代</option>
          <option value="1980" selected>1980年代</option>
          <option value="1990">1990年代</option>
          <option value="2000">2000年代</option>
          <option value="2010">2010年代</option>
      </select>
    </div>
    <br>
    <br>
    <?php generate_csrf_token(); ?>
  </div>
  <a href="/shop/shop_cartlook.php" class="btn btn-secondary" style="margin: 0px 0px 0px 15px;">カートの中身確認へ戻る</a>
  <input type="submit" class="btn btn-primary" value="入力内容の確認" style="padding: 6px 50px; margin: 0px 15px 0px 0px; float: right;">
</form>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
