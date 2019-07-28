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

$code = $_SESSION['member_code'];

$dbh = new_pdo();

$sql = 'SELECT name, email, postal1, postal2, address, tel FROM dat_member WHERE code=?';
$stmt = $dbh->prepare($sql);
$data[] = $code;
$stmt->execute($data);
$rec = $stmt->fetch(PDO::FETCH_ASSOC);

$dbh = null;

$onamae = $rec['name'];
$email = $rec['email'];
$postal1 = $rec['postal1'];
$postal2 = $rec['postal2'];
$address = $rec['address'];
$tel = $rec['tel'];

$form_contents = '';

$form_contents .= 'お名前<br>'.$onamae.'<br><br>';
$form_contents .= 'メールアドレス<br>'.$email.'<br><br>';
$form_contents .= '郵便番号<br>'.$postal1.'-'.$postal2.'<br><br>';
$form_contents .= '住所<br>'.$address.'<br><br>';
$form_contents .= '電話番号<br>'.$tel.'<br><br>';

print '<div class="card card-margin">';
print '<h5 class="card-header alert-success">登録情報を確認してください。</h5>';
print '<div class="card-body">';
print $form_contents;
print '</div></div>';

print '<form method="post" action="/shop/shop_kantan_done.php">';
print '<input type="hidden" name="onamae" value="'.$onamae.'">';
print '<input type="hidden" name="email" value="'.$email.'">';
print '<input type="hidden" name="postal1" value="'.$postal1.'">';
print '<input type="hidden" name="postal2" value="'.$postal2.'">';
print '<input type="hidden" name="address" value="'.$address.'">';
print '<input type="hidden" name="tel" value="'.$tel.'">';
generate_csrf_token();

print '<input type="button" class="btn btn-secondary btn-margin" onclick="history.back()" value="戻る">';
print '<input type="submit" class="btn btn-primary btn-to-decide" value="購入を確定"><br>';
print '</form>';

?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
