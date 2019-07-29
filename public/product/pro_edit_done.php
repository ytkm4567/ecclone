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
check_csrf_token();
check_staff_login();

include(dirname ( __FILE__ ).'/../staff_navbar.php');

try {
    $post = sanitize($_POST);
    $pro_code = $post['code'];
    $pro_name = $post['name'];
    $pro_price = $post['price'];
    $pro_image_name_old = $post['image_name_old'];
    $pro_image_name = $post['image_name'];

    // 入力が不正な場合戻るボタンのみ表示する
    if($pro_name === '' || preg_match('/\A[0-9]+\z/', $pro_price) === 0) {
        print '<div class="card card-margin">';
        print '<h5 class="card-header alert-danger">入力が不正です。</h5>';
        print '</div>';
        print '<form>';
        print '<input type="button" class="btn btn-secondary btn-margin" onclick="history.back()" value="戻る">';
        print '</form>';
        exit();
    }

    // データベースへの接続
    $dbh = new_pdo();

    /*
     * SQL文の実行
     */
    $sql = 'UPDATE mst_product SET name=?, price=?, image=? WHERE code=?';
    // PDOStatmentオブジェクトを生成
    $stmt = $dbh->prepare($sql);
    $data[] = $pro_name;
    $data[] = $pro_price;
    $data[] = $pro_image_name;
    $data[] = $pro_code;
    // SQL文を実行
    $stmt->execute($data);

    /*
     * データベースからの切断
     */
    $dbh = null;

    if($pro_image_name_old !== $pro_image_name) {
        if($pro_image_name_old !== '') {
            unlink(dirname ( __FILE__ ).'/images/'.$pro_image_name_old);
        }
    }

    print '<div class="card card-margin">';
    print '<h5 class="card-header alert-success">商品情報の修正が完了しました。</h5>';
    print '<div class="card-body">';
    print 'コード番号'.$pro_code.'の'.$pro_name.'を編集しました。';
    print '</div></div>';
} catch(Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    print $e;
    exit();
}
?>

<a href="/product/pro_list.php" class="btn btn-primary btn-to-decide">スタッフ管理画面へ戻る</a>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
