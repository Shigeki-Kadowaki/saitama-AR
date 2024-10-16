<?php
require './pg_pdodb.php';
session_start();

if(isset($_POST['targetId']) && isset($_SESSION['id'])){
    $target_id = $_POST['targetId'];
    $user_id = $_SESSION['id'];
    
    $conn = db_connect();
    $sql = 'SELECT * FROM progress WHERE user_id = :user_id AND target_id = :target_id';
    $prepare = $conn->prepare($sql);
    $prepare->bindValue(':user_id', $user_id);
    $prepare->bindValue(':target_id', $target_id);
    $prepare->execute();
    $count=$prepare->rowCount();

    if($count == 0){
        $sql = 'INSERT INTO progress (user_id, target_id) VALUES (?,?)';
        $prepare = $conn->prepare($sql);
        $prepare->bindValue(1, $user_id);
        $prepare->bindValue(2, $target_id);
        $prepare->execute();
    }
}

