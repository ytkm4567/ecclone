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
check_staff_login();

include(dirname ( __FILE__ ).'/../staff_navbar.php');

try {
    $staff_code = $_GET['staffcode'];

    $dbh = new_pdo();

    $sql = 'SELECT name FROM mst_staff WHERE code=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $staff_code;
    $stmt->execute($data);

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $staff_name = $rec['name'];

    $dbh = null;
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

<form method="post" action="/staff/staff_delete_done.php">
    <input type="hidden" name="code" value="<?php print $staff_code; ?>">
    <div class="card card-margin">
        <h5 class="card-header alert-success">スタッフ削除</h5>
        <div class="card-body">
            このスタッフを削除してよろしいですか？<br>
            スタッフコード：<?php print $staff_code; ?><br>
            <br>
            スタッフ名：<?php print $staff_name; ?><br>
            <br>
            ※OKボタンを押すと即時削除されます。<br>
            <br>
            <?php generate_csrf_token(); ?>
            <a href="/staff/staff_list.php" class="btn btn-secondary btn-margin">戻る</a>
            <input type="submit" class="btn btn-danger btn-to-decide" value="OK">
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
