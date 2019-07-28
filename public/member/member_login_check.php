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
    } else {
        print 'メールアドレスかパスワードが間違っています。<br>';
        print '<a href="/member/member_login.html">戻る<a>';
    }
} catch(Exception $e) {
    print 'ただいま障害により大変ご迷惑おかけしております。';
    exit();
}