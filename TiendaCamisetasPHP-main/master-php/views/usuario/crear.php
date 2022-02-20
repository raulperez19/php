<!--Notificaciones de editar admin -->
<?php if (isset($edit) && isset($user) && is_object($user)) : ?>

	<h1>Editar Usuario: <?= $user->nombre ?></h1>

	<?php $url_action = base_url . "usuario/saveAdmin&id=" . $user->id; ?>

<?php else : ?>

	<h1>Crear nuevo usuario</h1>

	<?php $url_action = base_url . "usuario/saveAdmin"; ?>

	<!--Notificaciones de registro -->
	<?php if (isset($_SESSION['register']) && $_SESSION['register'] == 'complete') : ?>

		<strong class="alert_green">Todo a ido correctamente.</strong>

	<?php elseif (isset($_SESSION['register']) && $_SESSION['register'] == 'failed') : ?>

		<strong class="alert_red">Algún dato incorrecto, por favor revisa los datos introducidos.</strong>

	<?php endif; ?>
	<!--Borramos sesion -->
	<?php Utils::deleteSession('register'); ?>

<?php endif; ?>

<div class="form_container">

	<form action="<?= $url_action ?>" method="POST" enctype="multipart/form-data">

		<label for="nombre">Nombre</label>
		<input type="text" name="nombre" value="<?= isset($user) && is_object($user) ? $user->nombre : ''; ?>" />

		<label for="apellidos">Apellidos</label>
		<input type="text" name="apellidos" value="<?= isset($user) && is_object($user) ? $user->apellidos : ''; ?>" />

		<label for="email">Email</label>
		<input type="text" name="email" value="<?= isset($user) && is_object($user) ? $user->email : ''; ?>" />
		<!--manejamos la contraseña en la vista-->
		<?php if (!isset($edit) && !isset($user)) : ?>
			<label for="password">Password</label>
			<input type="text" name="password" value="<?= isset($user) && is_object($user) ? $user->password : ''; ?>" />

		<?php endif; ?>

		<label for="rol">Rol</label>
		<input type="text" name="rol" value="<?= isset($user) && is_object($user) ? $user->rol : ''; ?>" />


		<label for="imagen">Imagen</label>

		<?php if (isset($user) && is_object($user) && !empty($user->imagen)) : ?>
			<!--manejamos la imagen -->
			<img src="<?= base_url ?>uploads/images/<?= $user->imagen ?>" class="thumb" />

		<?php endif; ?>

		<input type="file" name="imagen" />

		<input type="submit" value="Guardar" />

	</form>
</div>