<?php

/**
 * Created by PhpStorm.
 * User: Andurit-PC
 * Date: 15.06.2016
 * Time: 18:10
 */
error_reporting(0);
require_once('../../config.php');
class getCandidates
{
//    public function getCandidatesFromDatabase() {
//        try {
//            $con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
//            $con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
//            $sql = "SELECT * FROM candidates as c
//                    INNER JOIN candidates_positions as cp ON c.id=cp.candidateId
//                    INNER JOIN users as u ON c.id=u.id";
//            $stmt = $con->prepare($sql);
//            $stmt->execute();
//            return $stmt->fetchAll(PDO::FETCH_ASSOC);
//        }catch( PDOException $e ) {
//            return $e->getMessage();
//        }
//
//    }
//
//    function prepareResult($data) {
//        $result = [];
//        foreach ($data as $record) {
//            if (!isset($result[$record['candidateId']])) {
//                $result[$record['candidateId']] = array(
//                    'id' => (int) $record['candidateId'],
//                    'firstName' => $record['firstName'],
//                    'lastName' => $record['lastName'],
//                    'addedById' => $record['addedBy'],
//                    'addedByUser' => $record['userName'],
//                    'wasCalled' => $record['wasCalled'],
//                    'wasGood' => $record['wasGood'],
//                    'registered' => $record['registered'],
//                    'positions' => array(
//                        array(
//                            'positionId' => $record['positionId'],
//                            'positionName' => $record['positionName']
//                        )
//                    )
//                );
//            } else {
//                $result[$record['candidateId']]['positions'][] = array(
//                    'positionId' => $record['positionId'],
//                    'positionName' => $record['positionName']
//                );
//            }
//        }
//
//        sort($result);
//
//        return json_encode($result);
//    }
    public function getCandidatesFromDatabase(){
        try {
            $con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
            $con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $sql = "SELECT c.id, c.wasCalled, c.wasGood, c.addedBy, c.name, c.registered, u.userName, GROUP_CONCAT(cp.positionId, ' ', cp.positionName) as positions
                    FROM candidates as c
                    LEFT JOIN candidates_positions as cp ON c.id=cp.candidateId
                    LEFT JOIN users as u ON c.addedBy=u.id
                    GROUP BY c.id
                    ORDER BY c.id DESC";
            $stmt = $con->prepare($sql);
            $stmt->execute();

            $result_arr = array();
            while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
                $tmp_arr = array('id' => $result['id'], 'wasCalled' => $result['wasCalled'], 'wasGood' => $result['wasGood'], 'addedById' => $result['addedBy'], 'addedByUser' => $result['userName'], 'registered' => $result['registered'], 'name' => $result['name']);
                $positions = explode(",", $result['positions']);
                foreach($positions as $s){
                    $components = explode(" ", $s);
                    $positionName = substr(substr($s, strpos($s, ' ')), 1);
                    $tmp_arr['positions'][] = array('positionId' => $components[0], 'positionName' => $positionName);
                }
                $result_arr[] = $tmp_arr;
            }
            return $result_arr;
        }catch( PDOException $e ) {
            return $e->getMessage();
        }
    }

    public function prepareResult($data){
        return json_encode($data);
    }
}
$candidates = new getCandidates;
$data = $candidates->getCandidatesFromDatabase();
echo $candidates->prepareResult($data);