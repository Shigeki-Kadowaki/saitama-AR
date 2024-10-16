<?php
session_start();
$username = $_SESSION['name'];
$html = "";
if (isset($_SESSION['id'])) {
    // ログインしているとき
    $msg = 'こんにちは ' . htmlspecialchars($username, \ENT_QUOTES, 'UTF-8') . ' さん';
    // パスが間違っている可能性アリ。
    $link = '<a href="swiper.html">ARを始める</a><br><a href="logout.php">ログアウト</a>';

    $html=<<<EOF
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="./main.js"></script>
        
    EOF;

} else {
    // ログインしていない時
    $msg = 'ログインしていません';
    $link = '<a href="index.html">ログイン</a>';
    session_destroy();
}
?>
<h8>
<!DOCTYPE html>
<html lang="en">
<link rel="shortcut icon" href="favicon.ico" />
<title>巡って埼玉</title>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo $html ?>
    <title>Document</title>
</head>
<body>
    <?php echo $msg; ?></h8>
    <?php echo $link; ?>
    <div id="disp"></div>
</body>
</html>
