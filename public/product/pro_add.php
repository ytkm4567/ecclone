<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ECClone</title>
</head>
<body>

<?php

session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false) {
    print 'ログインが必要です。<br>';
    print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
    exit();
} else {
    print $_SESSION['staff_name'];
    print 'さんログイン中<br>';
    print '<br>';
}

?>

商品追加<br>
<br>
<form method="post" action="pro_add_check.php" enctype="multipart/form-data">
    商品名を入力してください。<br>
    <input type="text" name="name" style="width:200px"><br>
    価格を入力してください。<br>
    <input type="text" name="price" style="width:50px"><br>
    画像を選択してください。<br>
    <input type="file" name="image" style="width:400px"><br>
    <br>
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
</form>
</body>
</html>
