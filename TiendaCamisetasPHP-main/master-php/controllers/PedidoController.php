<?php

use Dompdf\Dompdf;
use FontLib\Table\Type\name;

require_once 'models/Pedido.php';
require_once 'models/Usuario.php';
require_once 'vendor/autoload.php';

class pedidoController
{

	public function hacer()
	{

		require_once 'views/pedido/hacer.php';
	}

	public function add()
	{
		if (isset($_SESSION['identity'])) {
			$usuario_id = $_SESSION['identity']->id;
			$provincia = isset($_POST['provincia']) ? $_POST['provincia'] : false;
			$localidad = isset($_POST['localidad']) ? $_POST['localidad'] : false;
			$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;

			$stats = Utils::statsCarrito();
			$coste = $stats['total'];

			if ($provincia && $localidad && $direccion) {
				// Guardar datos en bd
				$pedido = new Pedido();
				$pedido->setUsuario_id($usuario_id);
				$pedido->setProvincia($provincia);
				$pedido->setLocalidad($localidad);
				$pedido->setDireccion($direccion);
				$pedido->setCoste($coste);

				$save = $pedido->save();

				// Guardar linea pedido
				$save_linea = $pedido->save_linea();

				if ($save && $save_linea) {
					$_SESSION['pedido'] = "complete";
				} else {
					$_SESSION['pedido'] = "failed";
				}
			} else {
				$_SESSION['pedido'] = "failed";
			}

			header("Location:" . base_url . 'pedido/confirmado');
		} else {
			// Redigir al index
			header("Location:" . base_url);
		}
	}

	public function confirmado()
	{
		if (isset($_SESSION['identity'])) {
			$identity = $_SESSION['identity'];
			$pedido = new Pedido();
			$pedido->setUsuario_id($identity->id);

			$pedido = $pedido->getOneByUser();

			$pedido_productos = new Pedido();
			$productos = $pedido_productos->getProductosByPedido($pedido->id);
			unset($_SESSION['carrito']);
		}
		require_once 'views/pedido/confirmado.php';
	}

	public function mis_pedidos()
	{
		Utils::isIdentity();
		$usuario_id = $_SESSION['identity']->id;
		$pedido = new Pedido();

		// Sacar los pedidos del usuario
		$pedido->setUsuario_id($usuario_id);
		$pedidos = $pedido->getAllByUser();

		require_once 'views/pedido/mis_pedidos.php';
	}

	public function detalle()
	{
		Utils::isIdentity();

		if (isset($_GET['id'])) {
			$id = $_GET['id'];

			// Sacar el pedido
			$pedido = new Pedido();
			$pedido->setId($id);
			$pedido = $pedido->getOne();

			//Sacar datos del usuario
			$usuario = new Usuario();
			$usuario->setId($pedido->usuario_id);
			$usuario = $usuario->getOne();

			// Sacar los poductos
			$pedido_productos = new Pedido();
			$productos = $pedido_productos->getProductosByPedido($id);

			require_once 'views/pedido/detalle.php';
		} else {
			header('Location:' . base_url . 'pedido/mis_pedidos');
		}
	}

	public function gestion()
	{
		Utils::isAdmin();
		$gestion = true;

		$pedido = new Pedido();
		$pedidos = $pedido->getAll();

		require_once 'views/pedido/mis_pedidos.php';
	}

	public function estado()
	{
		Utils::isAdmin();
		if (isset($_POST['pedido_id']) && isset($_POST['estado'])) {
			// Recoger datos form
			$id = $_POST['pedido_id'];
			$estado = $_POST['estado'];

			// Upadate del pedido
			$pedido = new Pedido();
			$pedido->setId($id);
			$pedido->setEstado($estado);
			$pedido->edit();

			header("Location:" . base_url . 'pedido/detalle&id=' . $id);
		} else {
			header("Location:" . base_url);
		}
	}

	// Generar PDFS
	public function albaran()
	{
		if (isset($_GET['id'])) {
			$id = $_GET['id'];

			$pedido = new Pedido();
			$pedido->setId($id);
			$pedido = $pedido->getOne();

			$usuario = new Usuario();
			$usuario->setId($pedido->usuario_id);
			$usuario = $usuario->getOne();

			$pedido_productos = new Pedido();
			$productos = $pedido_productos->getProductosByPedido($id);
		} else {
			header('Location:' . base_url . 'pedido/mis_pedidos');
		}


		//Modelo del PDF
		ob_start();
?>
		<table>
			<tr>
				<td>
					<h3>Datos del Cliente</h3>
					Id Usuario: <?= $usuario->id ?> <br />
					Nombre: <?= $usuario->nombre . " " . $usuario->apellidos ?> <br />
					Email: <?= $usuario->email ?> <br /><br />
				</td>

				<td>
					<h3>Dirección de envio</h3>
					Provincia: <?= $pedido->provincia ?> <br />
					Cuidad: <?= $pedido->localidad ?> <br />
					Direccion: <?= $pedido->direccion ?> <br /><br />
				</td>

				<td>
					<h3>Datos del pedido:</h3>
					Estado: <?= Utils::showStatus($pedido->estado) ?> <br />
					Fecha: <?= $pedido->fecha ?> a las <?= $pedido->hora ?> <br />
					Número de pedido: <?= $pedido->id ?> <br />
					Total a pagar: <?= $pedido->coste ?> $ <br />
				</td>
			</tr>
		</table>

		<table>
			<tr>
				<th>Nombre</th>
				<th>Precio</th>
				<th>Unidades</th>
			</tr>
			<?php while ($producto = $productos->fetch_object()) : ?>
				<tr>
					<td>
						<a href="<?= base_url ?>producto/ver&id=<?= $producto->id ?>"><?= $producto->nombre ?></a>
					</td>
					<td>
						<?= $producto->precio ?>
					</td>
					<td>
						<?= $producto->unidades ?>
					</td>
				</tr>
			<?php endwhile; ?>
		</table>
<?php
		$html = ob_get_contents();
		ob_end_clean();
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->WriteHTML($html);
		$mpdf->SetTitle('Pedido de Camisetas');
		$mpdf->Output();
	}
	// Fin Generar PDFS
}
