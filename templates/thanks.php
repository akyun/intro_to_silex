<?php
// require_once '../config/config.php';
require_once '../app/functions.php';
require_once '../vendor/autoload.php';
require_once '../app/DbManager.php';

// dbへの接続処理
$db = getDb();

// // フォームのボタンが押されたら、送信されたデータを変数へ格納
// // 入力値を配列にしておく

// ブラウザ側からのリクエストがポストで来ているか確認$_SERVER['REQUEST_METHOD'] == 'POST'
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone  = $_POST['phone'];
    $title  = $_POST['title'];
    $message  = $_POST['message'];
}

// // issetで$_POSTに値がセットされているかチェック
if (isset($_POST["submit"])) {

// // -------------------------------------------
// // 以下、Swiftmailerの記述

// // アカウントの設定
  $config = array(
      'host' => 'smtp.gmail.com',
      'port' => 465,
      'user' => 'a.ooishi.gizumo@gmail.com',
      'pass' => 'Dtk4Fxtu',
      'encryption' => 'ssl'
  );

  // ユーザーへのメールの内容
  $subject = 'SCFからのテストメール';
  $body = '本文テスト';
  $from = array('a.ooishi.gizumo@gmail.com' => 'SCF');
  $to = array($email);
  // $to = array($email => 'SCFをご利用の方へ');

// 管理者側へのメール内容
  $subject_admin = 'SCFからの管理者テストメール';
  $body_admin = '本文テスト';
  $from_admin = 'a.ooishi.gizumo@gmail.com';
  $to_admin = array('a.ooishi.gizumo@gmail.com' => 'お問い合わせがありました');

// // 日本語に関する初期設定
  Swift::init(function () {
      Swift_DependencyContainer::getInstance()
          ->register('mime.qpheaderencoder')
          ->asAliasOf('mime.base64headerencoder');
      Swift_Preferences::getInstance()->setCharset('iso-2022-jp');
  });

// // SMTP サーバーとの接続設定
  $transport = Swift_SmtpTransport::newInstance($config['host'], $config['port'])
      ->setUsername($config['user'])
      ->setPassword($config['pass'])
      ->setEncryption($config['encryption']);

  $mailer = Swift_Mailer::newInstance($transport);

// // メールの作成
  $message = Swift_Message::newInstance()
      ->setCharset('iso-2022-jp')
      ->setEncoder(Swift_Encoding::get7BitEncoding())
      ->setSubject($subject, $subject_admin)
      ->setFrom($from)
      ->setTo ($to,'a.ooishi.gizumo@gizumo.com')
      // ->setTo (array($to => 'SCFをご利用の皆様へ', $from_admin =>'a.ooishi.gizumo@gizumo.com'))
      ->setBody($body, $body_admin);

// // 送信
  $result = $mailer->send($message);
// // -------------------------------------------

  }

// dbに取得した情報をINSERTするSQL文
$sql = 'INSERT INTO inquiry(name, email, phone, title, message) VALUES(:name, :email, :phone, :title, :message)';
$stmt = $db->prepare($sql);
$stmt->execute(array(':name' => $name, ':email' => $email, ':phone' => $phone, ':title' => $title,':message' => $message));

// dbの接続を終了
$db = null;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>thanks</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
</head>
<body>
<div>
  <div style='padding-left: 50px'>
    <h1>Your email has been sent!</h1>
    <p>Thank you for contacting us!</p>

    <p><a class="btn btn-primary" href="index.php" role="button">Back to Top page</a></p>

    <!-- <a href="index.php"> -->
      <!-- <button type="button">Back to 1st page</button> -->
    <!-- </a> -->
  </div>
</div>
<script src="http://code.jquery.com/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
