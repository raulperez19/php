<?php

//Función usuario y contraseña
function usuarioOk($usuario, $contraseña) :bool {
  if (strlen($usuario) >= 8 && $usuario == strrev($contraseña) ) { //Aqui medimos la longitud del usuario para que no sea mayor de 8 y que la contraseña este escrita al revés
   return true;  
  }else{
     return false;
  }
    
}

//Funcion para contar las letras que se repiten
function letrasRepetidas(){
   $texto = $_REQUEST ["comentario"];
   $letra = str_split($texto); //Lo  que hace la función str_split es convertir la variable texto a un array
   $valores = array_count_values ($letra); //Esta función cuenta los valores 1 por 1
   $max = 0; //inicializar la variable

   foreach ($valores as $key => $value) { //recorrer array
      if ($max < $value) {
        $max = $value;
        $maxrep = $key;
      }
   }

   echo $maxrep;
   
}

////Funcion para contar las palabras repetidas
function palabrasRepetidas(){
   $texto = $_REQUEST ["comentario"];
   $palabra = explode(" " , $texto); 
   $valores = array_count_values ($palabra); 
   $max = 0; 

   foreach ($valores as $key => $value) { 
      if ($max < $value) {
        $max = $value;
        $maxrep = $key;
      }
   }

echo $maxrep;
   
}
