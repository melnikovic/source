<?php

/**
 * Created by PhpStorm.
 * User: Andurit-PC
 * Date: 15.06.2016
 * Time: 18:13
 */
require_once('../../config.php');
class getPositions
{
    public function getFromDatabase(){
        try {
            $con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
            $con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $sql = "SELECT * FROM positions";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch( PDOException $e ) {
            return $e->getMessage();
        }

    }

    public function prepareResult($data){
        return json_encode($data);
    }

}

$positions = new getPositions;
$data = $positions->getFromDatabase();
echo $positions->prepareResult($data);