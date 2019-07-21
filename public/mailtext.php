<?php

// メール、およびHTMLの文章を戻り値として返す関数群

function order_header($onamae) {
    $honbun = '';
    $honbun .= $onamae."様 \n\nこの度はご注文ありがとうございました。\n";
    $honbun .= "\n";
    $honbun .= "ご注文商品\n";
    $honbun .= "-----------------------------------\n";

    return $honbun;
}

function message_of_complete_regist_member() {
    $message = '';
    $message .= "会員登録が完了いたしました。\n";
    $message .= "次回からメールアドレスとパスワードでログインしてください。\n";
    $message .= "ご注文が簡単にできるようになります。\n";
    $message .= "\n";

    return $message;
}

function order_kouza() {
    $honbun = '';
    $honbun .= "送料は無料です。\n";
    $honbun .= "-----------------------------------\n";
    $honbun .= "\n";
    $honbun .= "代金は以下の口座にお振り込みください。\n";
    $honbun .= "ろくまる銀行 やさい支店 普通口座 1234567\n";
    $honbun .= "入金確認が取れ次第、梱包、発送させていただきます。\n";
    $honbun .= "\n";

    return $honbun;
}

function order_footer() {
    $honbun = '';
    $honbun .= "□□□□□□□□□□□□□□□□□□□\n";
    $honbun .= "〜安心野菜のろくまる農園〜\n";
    $honbun .= "\n";
    $honbun .= "北海道河東郡上士幌町123-4\n";
    $honbun .= "電話 01564-2-1234\n";
    $honbun .= "メール info@rokumarunouen.co.jp\n";
    $honbun .= "□□□□□□□□□□□□□□□□□□□\n";

    return $honbun;
}