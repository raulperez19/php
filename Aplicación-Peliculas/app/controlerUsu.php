<?php

include_once 'config.php';
include_once 'modeloUserDB.php';


    function ctlUsuariologin(){
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            include_once 'plantilla/formAcceso.php';
        }else {
            $nombre = isset($_POST['user']) ? $_POST['user'] : false;
            $contraseña = isset($_POST['clave']) ? $_POST['clave'] : false;

            $usuario = ModeloUserDB::Usuariologin($nombre,$contraseña);

            if($_POST['orden'] == "Invitado"){
                $_SESSION['Invitado'] = true;
                header('Location: index.php');
            }

            if($usuario == true) {
                $_SESSION['usuario'] = $nombre;
                header('Location: index.php');
            }else{
                include_once 'plantilla/formAcceso.php';
            }
            
        }

    }


?>