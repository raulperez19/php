<?php
// ------------------------------------------------
// Controlador que realiza la gestión de usuarios
// ------------------------------------------------

include_once 'config.php';
include_once 'modeloPeliDB.php'; 

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
    
    if($_POST){
        $nombre = $_POST['nombre'];
        $director =$_POST['director'] ;
        $genero = $_POST['genero'];
        $imagen = $_POST['imagen'];//modificar para que se pueda guardar imagenes
        if($nombre && $director && $genero){
            if($imagen ==""){
                $imagen ="";
            }
            $pelicula = ModeloPeliDB::PeliAdd($nombre, $director, $genero, $imagen);
        }  
    }   
    // Invoco la vista 
    include_once 'plantilla/fnuevo.php';
}
/*
 *  Muestra y procesa el formulario de Modificación 
 */
function ctlPeliModificar (){
     // Invoco la vista 
     include_once 'plantilla/fmodifica.php';
}



/*
 *  Muestra detalles de la pelicula
 */

function ctlPeliDetalles(){
    if ( isset($_GET['codigo'])){
        $codigo = $_GET['codigo'];
        $pelicula = ModeloPeliDB::PeliGet($codigo);

        // Invoco la vista 
        include_once 'plantilla/detalle.php';
    }
     

}
/*
 * Borrar Peliculas
 */

function ctlPeliBorrar(){
   if ( isset($_GET['codigo'])){
       $codigo = $_GET['codigo'];
       $pelicula = ModeloPeliDB::PeliDelete($codigo);
       //Lista actualizada
       ctlPeliVerPelis ();
   }
}

/*
 * Buscar Peliculas
 */
function ctlBuscarTitulo (){
    if(!empty($_GET['valor'])){
        $valor = $_GET['valor'];
        $peliculas = ModeloPeliDB::GetByTitulo($valor); 
        // Invoco la vista 
        include_once 'plantilla/verpeliculas.php';
    }
}
function ctlBuscarDirector (){
    if(!empty($_GET['valor'])){
        $valor = $_GET['valor'];
        $peliculas = ModeloPeliDB::GetByDirector($valor); 
        // Invoco la vista 
        include_once 'plantilla/verpeliculas.php';
    }
}
function ctlBuscarGenero (){
    if(!empty($_GET['valor'])){
        $valor = $_GET['valor'];
        $peliculas = ModeloPeliDB::GetByGenero($valor); 
        // Invoco la vista 
        include_once 'plantilla/verpeliculas.php';
    }
}

/*
 * Cierra la sesión y vuelca los datos
 */
function ctlPeliCerrar(){
    session_destroy();
    modeloUserDB::closeDB();
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