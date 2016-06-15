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
            $sql = "INSERT INTO users(username, password) VALUES(:username, :password)";
            $stmt = $con->prepare( $sql );
            $stmt->bindValue( "username", $userName, PDO::PARAM_STR );
            $stmt->bindValue( "password",  password_hash($password, PASSWORD_BCRYPT), PDO::PARAM_STR );
            $stmt->execute();
        }catch( PDOException $e ) {
            return $e->getMessage();
        }
    }
}

//GET DATA
$userName = 'Acko';
$password = 'Cecko';
$register = new register;
$register->insertToDB($userName, $password);