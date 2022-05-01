<?php
ob_start();
?>
<h2> Detalles </h2>
<table>
<tr><td>Código película   </td><td> <?= $pelicula[0] ?></td></tr>
<tr><td>Nombre   </td><td>   <?= $pelicula[1] ?></td></tr>
<tr><td>Director    </td><td>    <?= $pelicula[2]  ?></td></tr>
<tr><td>Genero   </td><td>   <?= $pelicula[3] ?></td></tr>
<tr><td>Imagen  </td><td>  <img src="app/img/<?= $pelicula[4]  ?>"></td></tr>

</table>
<input type="button" value=" Volver " size="10" onclick="javascript:window.location='index.php'" >
<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido

$contenido = ob_get_clean();
include_once "principal.php";

?>