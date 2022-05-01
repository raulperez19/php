<?php

include_once 'config.php';
include_once 'Pelicula.php';

class ModeloPeliDB {

     private static $dbh = null; 
     private static $consulta_peli = "Select * from peliculas where codigo_pelicula = ?";
  
     private static $delete_peli   = "Delete from peliculas where codigo_pelicula = ?"; 
     private static $insert_peli   = "Insert into peliculas (nombre,director,genero,imagen)".
                                     " VALUES (?,?,?,?)";
     private static $update_peli    = "UPDATE peliculas set  nombre =?, ".
                                     "director=?, genero=?, imagen=? where codigo_pelicula =?";
   
     
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


// Borrar una pelicula (boolean)
public static function PeliDelete($codigo_pelicula){
    $stmt = self::$dbh->prepare(self::$delete_peli);
    $stmt->bindValue(1,$codigo_pelicula);
    $stmt->execute();
    if ($stmt->rowCount() > 0 ){
        return true;
    }
    return false;
}
// Añadir una nueva pelicula (boolean)
public static function PeliAdd($nombre, $director, $genero, $imagen):bool{
    $stmt = self::$dbh->prepare(self::$insert_peli);
    $stmt->bindValue(1,$nombre);
    $stmt->bindValue(2,$director);
    $stmt->bindValue(3,$genero);
    $stmt->bindValue(4,$imagen);
    if ($stmt->execute()){
       return true;
    }
    return false; 
}
/***

// Actualizar un nuevo usuario (boolean)
// GUARDAR LA CLAVE CIFRADA
public static function UserUpdate ($userid, $userdat){
    $clave = $userdat[0];
    // Si no tiene valor la cambio
    if ($clave == ""){ 
        $stmt = self::$dbh->prepare(self::$update_usernopw);
        $stmt->bindValue(1,$userdat[1] );
        $stmt->bindValue(2,$userdat[2] );
        $stmt->bindValue(3,$userdat[3] );
        $stmt->bindValue(4,$userdat[4] );
        $stmt->bindValue(5,$userid);
        if ($stmt->execute ()){
            return true;
        }
    } else {
        $clave = Cifrador::cifrar($clave);
        $stmt = self::$dbh->prepare(self::$update_user);
        $stmt->bindValue(1,$clave );
        $stmt->bindValue(2,$userdat[1] );
        $stmt->bindValue(3,$userdat[2] );
        $stmt->bindValue(4,$userdat[3] );
        $stmt->bindValue(5,$userdat[4] );
        $stmt->bindValue(6,$userid);
        if ($stmt->execute ()){
            return true;
        }
    }
    return false; 
}
****/

// Tabla de objetos con todas las peliculas
public static function GetAll ():array{
    // Genero los datos para la vista que no muestra la contraseña
    
    $stmt = self::$dbh->query("select * from peliculas");
    
    $tpelis = [];
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
    while ( $peli = $stmt->fetch()){
        $tpelis[] = $peli;       
    }
    return $tpelis;
}
public static function GetByTitulo ():array{
//rellenar
}
public static function GetByDirector ():array{
    //rellenar
}
public static function GetByGenero ():array{
    //rellenar
}
    

   


// Datos de una película para visualizar
public static function PeliGet ($codigo_pelicula){
    $datospelis = [];
    $stmt = self::$dbh->prepare(self::$consulta_peli);
    $stmt->bindValue(1,$codigo_pelicula);
    $stmt->execute();
    if ($stmt->rowCount() > 0 ){
        // Obtengo un objeto de tipo Pelicula, pero devuelvo una tabla
        // Para no tener que modificar el controlador
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
        $pobj = $stmt->fetch();
        $datospelis = [ 
                    $pobj->codigo_pelicula,
                    $pobj->nombre,
                    $pobj->director,
                    $pobj->genero
                     ];
        return $datospelis;
    }
    return null;    
    
}

public static function closeDB(){
    self::$dbh = null;
}

} // class
