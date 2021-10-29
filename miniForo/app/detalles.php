<?php include_once "funciones.php"?>
<div>
<b> Detalles:</b><br>
<table>
<tr><td>Longitud:          </td><td><?= strlen($_REQUEST['comentario']) ?></td></tr>
<tr><td>Nº de palabras:    </td><td><?php echo str_word_count ($_REQUEST["comentario"])?></td></tr>
<tr><td>Letra + repetida:  </td><td><?php letrasRepetidas() ?></td></tr>
<tr><td>Palabra + repetida:</td><td><?php palabrasRepetidas() ?></td></tr>
</table>
</div>

