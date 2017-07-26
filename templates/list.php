<?php
require_once '../app/functions.php';
require_once '../vendor/autoload.php';
require_once '../app/DbManager.php';

// ログイン完了した場合のセッション
require_logined_session();

// dbへの接続処理
$db = getDb();

// inquiryテーブルからすべてのユーザー情報を取ってくるというSELECT文
$sql = "SELECT * FROM inquiry WHERE 1";
$stmt = $db->prepare($sql);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<script src="http://code.jquery.com/jquery.js"></script>
<title>Admin</title>
</head>
<body>
<div>
    <h2 style="padding-left:50px"><?php echo h($_SESSION['username']); ?> logged in successfully!</h2>
    <h2 style="padding-left:50px">Administrators only!</h2>
    <div class="container" style="padding:20px 0">
<!-- TODO: ステータスのソート機能を実装すること -->
        <div style="padding-bottom: 20px">
            <select name='status'>
                <option value='new-contact' name='new'>New</option>
                <option value='pending' name='pending'>Pending</option>
                <option value='done' name='done'>Done</option>
            </select>
        </div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr><th>ID</th><th>Time</th><th>Name</th><th>Title</th><th>Status</th><th>Details</th></tr>
            </thead>
            <tbody>
<!-- dbからリスト表示したい情報をwhile(1)で全て繰り返し表示する -->
<?php
while(1):
$rec = $stmt->fetch(PDO::FETCH_ASSOC);
  if($rec==false) {
    break;
  }
?>
                <tr>
                    <td><?php print $rec['id']; ?> </td>
                    <td><?php print $rec['createdtime']; ?> </td>
                    <td><?php print $rec['name']; ?> </td>
                    <td><?php print $rec['title']; ?> </td>

<!-- TODO ステータスを変更するとAjaxの処理が走ってDBの内容もUPDATEがかかる記述を書く必要がある -->
                    <td><select name='status'>
                            <option value='new-contact' name='new'>New</option>
                            <option value='pending' name='pending'>Pending</option>
                            <option value='done' name='done'>Done</option>
                        </select>
                    </td>
                    <td>
<!-- 選択したレコードのIDをGETでreply.phpに渡す -->
                        <a href='reply.php?id=<?php echo $rec['id']; ?>' class="btn btn-primary" id="reply">Reply</a>
                    </td>
                </tr>
<?php endwhile; ?>
            </tbody>
        </table>
    </div>
<!-- クリックするとlogout機能が走ってセッションが切れる処理 -->
    <p style="padding-left:50px"><a class="btn btn-primary" href="logout.php?token=<?php h(generate_token()); ?>" role="button">Logout</a></p>
</div>



<script src="http://code.jquery.com/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>