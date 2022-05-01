<?php

// Guardo la salida en un buffer(en memoria)
// No se envia al navegador

//AÑADIR PELICULA
ob_start();
?>
<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<form name='ALTA' method="POST" action="index.php?orden=Alta" enctype="multipart/form-data">
Nombre : <input type="text" name="nombre" value=""><br><br>
Director : <input type="text" name="director" value=""><br><br>
Genero : <input type="text" name="genero" value=""><br><br>
Imagen : <input type="file" name="imagen" id="imagen"><br><br>

	<input type="submit" value="Almacenar">
	<input type="cancel" value="Cancelar" size="10" onclick="javascript:window.location='index.php'" >
</form>
<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "principal.php";

?>