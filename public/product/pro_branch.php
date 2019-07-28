<?php

session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false) {
    print 'ログインが必要です。<br>';
    print '<a href="/staff_login/staff_login.html">ログイン画面へ</a>';
    exit();
}

/*
 * 商品一覧（pro_list）で押されたボタンによってアクションを変化させる
 */

// 商品参照画面へ
if(isset($_POST['disp'])==true) {
    if(isset($_POST['procode'])==false) {
        header('Location:/product/pro_ng.php');
        exit();
    }
    $pro_code = $_POST['procode'];
    header('Location:/product/pro_disp.php?procode='.$pro_code);
    exit();
}

// スタッフ追加画面へ
if(isset($_POST['add'])==true) {
    header('Location:/product/pro_add.php');
    exit();
}

// 編集へ
if(isset($_POST['edit'])==true) {
    if(isset($_POST['procode'])==false) {
        header('Location:/product/pro_ng.php');
        exit();
    }
    $pro_code = $_POST['procode'];
    header('Location:/product/pro_edit.php?procode='.$pro_code);
    exit();
}

// 削除へ
if(isset($_POST['delete'])==true) {
    if(isset($_POST['procode'])==false) {
        header('Location:/product/pro_ng.php');
        exit();
    }
    $pro_code = $_POST['procode'];
    header('Location:/product/pro_delete.php?procode='.$pro_code);
    exit();
}