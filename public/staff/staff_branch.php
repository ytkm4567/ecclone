<?php

/*
 * スタッフ一覧（staff_list）で押されたボタンによってアクションを変化させる
 */

// スタッフ参照画面へ
if(isset($_POST['disp'])==true) {
    if(isset($_POST['staffcode'])==false) {
        header('Location:staff_ng.php');
        exit();
    }
    $staff_code = $_POST['staffcode'];
    header('Location:staff_disp.php?staffcode='.$staff_code);
    exit();
}

// スタッフ追加画面へ
if(isset($_POST['add'])==true) {
    header('Location:staff_add.php');
    exit();
}

// 編集へ
if(isset($_POST['edit'])==true) {
    if(isset($_POST['staffcode'])==false) {
        header('Location:staff_ng.php');
        exit();
    }
    $staff_code = $_POST['staffcode'];
    header('Location:staff_edit.php?staffcode='.$staff_code);
    exit();
}

// 削除へ
if(isset($_POST['delete'])==true) {
    if(isset($_POST['staffcode'])==false) {
        header('Location:staff_ng.php');
        exit();
    }
    $staff_code = $_POST['staffcode'];
    header('Location:staff_delete.php?staffcode='.$staff_code);
    exit();
}