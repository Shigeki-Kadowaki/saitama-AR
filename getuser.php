<?php
require './pg_pdodb.php';

session_start();

// ログインしていない場合はログイン画面へ遷移
if (!isset($_SESSION['id'])) {
    session_destroy();
    header('Location:./login.html');
    exit;
}

try {
    // ユーザの一覧を出力
    $conn = db_connect();
    $sql = 'SELECT * FROM user order by id';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $member = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($member as $value){
        $array[] = array (
            "id" => $value["id"],
            "mail" => $value["mail"],
            "num" => $value["name"]);
    }
    echo json_encode($array,JSON_UNESCAPED_UNICODE, JSON_PRETTY_PRINT);
} catch  (PDOException $error) {
    echo 'ERROR:'.$error->getMessage();
    die();
}
?>