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
            $sql = "SELECT password FROM users WHERE userName = :userName LIMIT 1";
            $stmt = $con->prepare( $sql );
            $stmt->bindValue( "userName", $userName, PDO::PARAM_STR );
            $stmt->execute();
            return $stmt->fetchColumn();
        }catch( PDOException $e ) {
            return $e->getMessage();
        }
    }
}

//GET DATA
$userName = 'Acko';
$password = 'Cecko';
$login = new login;
$passwordHash = $login->getPasswordHash($userName);
if (password_verify($password, $passwordHash)) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}
