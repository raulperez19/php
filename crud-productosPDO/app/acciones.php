<?php
include_once "Producto.php";

function accionBorrar ($PRODUCTO_NO){    
    $db = AccesoDatos::getModelo();
    $tprod = $db->borrarProducto($PRODUCTO_NO);
}

function accionTerminar(){
    AccesoDatos::closeModelo();
    session_destroy();
}
 
function accionAlta(){
    $prod = new Producto();
    $prod->DESCRIPCION  = "";
    $prod->PRODUCTO_NO   = "";
    $prod->PRECIO_ACTUAL   = "";
    $prod->STOCK_DISPONIBLE = "";
    $orden= "Nuevo";
    include_once "layout/formulario.php";
}

function accionDetalles($PRODUCTO_NO){
    $db = AccesoDatos::getModelo();
    $prod = $db->getProducto($PRODUCTO_NO);
    $orden = "Detalles";
    include_once "layout/formulario.php";
}


function accionModificar($PRODUCTO_NO){
    $db = AccesoDatos::getModelo();
    $prod = $db->getProducto($PRODUCTO_NO);
    $orden="Modificar";
    include_once "layout/formulario.php";
}

function accionPostAlta(){
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    $prod = new Producto();
    $prod->DESCRIPCION  = $_POST['DESCRIPCION'];
    $prod->PRODUCTO_NO   = $_POST['PRODUCTO_NO'];
    $prod->PRECIO_ACTUAL   = $_POST['PRECIO_ACTUAL'];
    $prod->STOCK_DISPONIBLE = $_POST['STOCK_DISPONIBLE'];
    $db = AccesoDatos::getModelo();
    $db->addProducto($prod);
    
}

function accionPostModificar(){
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    $prod = new Producto();
    $prod->DESCRIPCION  = $_POST['DESCRIPCION'];
    $prod->PRODUCTO_NO   = $_POST['PRODUCTO_NO'];
    $prod->PRECIO_ACTUAL  = $_POST['PRECIO_ACTUAL'];
    $prod->STOCK_DISPONIBLE = $_POST['STOCK_DISPONIBLE'];
    $db = AccesoDatos::getModelo();
    $db->modProducto($prod);
    
}

