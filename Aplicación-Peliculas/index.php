<?php

session_start();
include_once 'app/config.php';
include_once 'app/controlerPeli.php';
include_once 'app/modeloPeliDB.php';
include_once 'app/controlerUsu.php';
include_once 'app/modeloUserDB.php';

// Inicializo el modelo 
ModeloPeliDB::Init();
ModeloUserDB::Init();


// Enrutamiento
// Relación entre peticiones y función que la va a tratar
// Versión sin POO no manejo de Clases ni objetos
// Rutas en MODO PELICULAS
$rutasPelis = [
    "Inicio"      => "ctlPeliInicio",
    "Alta"        => "ctlPeliAlta",
    "Loggin" => "ctlUsuariologin",
    "Detalles"    => "ctlPeliDetalles",
    "Modificar"   => "ctlPeliModificar",
    "Borrar"      => "ctlPeliBorrar",
    "Cerrar"      => "ctlPeliCerrar",
    "VerPelis"    => "ctlPeliVerPelis",
    "Buscar Título"   => "ctlBuscaTitulo",
    "Buscar Genero"   => "ctlBuscaGenero",
    "Buscar Director" => "ctlBuscaDirector",
    "DescargarJSON" => "ctlDescargarJSON",
    "LOGINOUT" => "ctlPeliCerrar",
];

if(!isset($_SESSION['usuario']) &&  !isset($_SESSION['Invitado'])){
    ctlUsuariologin();
    exit();
}

//session_destroy();
if (isset($_GET['orden'])){
            // La orden tiene una funcion asociada 
            if ( isset ($rutasPelis[$_GET['orden']]) ){
                $procRuta =  $rutasPelis[$_GET['orden']];
            }
            else {
                // Error no existe función para la ruta
                header('Status: 404 Not Found');
                echo '<html><body><h1>Error 404: No existe la ruta <i>' .
                    $_GET['ctl'] .
                    '</p></body></html>';
                    exit;
            }
        }
        else {
            $procRuta = "ctlPeliVerPelis";
        }
    
 
// Llamo a la función seleccionada
$procRuta();





