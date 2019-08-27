<?php

require_once(dirname ( __FILE__ ).'/../common.php');
require_once(dirname ( __FILE__ ).'/../mysqlconf.php');

try {
    $post = sanitize($_POST);
    $member_email = $post['email'];
    $member_pass = $post['pass'];

    // データベースへの接続
    $dbh = new_pdo();

    $sql = 'SELECT code,name,password FROM dat_member WHERE email=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $member_email;
    $stmt->execute($data);

    $dbh = null;

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    if(password_verify($member_pass, $rec['password'])) {
        session_start();
        $_SESSION['member_login'] = 1;
        $_SESSION['member_code'] = $rec['code'];
        $_SESSION['member_name'] = $rec['name'];
        header('Location:/shop/shop_list.php');
        exit();
    } else {?>
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
            <div class="card card-margin">
                <h5 class="card-header alert-danger">メールアドレスかパスワードが間違っています。</h5>
            </div>
            <form>
                <a href="/member/member_login.php" class="btn btn-secondary btn-margin">戻る</a>
            </form>
        </body>
        </html>
    <?php }
} catch(Exception $e) {
    print 'ただいま障害により大変ご迷惑おかけしております。';
    exit();
} ?>