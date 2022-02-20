<h1>Crear nueva categoria</h1>
<?php $nombre = (isset($cat->nombre)) ? "$cat->nombre" : " " ; ?>
<form action="<?=base_url?>categoria/save" method="POST">
	<label for="nombre">Nombre</label>
	<input type="text" name="nombre" value="<?=$nombre?>" required/>
	
	<input type="submit" value="Guardar" />
</form>