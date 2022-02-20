<h1>Mis Datos</h1>

<!--Notificaciones de editar usuario -->
<?php if (isset($_SESSION['userMod']) && $_SESSION['userMod'] == 'complete') : ?>

    <strong class="alert_green">El usuario se ha modificado satisfactoriamente</strong>

<?php elseif (isset($_SESSION['userMod']) && $_SESSION['userMod'] != 'complete') : ?>

    <strong class="alert_red">A ocurrido un problema al modificar el usuario, revise los datos que ha introducido</strong>

<?php endif; ?>

<!--Borramos Sesion -->
<?php Utils::deleteSession('userMod'); ?>

<div class="form_container">
    <!--Metodo POST para guardar los datos cambiados -->
    <form action="<?= base_url ?>usuario/guardarcambios" method="POST" enctype="multipart/form-data">

        Nombre: <input type="text" name="nombre" value="<?= $usu->nombre ?>" />

        Apellidos: <input type="text" name="apellidos" value="<?= $usu->apellidos ?>" />

        Email: <input type="text" name="email" value="<?= $usu->email ?>" />

        Contraseña: <input type="password" name="password" />

        Nueva Contraseña: <input type="password" name="passwordN1" />

        Repite Contraseña: <input type="password" name="passwordN2" />

        <input type="submit" value="Guardar" />

    </form>
</div>