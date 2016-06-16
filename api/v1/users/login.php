<?php

/**
 * Created by PhpStorm.
 * User: Andurit-PC
 * Date: 15.06.2016
 * Time: 18:13
 */
require_once('../../config.php');
class login
{

    public function getPasswordHash($userName) {
        try {
            $con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
            $con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $sql = "SELECT id, userName, password, token FROM users WHERE userName = :userName LIMIT 1";
            $stmt = $con->prepare( $sql );
            $stmt->bindValue( "userName", $userName, PDO::PARAM_STR );
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch( PDOException $e ) {
            return $e->getMessage();
        }
    }
    public function decodeJson($data){
        return json_decode($data);
    }
}

//GET DATA
$login = new login;
$postData = file_get_contents("php://input");
$postData = $login->decodeJson($postData);
$data = $login->getPasswordHash($postData->userName);
if (password_verify($postData->password, $data['password'])) {
    $token = array('usedId' => $data['id'], 'userName' => $data['userName'], 'token' => $data['token'], 'error' => null);
    echo json_encode($token);
} else {
    $token = array('usedId' => null, 'userName' => null, 'token' => null, 'error' => 'Incorrect login or password');
    echo json_encode($token);
}
