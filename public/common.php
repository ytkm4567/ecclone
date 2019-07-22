<?php

// 汎用的な機能をもつ関数群

/*
 * staff_login_check() : 管理者としてログインしているかどうか判定する
 */
function staff_login_check() {
    if(isset($_SESSION['login'])==false) {
        print 'ログインが必要です。<br>';
        print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
        exit();
    } else {
        print $_SESSION['staff_name'];
        print 'さんログイン中<br>';
        print '<br>';
    }
}

/*
 * member_login_check() : 会員としてログインしているかどうか判定する
 */
function member_login_check() {
    if(isset($_SESSION['member_login'])==false) {
        print 'ようこそ、ゲスト様　';
        print '<a href="../member/member_login.html">ログイン画面へ</a><br>';
        print '<br>';
    } else {
        print 'ようこそ'.$_SESSION['member_name'].'様';
        print '<a href="../member/member_logout.php">ログアウト</a><br>';
        print '<br>';
    }
}

/*
 * generate_csrf_token() : CSRFトークンを発行する
 */ 
function generate_csrf_token() {
    $token_byte = openssl_random_pseudo_bytes(16);
    $csrf_token = bin2hex($token_byte);
    $_SESSION['csrf_token'] = $csrf_token;
    print '<input type="hidden" name="csrf_token" value="'.$csrf_token.'">';
}

/*
 * check_csrf_token() : 正しいページからのアクセスかどうか判定する
 */
function check_csrf_token() {
    if(!isset($_POST["csrf_token"]) && $_POST["csrf_token"] !== $_SESSION['csrf_token']) {
        print '不正なアクセスです。<br>';
        print 'このページへの直接のアクセスは禁止されています。<br>';
        print '<a href="../index.php">トップページへ</a>';
        exit();
    }
}

/*
 * sanitize() : 送信されてきた値をエスケープする
 * $before : 配列（$_POSTなど）
 */
function sanitize($before) {
    foreach($before as $key => $value) {
        $after[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    if (isset($after)) {
        return $after;
    }
}

/*
 * pulldown_year() : 年のプルダウンメニューを表示する
 * (選択可能範囲：$startyearから$thisyear)
 */
function pulldown_year() {
    $today = getdate();
    $thisyear = $today['year'];
    $startyear = 2015;
    print '<select name="year">';
    for ($i=$startyear; $i<=$thisyear; $i++) {
        print '<option value="'.$i.'">'.$i.'</option>';
    }
    print '</select>';
}

/*
 * pulldown_month() : 月のプルダウンメニューを表示する
 */
function pulldown_month(){
    print '<select name="month">';
    for($i=1;$i<13;$i++) {
        if(mb_strlen($i)==1) {
            print '<option value="0'.$i.'">0'.$i.'</option>';
        } else {
            print '<option value="'.$i.'">'.$i.'</option>';
        }
    }
    print '</select>';
}

/*
 * pulldown_day() : 日のプルダウンメニューを表示する
 */
function pulldown_day() {
    print '<select name="day">';
        for($i=1;$i<32;$i++) {
            if(mb_strlen($i)==1) {
                print '<option value="0'.$i.'">0'.$i.'</option>';
            } else {
                print '<option value="'.$i.'">'.$i.'</option>';
            }
        }
    print '</select>';
}

/*
 * sendmail() : お客様、お店にメールを自動送信する
 * $email : 宛先メールアドレス
 * $title : メールの件名
 * $honbun : メールの本文
 * $header : メールヘッダ
 */
function autosend_mail($email, $title, $honbun, $header) {
    $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
    mb_language('Japanese');
    mb_internal_encoding('UTF-8');
    mb_send_mail($email, $title, $honbun, $header);
}
?>