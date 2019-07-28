<?php

session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false) {
    print 'ログインが必要です。<br>';
    print '<a href="/staff/staff_login/staff_login.html">ログイン画面へ</a>';
    exit();
}

/*
 * スタッフ一覧（staff_list）で押されたボタンによってアクションを変化させる
 */

// スタッフ参照画面へ
if(isset($_POST['disp'])==true) {
    if(isset($_POST['staffcode'])==false) {
        header('Location:/staff/staff_ng.php');
        exit();
    }
    $staff_code = $_POST['staffcode'];
    header('Location:/staff/staff_disp.php?staffcode='.$staff_code);
    exit();
}

// スタッフ追加画面へ
if(isset($_POST['add'])==true) {
    header('Location:/staff/staff_add.php');
    exit();
}

// 編集へ
if(isset($_POST['edit'])==true) {
    if(isset($_POST['staffcode'])==false) {
        header('Location:/staff/staff_ng.php');
        exit();
    }
    $staff_code = $_POST['staffcode'];
    header('Location:/staff/staff_edit.php?staffcode='.$staff_code);
    exit();
}

// 削除へ
if(isset($_POST['delete'])==true) {
    if(isset($_POST['staffcode'])==false) {
        header('Location:/staff/staff_ng.php');
        exit();
    }
    $staff_code = $_POST['staffcode'];
    header('Location:/staff/staff_delete.php?staffcode='.$staff_code);
    exit();
}