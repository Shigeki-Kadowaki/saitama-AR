<?php
session_start();
// セッション変数の中身を削除
$_SESSION = array();
// セッションを破棄
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<title>巡って埼玉</title>
<link rel="shortcut icon" href="favicon.ico" />
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="common.css">
</head>
<body>
    <h8>ログアウトしました。</h8><br>
    <a href="index.html">ログインへ</a>
</body>
</html>
