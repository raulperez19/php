<?php

function accionDetalles($id){
    $usuario = $_SESSION['tuser'][$id];
    $nombre  = $usuario[0]; 
    $login   = $usuario[1];
    $clave   = $usuario[2];
    $comentario=$usuario[3];
    $orden = "Detalles";
    include_once "layout/formulario.php";
    exit();
}

function accionAlta(){
    $nombre  = "";
    $login   = "";
    $clave   = "";
    $comentario = "";
    $orden= "Nuevo";
    include_once "layout/formulario.php";
    exit();
}

function accionBorrar() {
    $id = $_GET['id'];
    $orden = "Borrar";
    unset($_SESSION['tuser'][$id]);
    $_SESSION['tuser'] = array_values( $_SESSION['tuser']);
    $contenido = mostrarDatos();
    include_once "app/layout/principal.php";
    exit();
}

function accionModificar($id) {
    $usuario = $_SESSION['tuser'][$id];
    $nombre  = $usuario[0];
    $login   = $usuario[1];
    $clave   = $usuario[2];
    $comentario = $usuario[3];
    $orden= "Modificar";
    include_once "layout/formulario.php";
    exit();
}

function accionTerminar() {
    volcarDatos($_SESSION['tuser']);
    $_SESSION = [];
}

function accionPostAlta(){ 
    $registrado = false;
    $msg = "";
    $nuevo = [ $_POST['nombre'],$_POST['login'],$_POST['clave'],$_POST['comentario']];
    limpiarArrayEntrada($_POST); 

    foreach ($_SESSION['tuser'] as $usuario) {
        if ($_POST['login'] == $usuario[1]) {
            $registrado = true;
        }
    } 

    if (!$registrado) {
        $_SESSION['tuser'][]= $nuevo;  
        $msg.="Usuario registrado correctamente";
    } else {
        $msg.="Este usuario ya esta registrado, prueba otro distinto";
    }
    
    return $msg;
}


function accionPostModificar($id) {
    limpiarArrayEntrada($_POST);
    $usuario = $_SESSION['tuser'][$id];
    $usuario = [ $_POST['nombre'],$_POST['login'],$_POST['clave'],$_POST['comentario']];
    $_SESSION['tuser'][$id]= $usuario;  
}


