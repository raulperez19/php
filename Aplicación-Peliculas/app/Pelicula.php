<?php
/* DATOS DE UNA PELICULA */

class Pelicula implements JsonSerializable
{
   private $codigo_pelicula;
   private $nombre;
   private $director;
   private $genero;
   private $imagen;
   private $urlvideo;
   private $enlacepeli;
   
   public function JsonSerialize(){
    return [
        'codigo'=>$this->codigo_pelicula,
        'nombre'=>$this->nombre,
        'director'=>$this->director,
        'genero'=>$this->genero,
        'imagen'=>$this->imagen,
        'urlvideo'=>$this->urlvideo,
        'enlacepeli'=>$this->enlacepeli
    ];
    }

   // Getter con método mágico
   public function __get($atributo){
       $class = get_class($this);
       if(property_exists($class, $atributo)) {
           return $this->$atributo;
       }
   }
   
   // Set con método mágico
   public function __set($atributo,$valor){
       $class = get_class($this);
       if(property_exists($class, $atributo)) {
           $this->$atributo = $valor;
       }
   }
   
}

