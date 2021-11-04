<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>La frutería</title>
</head>
<body>  
    <H1> La Frutería del siglo XXI</H1>
    <?php
        if ( isset($_GET['cliente'])){
            $_SESSION['cliente'] = $_GET['cliente'];
            $_SESSION['pedidos'] = [];
        }


        if ( isset($_POST["accion"])){
            
            if ( $_POST["accion"] == " Anotar " ){
                if ( isset ($_SESSION['pedidos'][$_POST['fruta']]) )
                $_SESSION['pedidos'][$_POST['fruta']] += $_POST['cantidad'];
                else {
                $_SESSION['pedidos'][$_POST['fruta']] = $_POST['cantidad'];
                }
            }
        
            //Finalizar el pedido y la cesta de la compra
            echo "Este es su pedido :";
            echo "<table style='border: 2px solid black;'>";
            foreach ( $_SESSION['pedidos'] as $key => $value) {
            echo "<tr><td><b>".$key."</b><td></td><td>".$value."</td></tr>";
            }
            echo "</table>";
                
            if ( $_POST["accion"] == " Terminar " ){    
                ?>
                <br> Muchas gracias, por su pedido. <br><br>
                <input type="button" value=" NUEVO CLIENTE " onclick="location.href='<?=$_SERVER['PHP_SELF'];?>'">
                <?php 
                session_destroy();
                exit;
            }
            
        }
        //Login del cliente
        if ( !isset ($_SESSION['cliente'])){ ?>
            <b>Bienvenido a nuestra fruteria del siglo XXI</b><br>
            <form action="<?=$_SERVER['PHP_SELF'];?>" method="GET"><br>
                <p>Introduzca su nombre del cliente: <input type="text" name="cliente"> </p><br>
            </form> 
            <?php 
            
        } else {
        ?>
        <!--Inicio , cliente elige la compra-->
        <b><br> Realice su compra  <?= $_SESSION['cliente']?></b>
        <form action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
            
            <b><p>Selecciona la fruta: <select name="fruta">
                <option value="Platanos">Platanos</option>
                <option value="Naranjas">Naranjas</option>
                <option value="Limones">Limones</option>
                <option value="Manzanas">Manzanas</option>
            </select>
                Cantidad: <input name="cantidad" type="number" value=0 size=4 ></p><br>
                <input type="submit" name="accion" value=" Anotar ">	
                <input type="submit" name="accion" value=" Terminar ">	
        </form>
</body>
</html>
<?php } ?>