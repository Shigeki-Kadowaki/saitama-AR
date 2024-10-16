<?php
require './pg_pdodb.php';

try{
    $conn = db_connect();
    $sql = 'SELECT * FROM progress order by target_id';
    $prepare = $conn->prepare($sql);
    $prepare->execute();
    $count=$prepare->rowCount();
    $progress = $prepare->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
    echo $e->getMessage();
}

echo json_encode($progress, JSON_UNESCAPED_UNICODE);

?>