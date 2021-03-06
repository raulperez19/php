<?php
require_once 'models/Producto.php';

class productoController
{

	public function index()
	{
		$db = Database::connect();
		$producto = new Producto();
		$productosPag = 6;

		$pagina = 1;
		if (isset($_GET["pagina"])) {
			$pagina = $_GET["pagina"];
		}
		$limit = $productosPag;
		$offset = ($pagina - 1) * $productosPag;
		$sentencia = $db->query("SELECT count(*) AS conteo FROM productos");
		$conteo = $sentencia->fetch_object()->conteo;
		$paginas = ceil($conteo / $productosPag);
		$productos = $producto->getPaginacion($limit, $offset);

		// renderizar vista
		require_once 'views/producto/destacados.php';
	}

	public function ver()
	{
		if (isset($_GET['id'])) {
			$id = $_GET['id'];

			$producto = new Producto();
			$producto->setId($id);

			$product = $producto->getOne();
		}
		require_once 'views/producto/ver.php';
	}

	public function gestion()
	{
		Utils::isAdmin();

		$producto = new Producto();
		$productos = $producto->getAll();

		// Gestión de productos
		$total_Ventas = $producto->getTotalVentas();
		$mas_Vendido = $producto->getMasVendido();
		$sin_Ventas = $producto->getSinVentas();
		$sin_Stock = $producto->getSinStock();

		require_once 'views/producto/gestion.php';
	}

	public function crear()
	{
		Utils::isAdmin();
		require_once 'views/producto/crear.php';
	}

	public function save()
	{
		Utils::isAdmin();
		if (isset($_POST)) {
			$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
			$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
			$precio = isset($_POST['precio']) ? $_POST['precio'] : false;
			$stock = isset($_POST['stock']) ? $_POST['stock'] : false;
			$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : false;
			$oferta = isset($_POST['oferta']) ? $_POST['oferta'] : false;
			// $imagen = isset($_POST['imagen']) ? $_POST['imagen'] : false;

			if ($nombre && $descripcion && $precio && $stock && $oferta && $categoria) {
				$producto = new Producto();
				$producto->setNombre($nombre);
				$producto->setDescripcion($descripcion);
				$producto->setPrecio($precio);
				$producto->setStock($stock);
				$producto->setOferta($oferta);
				$producto->setCategoria_id($categoria);


				// Guardar la imagen
				if (isset($_FILES['imagen'])) {
					$file = $_FILES['imagen'];
					$filename = $file['name'];
					$mimetype = $file['type'];

					if ($mimetype == "image/jpg" || $mimetype == 'image/jpeg' || $mimetype == 'image/png' || $mimetype == 'image/gif') {

						if (!is_dir('uploads/images')) {
							mkdir('uploads/images', 0777, true);
						}

						$producto->setImagen($filename);
						move_uploaded_file($file['tmp_name'], 'uploads/images/' . $filename);
					}
				}

				if (isset($_GET['id'])) {
					$id = $_GET['id'];
					$producto->setId($id);

					$save = $producto->edit();
				} else {
					$save = $producto->save();
				}

				if ($save) {
					$_SESSION['producto'] = "complete";
				} else {
					$_SESSION['producto'] = "failed";
				}
			} else {
				$_SESSION['producto'] = "failed";
			}
		} else {
			$_SESSION['producto'] = "failed";
		}
		header('Location:' . base_url . 'Producto/gestion');
	}

	public function editar()
	{
		Utils::isAdmin();
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$edit = true;

			$producto = new Producto();
			$producto->setId($id);

			$pro = $producto->getOne();

			require_once 'views/producto/crear.php';
		} else {
			header('Location:' . base_url . 'Producto/gestion');
		}
	}

	public function eliminar()
	{
		Utils::isAdmin();

		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$producto = new Producto();
			$producto->setId($id);

			$delete = $producto->delete();
			if ($delete) {
				$_SESSION['delete'] = 'complete';
			} else {
				$_SESSION['delete'] = 'failed';
			}
		} else {
			$_SESSION['delete'] = 'failed';
		}

		header('Location:' . base_url . 'Producto/gestion');
	}
}
