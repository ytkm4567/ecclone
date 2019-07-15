<?php
/*
 * sanitize() : 送信されてきた値をエスケープする
 * $before : 配列（$_POSTなど）
 */
function sanitize($before) {
    foreach($before as $key => $value) {
        $after[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    return $after;
}

function pulldown_year() {
    print '<select name="year">';
    print '<option value="2017">2017</option>';
    print '<option value="2018">2018</option>';
    print '<option value="2019">2019</option>';
    print '<option value="2020">2020</option>';
    print '</select>';
}

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
?>