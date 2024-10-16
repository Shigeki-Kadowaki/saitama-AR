<?php
require './pg_pdodb.php';

//フォームからの値をそれぞれ変数に代入
$name = $_POST['name'];
$mail = $_POST['mail'];
$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

//フォームに入力されたmailがすでに登録されていないかチェック
$conn = db_connect();
$sql = 'SELECT * FROM public."user" WHERE mail = :mail';
$stmt = $conn->prepare($sql);
$stmt->bindValue(':mail', $mail);
$stmt->execute();
$member = $stmt->fetch();
if ($member['mail'] === $mail) {
    $msg = '同じメールアドレスが存在します。';
    $link = '<a href="signup.html">戻る</a>';
} else {
    //登録されていなければinsert 
    $conn = db_connect();
    $sql = 'insert into public."user"(name, mail, pass) values (:name, :mail, :pass)';
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':mail', $mail);
    $stmt->bindValue(':pass', $pass);
    $stmt->execute();
    
    $msg = '会員登録が完了しました';
    $link = '<a href="index.html">ログインページ</a>';
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
    <h8><?php echo $msg; ?></h8><!--メッセージの出力-->
    <p><?php echo $link; ?></p>
</body>
</html>