<?php

/**
 * Created by PhpStorm.
 * User: Andurit-PC
 * Date: 15.06.2016
 * Time: 18:45
 */
require_once('../../config.php');
class wasGood
{
    public function updateCandidate($candidateId, $value){
        if($value === true) $value = 1;
        else $value = null;
        try {
            $con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
            $con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $sql = "UPDATE candidates SET wasGood=:value WHERE id=:candidateId";
            $stmt = $con->prepare( $sql );
            $stmt->bindValue( "candidateId", $candidateId, PDO::PARAM_STR );
            $stmt->bindValue( "value", $value, PDO::PARAM_INT );
            $stmt->execute();
            return;
        }catch( PDOException $e ) {
            return $e->getMessage();
        }
    }

    public function decodeJson($data){
        return json_decode($data);
    }
}

// get value and candidate ID from data
$wasGood = new wasGood;
$candidate = file_get_contents("php://input");
$candidate = $wasGood->decodeJson($candidate);
$wasGood->updateCandidate($candidate->id, $candidate->value);