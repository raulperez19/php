<?php


class Producto
{
    public $DESCRIPCION; //nombre
    public $PRODUCTO_NO; //login
    public $PRECIO_ACTUAL; //password
    public  $STOCK_DISPONIBLE; //comentario
    
    // Getter con método mágico
    public function __get($atributo){
        if(property_exists($this, $atributo)) {
            return $this->$atributo;
        }
    }
    // Setter con método mágico
    public function __set($atributo,$valor){
        if(property_exists($this, $atributo)) {
            $this->$atributo = $valor;
        }
    }
    
}

