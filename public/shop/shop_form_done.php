<?php
require_once(dirname ( __FILE__ ).'/../common.php');
require_once(dirname ( __FILE__ ).'/../mysqlconf.php');
require_once(dirname ( __FILE__ ).'/../mailtext.php');

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
check_csrf_token();

include(dirname ( __FILE__ ).'/../member_navbar.php');

try {
    $post = sanitize($_POST);   

    $onamae = $post['onamae'];
    $email = $post['email'];
    $postal1 = $post['postal1'];
    $postal2 = $post['postal2'];
    $address = $post['address'];
    $tel = $post['tel'];
    $chumon = $post['chumon'];
    $pass = $post['pass'];
    $gender = $post['gender'];
    $birth = $post['birth'];

    $success_msg = '';

    print 'test1';

    if($onamae=='' || preg_match('/\A[\w\-\.]+\@[\w\-\.]+\.([a-z]+)\z/',$email)==0 || 
    preg_match('/\A[0-9]+\z/', $postal1)==0 && preg_match('/\A[0-9]+\z/', $postal2)==0 || 
    $address=='' || preg_match('/\A\d{2,5}-?\d{2,5}-?\d{4,5}\z/', $tel)==0) {
      print '<div class="card card-margin">';
      print '<h5 class="card-header alert-danger">入力が不正です。</h5>';
      print '</div>';
      print '<form>';
      print '<input type="button" class="btn btn-secondary btn-margin" onclick="history.back()" value="戻る">';
      print '</form>';
      exit();
    }

    
    if($chumon=='chumontouroku') {
        if($pass=='') {
          print '<div class="card card-margin">';
          print '<h5 class="card-header alert-danger">入力が不正です。</h5>';
          print '</div>';
          print '<form>';
          print '<input type="button" class="btn btn-secondary btn-margin" onclick="history.back()" value="戻る">';
          print '</form>';
          exit();
        }
    }

    print 'test2';

    $success_msg .= $onamae.'様<br>';
    $success_msg .= 'ご注文ありがとうございました。<br>';
    $success_msg .= $email.'にメールを送りましたのでご確認ください。<br>';
    $success_msg .= '商品は以下の住所に発送させていただきます。<br>';
    $success_msg .= $postal1.'-'.$postal2.'<br>';
    $success_msg .= $address.'<br>';
    $success_msg .= $tel.'<br>';

    // 自動返信メールの文章
    $honbun = order_header($onamae);

    // カート内の情報を変数へ格納
    $cart = $_SESSION['cart'];
    $quantity = $_SESSION['quantity'];
    $max = count($cart);

    print 'test3';

    $dbh = new_pdo();

    // 商品情報をデータベースから読み出し
    for($i=0;$i<$max;$i++) {
        $sql = 'SELECT name,price FROM mst_product WHERE code=?';
        $stmt = $dbh->prepare($sql);
        $data[0] = $cart[$i];
        $stmt->execute($data);

        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        $name = $rec['name'];
        $price = $rec['price'];
        $kakaku[] = $price;
        $suryo = $quantity[$i];
        $shokei = $price * $suryo;

        $honbun .= $name.'';
        $honbun .= $price.'円 x';
        $honbun .= $suryo.'個 =';
        $honbun .= $shokei."円 \n";
    }

    // テーブルロック
    $sql = 'LOCK TABLES dat_sales WRITE, dat_sales_product WRITE, dat_member WRITE';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    // 会員登録
    $lastmembercode=0;
    if($chumon==='chumontouroku'){
        $sql = 'INSERT INTO dat_member(password, name, email, postal1, postal2, address, tel, gender, born) VALUES (?,?,?,?,?,?,?,?,?)';
        $stmt = $dbh->prepare($sql);
        $data = array();
        $data[] = password_hash($pass, PASSWORD_DEFAULT);
        $data[] = $onamae;
        $data[] = $email;
        $data[] = $postal1;
        $data[] = $postal2;
        $data[] = $address;
        $data[] = $tel;
        if($gender == 'male') {
            $data[] = 1;
        } else {
            $data[] = 2;
        }
        $data[] = $birth;
        $stmt->execute($data);

        $sql = 'SELECT LAST_INSERT_ID()';
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        $lastmembercode = $rec['LAST_INSERT_ID()'];
    }

    // 注文レコードの登録
    $sql = 'INSERT INTO dat_sales(code_member, name, email, postal1, postal2, address, tel) VALUES(?,?,?,?,?,?,?)';
    $stmt = $dbh->prepare($sql);
    $data=array();
    $data[]=$lastmembercode;
    $data[]=$onamae;
    $data[]=$email;
    $data[]=$postal1;
    $data[]=$postal2;
    $data[]=$address;
    $data[]=$tel;
    $stmt->execute($data);

    // 直近に発番された番号を取得
    $sql = 'SELECT LAST_INSERT_ID()';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $lastcode = $rec['LAST_INSERT_ID()'];

    // 注文明細の登録
    for($i=0;$i<$max;$i++) {
        $sql = 'INSERT INTO dat_sales_product(code_sales, code_product, price, quantity) VALUES (?,?,?,?)';
        $stmt = $dbh->prepare($sql);
        $data=array();
        $data[]=$lastcode;
        $data[]=$cart[$i];
        $data[]=$kakaku[$i];
        $data[]=$quantity[$i];
        $stmt->execute($data);
    }

    // テーブルロックの解除
    $sql = 'UNLOCK TABLES';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $dbh = null;

    // 入金先を本文に追加、会員登録する場合は登録完了メッセージも追加
    if($chumon==='chumontouroku') {
        $success_msg .= nl2br(message_of_complete_regist_member());
        $honbun .= order_kouza();
        $honbun .= message_of_complete_regist_member();

        $_SESSION['member_login'] = 1;
        $_SESSION['member_code'] = $lastmembercode;
        $_SESSION['member_name'] = $onamae;
    } else {
        $honbun .= order_kouza();
    }

    // 署名を本文に追加
    $honbun .= order_footer();

    // お客様向けメールを送信
    autosend_mail($email, 'ご注文ありがとうございます', $honbun, 'From:info@rokumarunouen.co.jp');

    // お店宛てメールを送信
    autosend_mail('ytkm555@gmail.com', 'お客様からご注文がありました。', $honbun, 'From:'.$email);

    // ページ遷移フラグとカート内情報のセッション変数を解放
    unset($_SESSION['trans_page_flg']);
    unset($_SESSION['cart']);
    unset($_SESSION['quantity']);
} catch(Exception $e) {
    print $e.'<br>';
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
?>

<div class="card card-margin">
  <h5 class="card-header alert-success">注文が完了しました。</h5>
  <div class="card-body">
    <?php print $success_msg; ?>
  </div>
</div>

<a href="/shop/shop_list.php" class="btn btn-primary btn-to-decide">商品一覧へ</a>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
