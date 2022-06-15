<?php
ob_start();
?>
<h2> Detalles </h2>
<input type="button" value=" Volver " size="10" onclick="javascript:window.location='index.php'" >
<table>
<tr>
<td>Código de película  </td><td> <?= $peli->codigo_pelicula ?></td>
</tr>
<tr><td>Nombre   </td><td>   <?= $peli->nombre ?></td></tr>
<tr><td>Director  </td><td>  <?= $peli->director ?></td></tr>
<tr><td>Genero    </td><td>  <?= $peli->genero  ?></td></tr>
<tr><td>Imagen   </td><td>   
<img src="<?='app/img/'.$peli->imagen; ?>" alt="Imagen no disponible"></img></td></tr>
</td></tr>
</table>
<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido

$contenido = ob_get_clean();
include_once "principal.php";

?>