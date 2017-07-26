<?php
require_once '../vendor/autoload.php';
require dirname(__DIR__).'/app/functions.php';
// require_once '../app/functions.php';

// XXXログインしてない状態のセッション。これ使うとなぜかバグりがち
require_unlogined_session();

// 事前に生成したパスワードハッシュの配列
$hashes = ['admin' => '$2y$10$LcpE2vX3cXLjIGMYWqzmguEQkQ2xpwHsqUWkhf3Lk6E5BMMi9rSxu',];
// ハッシュ関数の使用例
// <?php echo password_hash(test, PASSWORD_DEFAULT);

// filter_input — 指定した名前の変数を外部から受け取り、オプションでそれをフィルタリングする
// ユーザから受け取ったユーザ名とパスワード
$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

// POSTメソッドのときのみ実行
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (validate_token(filter_input(INPUT_POST, 'token')) &&
        password_verify($password,isset($hashes[$username])
                ? $hashes[$username]
                : '$2y$10$abcdefghijklmnopqrstuv' // ユーザ名が存在しないときだけ極端に速くなるのを防ぐ
        )
    ) {
        // 認証が成功したときセッションIDの追跡を防ぐ
        session_regenerate_id(true);
        // ユーザ名をセット
        $_SESSION['username'] = $username;
        // ログイン完了後に遷移
        header('Location: /public/list.php');
        exit;
    }
    // 認証が失敗したとき「403 Forbidden」レスポンスコードを返す
    http_response_code(403);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<title>login</title>
</head>
<body>
<div style='padding: 50px'>
<h1>Administrator log in</h1>
    <form method="post" action="login.php">
        User ID: <input type="text" name="username" value="">
        Password: <input type="password" name="password" value="">
        <input type="hidden" name="token" value="<?php echo h(generate_token())?>">
        <input type="submit" value="login">
    </form>

<!-- エラー表示の記述 -->
<?php if (http_response_code() === 403): ?>
<p style="color: red;">ID or Password is incorrect!</p>
<?php endif; ?>

</div>
<script src="http://code.jquery.com/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>