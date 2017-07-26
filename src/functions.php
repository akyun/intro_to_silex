<?php
require dirname(__DIR__).'/config/config.php';

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

// ログイン状態によってリダイレクトを行うsession_startの関数
// 初回時または失敗時にはヘッダーを送信してexitする
function require_unlogined_session() {
    // セッション開始
    session_start();
    // すでにログインしていればlist.phpに遷移
    if (isset($_SESSION['username'])) {
        header('Location: ./list.php');
        exit;
    }
}

// ログイン後のセッション
function require_logined_session() {
    // セッション開始
    session_start();
    // ログインしていなければ login.php に遷移
    if (!isset($_SESSION['username'])) {
        header('Location: ./public/login.php');
        exit;
    }
}

// CSRFトークンの発行
function generate_token() {
    // セッションIDからハッシュを生成。sha256を使用
    return hash('sha256', session_id());
}

// CSRFトークンのバリデート
function validate_token($token) {
    // 送信されてきた$tokenがこちらで生成したハッシュと一致するか検証
    return $token === generate_token();
}