<?php

/**
 * Created by PhpStorm.
 * User: Andurit-PC
 * Date: 15.06.2016
 * Time: 18:13
 */
require_once('../../config.php');
class register
{

    public function insertToDB($userName, $password) {
        try {
            $con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
            $con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $sql = "INSERT INTO users(username, password, token) VALUES(:username, :password, :token)";
            $stmt = $con->prepare( $sql );
            $stmt->bindValue( "username", $userName, PDO::PARAM_STR );
            $stmt->bindValue( "password",  password_hash($password, PASSWORD_BCRYPT), PDO::PARAM_STR );
            $stmt->bindValue( "token",  $this->generateRandomString(), PDO::PARAM_STR );
            $stmt->execute();
            return $con->lastInsertId();
        }catch( PDOException $e ) {
            return $e->getMessage();
        }
    }
    public function generateRandomString($length = 20) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }
    public function decodeJson($data){
        return json_decode($data);
    }

}

$register = new register;
$data = file_get_contents("php://input");
$data = $register->decodeJson($data);
$userId = $register->insertToDB($data->userName, $data->password);
$res = array('id' => $userId);
echo json_encode($res);