<?php
require dirname(__DIR__).'/vendor/autoload.php';

// 環境変数の読み込み
use Dotenv\Dotenv, \Whoops\Run;
$dotenv = new Dotenv(dirname(__DIR__));
$dotenv->load(); //.envが無いとエラーになる

// ini_set('display_errors', 1);

// エラーをリッチに表示させるライブラリ
$whoops = new Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

