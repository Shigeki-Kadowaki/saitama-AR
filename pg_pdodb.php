<?php
function db_connect() {
    //DB接続パラメータ
    $dbType = "pgsql";
    $dbHost = "172.16.12.110";
    $dbName = "postgres";
    $dbUser = "postgres";
    $dbPass = "s0611";
    $dbPort = "5432";
    
    //DBへの接続
    try
    {
        //コネクションの確立
        $dbh = new PDO(
                        $dbType . ":host=" . $dbHost . ";dbname=" . $dbName . ";port=" . $dbPort, 
                        $dbUser , 
                        $dbPass
        );
        return $dbh;
    }
    catch( PDOException $e )
    {
        var_dump( $e->getMessage() );
        exit;
    }
}
?>