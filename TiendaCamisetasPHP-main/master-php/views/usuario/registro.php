<h1>Registrarse</h1>

<!--Notificaciones de registro del usuario -->
<?php if (isset($_SESSION['register']) && $_SESSION['register'] == 'complete') : ?>

	<strong class="alert_green">Registro completado correctamente</strong>

<?php elseif (isset($_SESSION['register']) && $_SESSION['register'] == 'failed') : ?>

	<strong class="alert_red">Registro fallido, introduce bien los datos o intenta usar otro correo</strong>

<?php endif; ?>

<!--Borramos sesion -->
<?php Utils::deleteSession('register'); ?>

<!--Metodo POST para guardar las nuevas cuentas registradas -->
<form action="<?= base_url ?>usuario/save" method="POST">
	
	<label for="nombre">Nombre</label>
	<input type="text" name="nombre" required />

	<label for="apellidos">Apellidos</label>
	<input type="text" name="apellidos" required />

	<label for="email">Email</label>
	<input type="email" name="email" required />

	<label for="password">Contraseña</label>
	<input type="password" name="password" required />

	<input type="submit" value="Registrarse" />

</form>