<?php

include_once 'config.php';
include_once 'Usuario.php';

class ModeloUserDB {

     private static $dbh = null; 
    
     private static $login_user   = "SELECT * from usuarios where nombre = ? and contraseña = ? "; 

     public static function init(){
    
        if (self::$dbh == null){
            try {
                // Cambiar  los valores de las constantes en config.php
                $dsn = "mysql:host=".DBSERVER.";dbname=".DBNAME.";charset=utf8";
                self::$dbh = new PDO($dsn,DBUSER,DBPASSWORD);
                // Si se produce un error se genera una excepción;
                self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e){
                echo "Error de conexión ".$e->getMessage();
                exit();
            }
            
        }
        
    }

    public static function Usuariologin($nombre , $contraseña){
        $stmt = self::$dbh->prepare(self::$login_user);
        $stmt->bindValue(1,$nombre);
        $stmt->bindValue(2,$contraseña);
        $stmt->execute();
        
        if($stmt->rowCount() > 0){
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
            $usuario = $stmt->fetch();
            return true;
        }else return false;
    }

}