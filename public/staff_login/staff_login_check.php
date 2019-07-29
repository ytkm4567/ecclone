<?php
session_start();
session_regenerate_id(true);

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
        header('Location:/staff_login/staff_top.php');
        exit();
    } else {
        print '<div class="card card-margin">';
        print '<h5 class="card-header alert-danger">スタッフコードかパスワードが間違っています。</h5>';
        print '<div class="card-body">';
        print '<a href="/staff_login/staff_login.php" class="btn btn-secondary">戻る</a>';
        print '</div></div>';
    }
} catch(Exception $e) {
    print 'ただいま障害により大変ご迷惑おかけしております。';
    exit();
}