<h1>Gestión de productos</h1>

<a href="<?=base_url?>producto/crear" class="button button-small">
	Crear producto
</a>

<?php if(isset($_SESSION['producto']) && $_SESSION['producto'] == 'complete'): ?>
	<strong class="alert_green">El producto se ha creado correctamente</strong>
<?php elseif(isset($_SESSION['producto']) && $_SESSION['producto'] != 'complete'): ?>	
	<strong class="alert_red">El producto NO se ha creado correctamente</strong>
<?php endif; ?>
<?php Utils::deleteSession('producto'); ?>
	
<?php if(isset($_SESSION['delete']) && $_SESSION['delete'] == 'complete'): ?>
	<strong class="alert_green">El producto se ha borrado correctamente</strong>
<?php elseif(isset($_SESSION['delete']) && $_SESSION['delete'] != 'complete'): ?>	
	<strong class="alert_red">El producto NO se ha borrado correctamente</strong>
<?php endif; ?>
<?php Utils::deleteSession('delete'); ?>
	
<table>
	<tr>
		<th>ID</th>
		<th>NOMBRE</th>
		<th>PRECIO</th>
		<th>STOCK</th>
		<th>ACCIONES</th>
	</tr>
	<?php while($pro = $productos->fetch_object()): ?>
		<tr>
			<td><?=$pro->id;?></td>
			<td><?=$pro->nombre;?></td>
			<td><?=$pro->precio;?></td>
			<td><?=$pro->stock;?></td>
			<td>
				<a href="<?=base_url?>producto/editar&id=<?=$pro->id?>" class="button button-gestion">Editar</a>
				<a href="<?=base_url?>producto/eliminar&id=<?=$pro->id?>" class="button button-gestion button-red">Eliminar</a>
			</td>
		</tr>
	<?php endwhile; ?>
</table>
<!--Gestion de Productos-->
<br><br>
<h1>Información de los productos</h1>
<table>
		<tr>
			<th>Total de ventas</th>
			<td><?=$total_Ventas?></td>
		</tr>
		<tr>
			<th>Producto mas vendido</th>
			<td><?php while($prod = $mas_Vendido->fetch_object()): ?>
				<p><?=$prod->nombre;?></p>
				<?php endwhile; ?>
			</td>
		</tr>
		<tr>
			<th>Productos sin ventas</th>
			<td><?php while($prod = $sin_Ventas->fetch_object()): ?>
				<p><?=$prod->nombre;?></p>
				<?php endwhile; ?>
			</td>
		</tr>
		<tr>
			<th>Productos sin existencias</th>
			<td><?php while($prod = $sin_Stock->fetch_object()): ?>
				<p><?=$prod->nombre;?></p>
				<?php endwhile; ?>
			</td>
		</tr>
	</table>