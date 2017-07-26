<?php
session_start();
header("Content-type: text/html; charset=utf-8");

require_once("fb_config.php");

if (isset($_SESSION['facebook_access_token'])) {
$accessToken = $_SESSION['facebook_access_token'];
$fb->setDefaultAccessToken($accessToken);

    try {
        //取得するユーザ情報の指定
        $response = $fb->get('/me?fields=id,name,first_name,last_name,email,gender');
        $profile = $response->getGraphUser();

        //ユーザ画像取得
        $UserPicture = $fb->get('/me/picture?redirect=false&height=200');
        $picture = $UserPicture->getGraphUser();

    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    $id = $profile['id'];
    $name = $profile['name'];
    $first_name = (isset($profile['first_name'])) ? $profile['first_name'] : '';
    $last_name = (isset($profile['last_name'])) ? $profile['last_name'] : '';
    $email = $profile['email'];
    $gender = (isset($profile['gender'])) ? $profile['gender'] : '';
    $picture_url = $picture['url'];

    echo "アクセストークン：".$accessToken."";
    echo "ID：".$id."";
    echo "名前：".$name."";
    echo "性別：".$gender."";
    echo "ファーストネーム：".$first_name."";
    echo "ラストネーム：".$last_name."";
    echo "メール：".$email."";
    echo "<img src=".$picture_url.">";
    echo "<a href='fb_logout.php'>ログアウト</a>";

} else {
    header('Location: ../../public/fb_login.php');
    exit();
}
?>

<!--#_=_を排除する-->
<script type="text/javascript">
if (window.location.hash && window.location.hash == '#_=_') {
  if (window.history && history.pushState) {
      window.history.pushState("", document.title, window.location.pathname);
  } else {
    // Prevent scrolling by storing the page's current scroll offset
    var scroll = {
        top: document.body.scrollTop,
      left: document.body.scrollLeft
    };
    window.location.hash = '';
    // Restore the scroll offset, should be flicker free
    document.body.scrollTop = scroll.top;
    document.body.scrollLeft = scroll.left;
  }
}
</script>