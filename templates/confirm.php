<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>confirm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
</head>
<body>
<h1 style='padding-left: 50px'>Your contact confirmation</h1>

<?php
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $title = $_POST['title'];
    $message = $_POST['message'];
?>

<div class="container" style="padding:50px 0">
    <table class="table table-striped table-bordered">
        <thead>
          <tr><th>Name</th><th>Email</th><th>Phone</th><th>Title</th><th>Message</th></tr>
        </thead>
        <tbody>
          <tr>
            <td><?php print $name; ?> </td>
            <td><?php print $email; ?> </td>
            <td><?php print $phone; ?> </td>
            <td><?php print $title; ?> </td>
            <td><?php print $message; ?> </td>
          </tr>
        </tbody>
    </table>
</div>

        <!-- 入力値をhiddenでサンクスページに渡す -->
        <form method="post" action="thanks.php">
            <input type="hidden" name="name" value="<?php echo $name ?>">
            <input type="hidden" name="email" value="<?php echo $email ?>">
            <input type="hidden" name="phone" value="<?php echo $phone ?>">
            <input type="hidden" name="title" value="<?php echo $title ?>">
            <input type="hidden" name="message" value="<?php echo $message ?>">

        <!-- 戻るボタンとサブミットボタン -->
            <div style="padding-left:50px">
                <input class="btn btn-primary" onclick='history.back()' type="submit" value="Back">
                <input class="btn btn-primary" name='submit' type="submit" value="Send">

                <!-- <input type="button" onclick="history.back()" value="Back"> -->
                <!-- <button type="submit" name="submit" value="thanks">Send</button> -->
            </div>
        </form>

<script src="http://code.jquery.com/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>