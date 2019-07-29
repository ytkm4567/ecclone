<?php

// 汎用的な機能をもつ関数群

/*
 * check_staff_login() : 管理者としてログインしているかどうか判定する
 */
function check_staff_login() {
    if(isset($_SESSION['login'])==false) {
        print 'ログインが必要です。<br>';
        print '<a href="/staff_login/staff_login.php">ログイン画面へ</a>';
        exit();
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
 * 送信されてきた値からHTML特殊文字をエスケープする
 * 
 * @param $before 配列（$_POSTなど）
 * @return $after 処理された文字列
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
 * $to_email : 宛先メールアドレス
 * $to_name : 宛先の名前
 * $title : メールの件名
 * $mail_text : メールの本文
 * $from_email : 送信元メールアドレス
 * $from_name : 送信元名前
 */
function autosend_mail($to_email, $to_name, $title, $mail_text, $from_email, $from_name) {
    require_once(dirname ( __FILE__ ).'/../vendor/autoload.php');
    $sendgrid_mail = new \SendGrid\Mail\Mail();
    $sendgrid_mail->setFrom($from_email, $from_name);
    $sendgrid_mail->setSubject($title);
    $sendgrid_mail->addTo($to_email, $to_name);
    $sendgrid_mail->addContent("text/plain", $mail_text);
    $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
    try {
        $response = $sendgrid->send($sendgrid_mail);
    } catch (Exception $e) {
        print nl2br('Caught exception: '. $e->getMessage() ."\n");
    }
}
?>