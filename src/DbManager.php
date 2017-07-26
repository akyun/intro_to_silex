<?php
// namespace DbManager;
// dbへの接続処理
function getDb() {
    $dsn ='mysql:dbname=SampleContactForm;host=localhost';
    $user = 'dbuser';
    $password = 'password';
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}

