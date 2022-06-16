<?php
ob_start();
?>
<h2> Detalles </h2>

<table>
<tr>
<td>Código de película  </td><td> <?= $peli->codigo_pelicula ?></td>
</tr>
<tr><td>Nombre   </td><td>   <?= $peli->nombre ?></td></tr>
<tr><td>Director  </td><td>  <?= $peli->director ?></td></tr>
<tr><td>Genero    </td><td>  <?= $peli->genero  ?></td></tr>
<tr><td>Imagen   </td><td>   
<img src="<?='app/img/'.$peli->imagen; ?>" alt="Imagen no disponible"></img></td></tr>
</td></tr>
<tr><td>Trailer   </td><td>   
<iframe width="560" height="315" src=" <?= $peli->urlvideo ?>" frameborder="0" allowfullscreen></iframe></td></tr>
</td></tr>
<tr><td>Enlace Pelicula   </td><td>   
<a href=" <?= $peli->enlacepeli ?>" > Plataforma dónde ver la película</a></td></tr>
</td></tr>
<tr>
    <td>Votar</td>
        <td><select name="voto" id="voto">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
             <option value="5">5</option>
            </select>
    </td>
</tr>

</table>
<br><br>
<input type="button" value=" Volver " size="10" class='buttonA' onclick="javascript:window.location='index.php'" >
<input type="submit" name="votar" value="votar" class='buttonA'>
<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido

$contenido = ob_get_clean();
include_once "principal.php";

?>