

<?php

include_once 'config.php';
include_once 'Pelicula.php';

class ModeloPeliDB {

     private static $dbh = null; 
     private static $consulta_peli = "Select * from peliculas where codigo_pelicula = ?";
     private static $insert_peli   = "Insert into peliculas (nombre,director,genero,imagen)".
                                     " VALUES (?,?,?,?)";
  
     private static $delete_peli   = "Delete from peliculas where codigo_pelicula = ?"; 
    
     private static $update_peli= "UPDATE peliculas set  nombre=:nombre, director =:director, ".
                                     "genero=:genero, imagen=:imagen where codigo_pelicula =:codigo_pelicula";
    
     
    
     
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

    public static function insert($peli):bool{
        $stmt = self::$dbh->prepare(self::$insert_peli);
        $stmt->bindValue(1,$peli->nombre);
        $stmt->bindValue(2,$peli->director);
        $stmt->bindValue(3,$peli->genero);
        $stmt->bindValue(4,$peli->imagen );
        if ($stmt->execute()){
        return true;
        }
        return false; 
    }



    // Borrar una pelicula (boolean)
    public static function DeleteOne($peliId){
        $stmt = self::$dbh->prepare(self::$delete_peli);
        $stmt->bindValue(1,$peliId);
        $stmt->execute();
        if ($stmt->rowCount() > 0 ){
            return true;
        }
        return false;
    }



    // Actualizar la pelicula 

    public static function Update (Pelicula $peli){
        
            $stmt = self::$dbh->prepare(self::$update_peli);
            $stmt->bindValue(':codigo_pelicula',$peli->codigo_pelicula );
            $stmt->bindValue(':nombre', $peli->nombre );
            $stmt->bindValue(':genero', $peli->genero );
            $stmt->bindValue(':director',$peli->director );
            $stmt->bindValue(':imagen',$peli->imagen );
            if ($stmt->execute ()){
                return true;
            }
            return false; 
    }


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




    // Datos de una película para visualizar
    public static function GetOne ($codigo){
        $stmt = self::$dbh->prepare(self::$consulta_peli);
        $stmt->bindValue(1,$codigo);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
        $peli = $stmt->fetch();
        return $peli; // Devuele una pelicula o false    
    }


    // Peliculas por titulo
    public static function GetbyTitulo($valor){
        $stmt = self::$dbh->prepare(" Select * from peliculas where nombre like ?");
        $stmt->bindValue(1,$valor."%");
        $stmt->execute();
        $tpelis = [];
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
        while ( $peli = $stmt->fetch()){
            $tpelis[] = $peli;       
        }
        return $tpelis;
    }

    // Peliculas por titulo
    public static function GetbyDirector($valor){
        $stmt = self::$dbh->prepare(" Select * from peliculas where director like ?");
        $stmt->bindValue(1,$valor."%");
        $stmt->execute();
        $tpelis = [];
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
        while ( $peli = $stmt->fetch()){
            $tpelis[] = $peli;       
        }
        return $tpelis;
    }

    // Peliculas por titulo
    public static function GetbyGenero($valor){
        $stmt = self::$dbh->prepare(" Select * from peliculas where genero like ?");
        $stmt->bindValue(1,$valor."%");
        $stmt->execute();
        $tpelis = [];
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
        while ( $peli = $stmt->fetch()){
            $tpelis[] = $peli;       
        }
        return $tpelis;
    }

    public static function closeDB(){
        self::$dbh = null;
    }

} // class
