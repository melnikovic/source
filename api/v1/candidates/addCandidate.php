<?php

/**
 * Created by PhpStorm.
 * User: Andurit-PC
 * Date: 15.06.2016
 * Time: 18:45
 */
require_once('../../config.php');
class addCandidate
{
    public function insertToCandidates($candidate){
        try {
            $con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
            $con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $sql = "INSERT INTO candidates(name, addedBy) VALUES(:name, :addedBy)";
            $stmt = $con->prepare( $sql );
            $stmt->bindValue( "name", $candidate->name, PDO::PARAM_STR );
            $stmt->bindValue( "addedBy", $candidate->addedBy, PDO::PARAM_STR );
            $stmt->execute();
            return $con->lastInsertId();
        }catch( PDOException $e ) {
            return $e->getMessage();
        }
    }
    public function insertPosition($candidateId, $position){
        try {
            $con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
            $con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $sql = "INSERT INTO candidates_positions(candidateId, positionId, positionName) VALUES(:candidateId, :positionId, :positionName)";
            $stmt = $con->prepare( $sql );
            $stmt->bindValue( "candidateId", $candidateId, PDO::PARAM_STR );
            $stmt->bindValue( "positionId", $position->id, PDO::PARAM_STR );
            $stmt->bindValue( "positionName", $position->positionName, PDO::PARAM_STR );
            $stmt->execute();
        }catch( PDOException $e ) {
            return $e->getMessage();
        }
    }

    public function decodeJson($data){
        return json_decode($data);
    }
}
$addCandidate = new addCandidate;
$candidate = file_get_contents("php://input");
$candidate = $addCandidate->decodeJson($candidate);
$candidateId = $addCandidate->insertToCandidates($candidate);
foreach($candidate->positions as $position){
    $addCandidate->insertPosition($candidateId, $position);
}
echo json_encode(array('candidateId' => $candidateId));