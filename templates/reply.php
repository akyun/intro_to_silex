<?php
require_once '../vendor/autoload.php';
require_once '../app/functions.php';
require_once '../app/DbManager.php';

// dbへの接続処理
$db = getDb();

// XXX filter_input関数をできれば使いたい
// filter_input — 指定した名前の変数を外部から受け取り、オプションでそれをフィルタリングする

// list.phpで選択したidを変数化
$userid = $_GET['id'];
// inquiryテーブルと取得した$useridを一致させてSELECT
$sql = "SELECT * FROM inquiry WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->execute([':id' => $userid]);

// このページで入力した値をGETで受け取って、その値をDBのinquiryテーブルとmessageテーブルにそれぞれINSERTしたい
if (isset($_GET['name'], $_GET['message'])) {
    $name = $_GET['name'];
    $message = $_GET['message'];
    // 時間の取得
    $now = new DateTime();
    $message_time = $now->format('Y-m-d H:i:s');

// FIX ME emptyでは複数の値の判定ができないため、書き方を一旦これにしておく
    if (!empty($message)) {

    // $sql_inquiry = "INSERT INTO inquiry (message) VALUES (:message)";
    // $stmt = $dbh->prepare($sql_inquiry);
    // $stmt->execute(array(':name' => $name, ':message' => $message));

    // メッセージテーブルにメッセージをINSERT
    $sql_message = "INSERT INTO message (name, message, message_time) VALUES (:name, :message, :message_time)";
    $stmt = $db->prepare($sql_message);
    $stmt->execute([':name' => $name, ':message' => $message, ':message_time' => $message_time]);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<title>reply</title>
</head>
<body>
<div style='padding:50px'>
<h1>Chat room</h1>
<h2>Feel free to ask any question about our service!</h2>
    <div style="padding-top: 20px">
          <h3>User infomation</h3>
          <table class="table table-striped table-bordered">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Time</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Title</th>
                      <th>Message</th>
                      <th>Status</th>
                  </tr>
              </thead>
<?php
while(1) :
$rec = $stmt->fetch(PDO::FETCH_ASSOC);
  if($rec==false) {
    break;
  }
?>
            <tbody>
                <tr>
                    <td><?php print $rec['id']; ?></td>
                    <td><?php print $rec['createdtime']; ?></td>
                    <td><?php print $rec['name']; ?></td>
                    <td><?php print $rec['email']; ?></td>
                    <td><?php print $rec['phone']; ?></td>
                    <td><?php print $rec['title']; ?></td>
                    <td><?php print $rec['message']; ?></td>
                    <td><?php print $rec['status']; ?></td>
                </tr>
            </tbody>
          </table>
    </div>
<?php endwhile; ?>
<!-- メッセージ履歴の表示 -->
    <div>
          <table class="table table-striped">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Message_time</th>
                      <th>Name</th>
                      <th>Message</th>
                  </tr>
              </thead>
              <tbody>
<!-- メッセージデータをDBから取得 -->
<?php
$sql = "SELECT * FROM message where inquiry_id = :inquiry_id ORDER BY message_time";
$stmt = $db->prepare($sql);
$stmt->execute([':inquiry_id' => $userid]);

while(1) :
$message_rec = $stmt->fetch(PDO::FETCH_ASSOC);

  if($message_rec==false) {
    break;
  }
?>
                  <tr>
                      <td><?php print $message_rec['m_id']; ?></td>
                      <td><?php print $message_rec['message_time']; ?></td>
                      <td><?php print $message_rec['name']; ?></td>
                      <td><?php print $message_rec['message']; ?></td>
                  </tr>
<?php endwhile; ?>
              </tbody>
          </table>
    </div>
<!-- ページ下部：返信用テキストエリア -->
<!-- FIX ME ここのGETの飛び先を自分にしているからリロードすると再度レコードが挿入されてしまう -->
    <div style="padding-top: 20px">
    <form method="get" action="reply.php">
        <input type="hidden" name="id" value="<?php echo $userid ?>">
        <div class="form-group row">
            <label for="name" class="col-sm-1 form-control-label">Name</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="name">
            </div>
        </div>
        <div class="form-group row">
            <label for="text" class="col-sm-1 form-control-label">Message</label>
            <div class="col-sm-7" >
                <textarea class="form-control" rows="5" name="message"></textarea>
            </div>
        </div>
        <div style="padding-top: 20px">
            <input class="btn btn-primary" name='submit' type="submit" value="Send">
            <input class="btn btn-primary" onclick='history.back()' type="submit" value="Back">
        </div>
    </form>
    </div>
</div>
<script src="http://code.jquery.com/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>