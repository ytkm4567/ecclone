<?php
require_once(dirname ( __FILE__ ).'/../common.php');

session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ECClone</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<?php

include(dirname ( __FILE__ ).'/../member_navbar.php');

$post = sanitize($_POST);

check_csrf_token();

$onamae = $post['onamae'];
$email = $post['email'];
$postal1 = $post['postal1'];
$postal2 = $post['postal2'];
$address = $post['address'];
$tel = $post['tel'];
$chumon = $post['chumon'];
$pass = $post['pass'];
$pass2 = $post['pass2'];
$gender = $post['gender'];
$birth = $post['birth'];

$okflg = true;
$form_contents ='';
$error_msg = '';

if($onamae=='') {
    $error_msg .= 'お名前が入力されていません。<br><br>';
    $okflg = false;
} else {
    $form_contents .= 'お名前 <br>'.$onamae.'<br><br>';
}

if(preg_match('/\A[\w\-\.]+\@[\w\-\.]+\.([a-z]+)\z/',$email)==0) {
    $error_msg .= 'メールアドレスを正確に入力してください。<br><br>';
    $okflg = false;
} else {
    $form_contents .= 'メールアドレス <br>'.$email.'<br><br>';
}

if($postal1=='' || $postal2=='' || preg_match('/\A[0-9]{3}+\z/', $postal1)==0 || preg_match('/\A[0-9]{4}+\z/', $postal2)==0) {
    $error_msg .= '郵便番号は半角数字で入力してください。<br><br>';
    $okflg = false;
} else {
    $form_contents .= '郵便番号 <br>'.$postal1.'-'.$postal2.'<br><br>';
}

if($address==''){
    $error_msg .= '住所が入力されていません。<br><br>';
    $okflg = false;
} else {
    $form_contents .= '住所 <br>'.$address.'<br><br>';
}

if(preg_match('/\A\d{2,5}-?\d{2,5}-?\d{4,5}\z/', $tel)==0){
    $error_msg .= '電話番号を正確に入力してください。<br><br>';
    $okflg = false;
} else {
    $form_contents .= '電話番号 <br>'.$tel.'<br><br>';
}

if($chumon=='chumontouroku') {
    if($pass=='') {
        $error_msg .= 'パスワードが入力されていません。<br><br>';
        $okflg = false;
    }

    if($pass!=$pass2) {
        $error_msg .= 'パスワードが一致しません。<br><br>';
        $okflg = false;
    }

    $form_contents .= '性別<br>';
    if($gender=='male') {
        $form_contents .= '男性'.'<br><br>';
    } else {
        $form_contents .= '女性'.'<br><br>';
    }

    $form_contents .= '生まれ年<br>'.$birth.'年代'.'<br><br>';
}

if($okflg == true) {
    print '<div class="card" style="margin: 15px;">';
    print '<h5 class="card-header alert-success">入力内容を確認してください。</h5>';
    print '<div class="card-body">';
    print $form_contents;
    print '</div></div>';

    print '<form method="post" action="/shop/shop_form_done.php">';
    generate_csrf_token();
    print '<input type="hidden" name="onamae" value="'.$onamae.'">';
    print '<input type="hidden" name="email" value="'.$email.'">';
    print '<input type="hidden" name="postal1" value="'.$postal1.'">';
    print '<input type="hidden" name="postal2" value="'.$postal2.'">';
    print '<input type="hidden" name="address" value="'.$address.'">';
    print '<input type="hidden" name="tel" value="'.$tel.'">';
    print '<input type="hidden" name="chumon" value="'.$chumon.'">';
    print '<input type="hidden" name="pass" value="'.$pass.'">';
    print '<input type="hidden" name="gender" value="'.$gender.'">';
    print '<input type="hidden" name="birth" value="'.$birth.'">';
    print '<input type="button" class="btn btn-secondary" style="margin: 0px 0px 0px 15px;" onclick="history.back()" value="戻る">';
    print '<input type="submit" class="btn btn-primary" value="購入を確定" style="padding: 6px 50px; margin: 0px 15px 0px 0px; float: right;">';
    print '</form>';
} else {
    print '<div class="card" style="margin: 15px;">';
    print '<h5 class="card-header alert-danger">入力にエラーがあります。</h5>';
    print '<div class="card-body">';
    print $error_msg;
    print '</div></div>';
    print '<form>';
    print '<input type="button" class="btn btn-secondary" style="margin: 0px 0px 0px 15px;" onclick="history.back()" value="戻る">';
    print '</form>';
}
?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
