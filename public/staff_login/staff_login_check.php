<?php

require_once(dirname ( __FILE__ ).'/../common.php');
require_once(dirname ( __FILE__ ).'/../mysqlconf.php');

try {
    $post = sanitize($_POST);
    $staff_code = $post['code'];
    $staff_pass = $post['pass'];

    // データベースへの接続
    $dbh = new_pdo();

    $sql = 'SELECT name,password FROM mst_staff WHERE code=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $staff_code;
    $stmt->execute($data);

    $dbh = null;

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    if(password_verify($staff_pass, $rec['password'])) {
        session_start();
        $_SESSION['login'] = 1;
        $_SESSION['staff_code'] = $staff_code;
        $_SESSION['staff_name'] = $rec['name'];
        header('Location:staff_top.php');
        exit();
    } else {
        print 'スタッフコードかパスワードが間違っています。<br>';
        print '<a href="staff_login.html">戻る<a>';
    }
} catch(Exception $e) {
    print 'ただいま障害により大変ご迷惑おかけしております。';
    exit();
}