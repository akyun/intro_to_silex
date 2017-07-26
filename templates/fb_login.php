<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../app/fb_auth/fb_config.php';
header("Content-type: text/html; charset=utf-8");

//コールバックURLの取得
$callback_url = $_SESSION['fb_callback_url'];
$helper = $fb->getRedirectLoginHelper();

// 公開プロフィール
$permissions = ['email'];

// FBがリダイレクトをかける時に渡すURL
$loginUrl = $helper->getLoginUrl($callback_url, $permissions);

// FBログインテスト用
// echo '<a href="' . $loginUrl . '">ログインする</a>';

// dbへの接続処理
// $db = getDb();

// TODO すでにユーザー登録が完了している場合は、名前とアドレスで照合してログイン可にする処理を書く
// $userid = $_POST['id'];
// $email = $_POST['email'];
// inquiryテーブルと取得した$useridを一致させてSELECT
// $sql = "SELECT * FROM inquiry WHERE id = $userid AND email = $email";
// $stmt = $db->prepare($sql);
// $stmt->execute();

// TODO ifかissetで判定して、レコードとポストの値が一致するような処理を書く
// if $_POST['name'] == , $_POST['email'] {

// }
?>

<!DOCTYPE html>
<html>
<head>
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<title>fb_login</title>
</head>
<body>
<div id="container" style='padding: 50px;'>
    <div class="panel panel-default" style="width: 700px;">
    <div class="panel-body">
        <h1>Login</h1>
        <h3>Enter your name and email address to confirm your information!</h3>
        <div style="padding-top: 20px">
        <form method="post" action="fb_login.php">

<!-- TODO バリデーションをつける -->
            <div class="form-group row">
                <label for="name" class="col-sm-1 form-control-label">Name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="name" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="text" class="col-sm-1 form-control-label">Email</label>
                <div class="col-sm-5" >
                    <input type="text" class="form-control" name="email" required>
                </div>
            </div>

<!-- サブミットボタンとFBログイン認証 -->
            <div class="btn-toolbar, form-vertical">
                <div class="btn-group">
                    <div><input class="btn btn-primary" name='submit' type="submit" value="Login"></div>
<!-- FIX ME URLが通ってない -->
                    <div style="padding-top: 20px;"><?php echo '<a href="' . $loginUrl . '"';?>
 class="btn btn-primary" style="background: #3b5998;">Login with Facebook</a></div>
                </div>
            </div>
        </form>
        </div>
    </div>
    </div>
</div>
<script src="http://code.jquery.com/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>