<?php

// データベースに関する機能をもつ関数群

/*
 * データベースへの接続
 */ 
function new_pdo(){

    $filename = '../isDevelopment.txt';

    /*
     * 開発環境とheroku環境で接続先DBを切り替える
     */ 
    if (!file_exists($filename)){
        //For Heroku
        $url = parse_url(getenv('CLEARDB_DATABASE_URL'));

        $server = $url["host"];
        $user = $url["user"];
        $password = $url["pass"];
        $db = substr($url["path"], 1);

        $dsn = 'mysql:host=' . $server . ';dbname=' . $db . ';charset=utf8mb4';

        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;

    }else{
        //For development
        $dsn = 'mysql:dbname=ec_testdb;host=localhost;charset=utf8mb4';
        $user = 'root';
        $password = 'root';
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $pdo;

    }
}