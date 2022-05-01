<?php
include_once 'app/Pelicula.php';
// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
$auto = $_SERVER['PHP_SELF'];

?>


<table>
<h3>Buscar pelicula:</h3>
<tr>Nombre:<input type="text" name="nombre" value=""> Director:<input type="text" name="director" value=""> Genero:<input type="text" name="genero" value=""></tr>
<hr>
<th>Código</th><th>Nombre</th><th>Director</th><th>Genero</th>
<?php foreach ($peliculas as $peli) : ?>
<tr>		
<td><?= $peli->codigo_pelicula ?></td>
<td><?= $peli->nombre ?></td>
<td><?= $peli->director ?></td>
<td><?= $peli->genero ?></td>
<td><a href="#"
			onclick="confirmarBorrar('<?= $peli->nombre."','".$peli->codigo_pelicula."'"?>);">Borrar</a></td>
<td><a href="<?= $auto?>?orden=Modificar&codigo=<?=$peli->codigo_pelicula?>">Modificar</a></td>
<td><a href="<?= $auto?>?orden=Detalles&codigo=<?= $peli->codigo_pelicula?>">Detalles</a></td>
</tr>
<?php endforeach; ?>
</table>
<br>
<form name='f2' action='index.php'>
<input type='hidden' name='orden' value='Alta'> 
<input type='submit' value='Nueva Película' >
</form>
<?php
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido de la página principal
$contenido = ob_get_clean();
include_once "principal.php";

?>