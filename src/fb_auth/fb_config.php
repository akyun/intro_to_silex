<?php
// fbアプリログイン認証情報
$fb = new Facebook\Facebook([
  'app_id' => '165430910650486',
  'app_secret' => '688ea174ba18787e4980f2abc377a0ae',
  //'default_graph_version' => 'v2.2',
  ]);

// FBログイン認証完了後のリダイレクトさせるURLの指定
$_SESSION['fb_callback_url'] = 'http://scf.test/public/index.php';
