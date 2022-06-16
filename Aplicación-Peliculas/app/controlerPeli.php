<?php
// ------------------------------------------------
// Controlador que realiza la gestión de usuarios
// ------------------------------------------------

include_once 'config.php';
include_once 'modeloPeliDB.php'; 
include_once 'Pelicula.php';

/**********
/*
 * Inicio Muestra o procesa el formulario (POST)
 */

function  ctlPeliInicio(){
    die(" No implementado.");
   }

/*
 *  Muestra y procesa el formulario de alta 
 */

function ctlPeliAlta (){
    if  ($_SERVER['REQUEST_METHOD'] == 'GET'){
        include_once 'plantilla/fnuevo.php';
    } else {
        $peli = new Pelicula();
        $peli->nombre   = $_POST['nombre'];
        $peli->director = $_POST['director'];
        $peli->genero   = $_POST['genero'];
        if ( !empty($_FILES['imagen']['name']) ) { 
           if ( $msg = ErrordescargarPeli()){
            include_once 'plantilla/fnuevo.php';
            return;
           } else {
            $peli->imagen = $_FILES['imagen']['name'];     
           }
        } else {
            $peli->imagen = NULL;
        }
        ModeloPeliDB::Insert($peli);
        header('Location: index.php');
    }
}

function ErrordescargarPeli(){
    $nombreFichero   =   $_FILES['imagen']['name'];
    $tipoFichero     =   $_FILES['imagen']['type'];
    $tamanioFichero  =   $_FILES['imagen']['size'];
    $temporalFichero =   $_FILES['imagen']['tmp_name'];
    $errorFichero    =   $_FILES['imagen']['error'];
    $msg=false;
    if ($errorFichero != 0 ){
        $msg="Error al subir el fichero $nombreFichero <br>";
    } else 
    if ($tipoFichero != "image/jpeg" && $tipoFichero != "image/png") {
        $msg =" Error el fichero no es una imagen jpeg o png";
    } else
    if (! move_uploaded_file($temporalFichero,'app/img/'. $nombreFichero )) {
       $msg= "ERROR: el fichero no se puede copiar en imagenes";
       return;
    }
    return $msg;
}


/*
 *  Muestra y procesa el formulario de Modificación 
 */
function ctlPeliDetalles (){
    if ( isset($_GET['codigo'])){
        $codigo = $_GET['codigo'];
        $peli = ModeloPeliDB::GetOne($codigo); 
        include_once 'plantilla/detalle.php';
    }
    
}




/*
 *  Muestra detalles de la pelicula
 */

function ctlPeliModificar(){
    if  ($_SERVER['REQUEST_METHOD'] == 'GET'){
        if ( isset($_GET['codigo'])){
            $codigo = $_GET['codigo'];
            $peli = ModeloPeliDB::GetOne($codigo); 
            include_once 'plantilla/fmodifica.php';
        }
    // Modificar -----<
    } else {
        $peli = new Pelicula();
        $peli->codigo_pelicula = $_POST['codigo_pelicula'];
        $peli->nombre   = $_POST['nombre'];
        $peli->director = $_POST['director'];
        $peli->genero   = $_POST['genero'];
        if ( !empty($_FILES['imagen']['name']) ) { 
            if ( $msg = ErrordescargarPeli()){
             include_once 'plantilla/fmodifica.php';
             return;
            } else {
             $peli->imagen = $_FILES['imagen']['name'];     
            }
         } else {
             $peli->imagen = $_POST['imagenold'];
         }
         $peli->enlacepeli   = $_POST['enlacepeli'];
        ModeloPeliDB::Update($peli);
        header('Location: index.php');
    }   
}
/*
 * Borrar Peliculas
 */

function ctlPeliBorrar(){
    if ( isset($_GET['codigo'])){
        $codigo = $_GET['codigo'];
        $peli = ModeloPeliDB::DeleteOne($codigo); 
        // Muestro la lista actualizada
        ctlPeliVerPelis ();
    }
}

/*
 * Cierra la sesión y vuelca los datos
 */
function ctlPeliCerrar(){
    session_destroy();
    modeloPeliDB::closeDB();
    header('Location:index.php');
}

/*
 * Muestro la tabla con los usuario 
 */ 
function ctlPeliVerPelis (){
    // Obtengo los datos del modelo
    $peliculas = ModeloPeliDB::GetAll(); 
    // Invoco la vista 
    include_once 'plantilla/verpeliculas.php';
   
}

function ctlBuscaTitulo(){
  if (!empty($_GET['valor']) ){
      $valor = $_GET['valor'];
      $peliculas = ModeloPeliDB::GetbyTitulo($valor);
      include_once 'plantilla/verpeliculas.php';
  }
}

function ctlBuscaDirector(){
    if (!empty($_GET['valor']) ){
        $valor = $_GET['valor'];
        $peliculas = ModeloPeliDB::GetbyDirector($valor);
        include_once 'plantilla/verpeliculas.php';
    }
}

function ctlBuscaGenero(){
    if (!empty($_GET['valor']) ){
        $valor = $_GET['valor'];
        $peliculas = ModeloPeliDB::GetbyGenero($valor);
        include_once 'plantilla/verpeliculas.php';
    }
}

function ctlDescargarJSON(){
    $peliculas = ModeloPeliDB::GetAll();
    $json = json_encode($peliculas);
    header("Content-Type: application/json");
    $bytes = file_put_contents("peliculas.json", $json);
    //var_dump($peliculas);
   // header('Location: index.php');
    
}
