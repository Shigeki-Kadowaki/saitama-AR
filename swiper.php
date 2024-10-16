<?php
require './pg_pdodb.php';
session_start();

try{
    $conn = db_connect();
$sql = 'select * from target order by targetid';
$prepare = $conn->prepare($sql);
$prepare->execute();
$count=$prepare->rowCount();
$spots = $prepare->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
    echo $e->getMessage();
}

try{
    $conn = db_connect();
    $sql = 'SELECT * FROM progress where user_id = ? order by target_id';
    $prepare = $conn->prepare($sql);
    $prepare->bindValue(1, $_SESSION['id']);
    $prepare->execute();
    $count=$prepare->rowCount();
    $progress = $prepare->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
    echo $e->getMessage();
}

for($i=0;$i<count($spots);$i++) {// ユーザーが行ったことのある場所を１，行ったことない場所に０。
    if(in_array($spots[$i]['targetid'], array_column($progress, 'target_id'))) {
        $spots[$i] = array_merge($spots[$i],array('comp'=>1));
    } else {
        $spots[$i] = array_merge($spots[$i],array('comp'=>0));
    };
}
    echo json_encode($spots, JSON_UNESCAPED_UNICODE);

?>