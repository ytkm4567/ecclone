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
    } else {?>
        <!DOCTYPE html>
        <html>
        <head>
        <meta charset="UTF-8">
        <title>ECClone</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/stylesheet.css">
        </head>
        <body>
        <div class="card card-margin">
            <h5 class="card-header alert-danger">スタッフコードかパスワードが間違っています。</h5>
            <div class="card-body">
                <a href="/staff_login/staff_login.php" class="btn btn-secondary">戻る</a>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        </body>
        </html>
    <?php }
} catch(Exception $e) {
    print 'ただいま障害により大変ご迷惑おかけしております。';
    exit();
}?>