<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir varios archivos</title>
</head>
<body>
    <fieldset>
        <legend>Subir varios archivos</legend>
        
        <form enctype="multipart/form-data" method="POST" action="SubirFicheros.php">
        <label>Elige las imágenes :</label> 
        <input type="hidden" name="MAX_FILE_SIZE" value="200000" /> 
        <input name="archivos[]" type="file" accept="image/png, image/jpg" multiple="">
        <br><br>
        <input type="submit" name="subir" value="Subir imagen"/>
        <input type="reset" name="borrar" value="Borrar selección"/>
    </fieldset>
    
</form>
</body>
</html>

<?php
// Posibles errores de subida segun el manual de PHP
$codigosErrorSubida= [
    0 => 'Subida correcta',
    1 => 'El tamaño del archivo excede el admitido por el servidor', // directivaupload_max_filesize en php.ini
    2 => 'El tamaño del archivo excede el admitido por el cliente', // directiva MAX_FILE_SIZE en el formulario HTML
    3 => 'El archivo no se pudo subir completamente',
    4 => 'No se seleccionó ningún archivo para ser subido',
    6 => 'No existe un directorio temporal donde subir el archivo',
    7 => 'No se pudo guardar el archivo en disco', // permisos
    8 => 'Una extensión PHP evito la subida del archivo' // extensión PHP
    ]; 

    define ( 'tamañoMaximo', 300000);
    $mensaje = '';

    //var_dump($_FILES);
    $directorio = 'C:\xampp\htdocs\tallerPHP\SubirFicheros'; //directorio de alojamiento
    if  ( empty ($_FILES['archivos']['name'][0] )){
        echo " No hay ficheros";
        exit();
    }

    $Ficheros = $_FILES['archivos']['name'];
    $Ficherosnumero = count($Ficheros);
    
    for($i=0;$i<$Ficherosnumero;$i++){
        // No se recibe nada, error al enviar el POST, se supera post_max_size
        if (count($_POST) == 0 ){
        $mensaje= "  Error: se supera el tamaño máximo de un petición POST ";
        }
        // si no se reciben el directorio de alojamiento y el archivo, se descarta el proceso
        
        else {
            
            $nombreFichero   =   $_FILES['archivos']['name'][$i];
            $tipoFichero     =   $_FILES['archivos']['type'][$i];
            $tamanioFichero  =   $_FILES['archivos']['size'][$i];
            $tamcomp=$_FILES['archivos']['size'];
            $errorFichero    =   $_FILES['archivos']['error'][$i];
            $temporalFichero =   $_FILES['archivos']['tmp_name'][$i];

            $mensaje .= '<br/>Intentando subir el archivo : ' . ' <br />';
            $mensaje .= "- Nombre : $nombreFichero" . ' <br />';
            $mensaje .= '- Tamaño : ' . number_format(($tamanioFichero / 1000), 1, ',', '.'). ' KB <br />';
            $mensaje .= "- Tipo : $tipoFichero" . ' <br />' ;
            $mensaje .= "- Nombre archivo temporal : $temporalFichero" . ' <br />';
            $mensaje .= "- Código de estado : $errorFichero" . ' <br />';
            
            $mensaje .= '<br/> RESULTADO <br/>';

            /*if (file_exists($temporalFichero)) {
                $mensaje .= 'ERROR: El archivo ya existe <br />';
                //si existe lanza un valor en 0
            }*/

            if(file_exists($directorio."/".$_FILES['archivos']['name'][$i])){
                $mensaje .= 'ERROR: El archivo ya existe <br />';
            }

            //[100,200,234]=300;
            foreach ($tamcomp as $value) {
                //echo $value/1000.'&nbsp';
                /*$total+=$value; // $total=total+value
                if($total > TAMAÑOMAX){
                    $mensaje .= 'ERROR: El conjunto de archivos supera los 300 <br />';
                }*/
            }

            // Comprueba el peso
            if ($tamanioFichero > tamañoMaximo) {
                $mensaje .= 'ERROR : El archivo es muy pesado <br />';
            }

            // Obtengo el código de error de la operación, 0 si todo ha ido bien
            if ($errorFichero > 0) {
                $mensaje .= "Se ha producido el error : $errorFichero : " . $codigosErrorSubida[$errorFichero] . ' <br />';
            } else { // subida correcta del temporal
                // si es un directorio y tengo permisos     
                if ( is_dir($directorio) && is_writable ($directorio)) { 
                    //Intento mover el archivo temporal al directorio indicado
                    if (move_uploaded_file($temporalFichero,  $directorio .'/'. $nombreFichero) == true) {
                        $mensaje .= 'Archivo guardado en : ' . $directorio .'/'. $nombreFichero . ' <br />';
                    } else {
                        $mensaje .= 'ERROR: Archivo no guardado correctamente <br />';
                    }
                } else {
                    $mensaje .= 'ERROR: No es un directorio correcto o no se tiene permiso de escritura <br />';
                }
            }
        }
    }
?>

<?= $mensaje; ?>
