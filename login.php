<?php
require './pg_pdodb.php';

session_start();
$mail = $_POST['mail'];

$conn = db_connect();
$sql = 'SELECT * FROM public."user" WHERE mail = :mail';
$stmt = $conn->prepare($sql);
$stmt->bindValue(':mail', $mail);
$stmt->execute();
$member = $stmt->fetch();
//指定したハッシュがパスワードにマッチしているかチェック
if (password_verify($_POST['pass'], $member['pass'])) {
    // 前回ログイン時のセッションIDを受け入れている可能性があるのでIDを再発行
    session_regenerate_id();
    // ユーザー情報をセッションに保存
    $_SESSION['id'] = $member['id'];
    $_SESSION['name'] = $member['name'];
    header('Location:./swiper.html');
    exit;
} else {
    $msg = 'メールアドレスもしくはパスワードが間違っています。';
    $link = '<a href="index.html">戻る</a>';
    session_destroy();
}
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
    <h8><?php echo $msg; ?></h8>
    <p><?php echo $link; ?></p>
</body>
</html>