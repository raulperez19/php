<?php
include_once 'app/Pelicula.php';
// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
$auto = $_SERVER['PHP_SELF'];

?>

<form action="index.php" method="GET">
     &#128270 <input type="text" name="valor" placeholder="Valor a buscar.." required ><th>
	<input type='submit' name='orden' value='Buscar Título'>
	<input type='submit' name='orden' value='Buscar Director'>
	<input type='submit' name='orden' value='Buscar Genero'>
</form>
<hr>
<form action='index.php'>
<input type='hidden' name='orden' value='VerPelis'> 
<input type='submit' value='Ver Todos' >
Tenemos <?= count($peliculas) ?> películas seleccinadas de nuestro catalogo.
</form>
<br>
<table>
<th>Código</th><th>Nombre</th><th>Director</th><th>Genero</th>
<?php foreach ($peliculas as $peli) : ?>
<tr>		
<td><?= $peli->codigo_pelicula ?></td>
<td><?= $peli->nombre ?></td>
<td><?= $peli->director ?></td>
<td><?= $peli->genero ?></td>
<?php if(isset($_SESSION['usuario'])):?>
<td><a href="#"
			onclick="confirmarBorrar('<?= $peli->nombre."','".$peli->codigo_pelicula."'"?>);">Borrar</a></td>
<?php endif; ?>	
<?php if(isset($_SESSION['usuario'])):?>		
<td><a href="<?= $auto?>?orden=Modificar&codigo=<?=$peli->codigo_pelicula?>">Modificar</a></td>
<?php endif; ?>	
<td><a href="<?= $auto?>?orden=Detalles&codigo=<?= $peli->codigo_pelicula?>">Detalles</a></td>
</tr>
<?php endforeach; ?>
</table>
<br>
<form name='f2' action='index.php'>
<input type='hidden' name='orden' value='Alta'> 
<input type='submit' value='Nueva Película' >
<button name='orden' value='DescargarJSON'> JSON </button>
<button name='orden' value="LOGINOUT" >Login out</button>
</form>
<?php
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido de la página principal
$contenido = ob_get_clean();
include_once "principal.php";

?>