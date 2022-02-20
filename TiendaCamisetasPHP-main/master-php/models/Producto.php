<?php

class Producto
{
	private $id;
	private $categoria_id;
	private $nombre;
	private $descripcion;
	private $precio;
	private $stock;
	private $oferta;
	private $fecha;
	private $imagen;

	private $db;

	public function __construct()
	{
		$this->db = Database::connect();
	}

	function getId()
	{
		return $this->id;
	}

	function getCategoria_id()
	{
		return $this->categoria_id;
	}

	function getNombre()
	{
		return $this->nombre;
	}

	function getDescripcion()
	{
		return $this->descripcion;
	}

	function getPrecio()
	{
		return $this->precio;
	}

	function getStock()
	{
		return $this->stock;
	}

	function getOferta()
	{
		return $this->oferta;
	}

	function getFecha()
	{
		return $this->fecha;
	}

	function getImagen()
	{
		return $this->imagen;
	}

	function setId($id)
	{
		$this->id = $id;
	}

	function setCategoria_id($categoria_id)
	{
		$this->categoria_id = $categoria_id;
	}

	function setNombre($nombre)
	{
		$this->nombre = $this->db->real_escape_string($nombre);
	}

	function setDescripcion($descripcion)
	{
		$this->descripcion = $this->db->real_escape_string($descripcion);
	}

	function setPrecio($precio)
	{
		$this->precio = $this->db->real_escape_string($precio);
	}

	function setStock($stock)
	{
		$this->stock = $this->db->real_escape_string($stock);
	}

	function setOferta($oferta)
	{
		$this->oferta = $this->db->real_escape_string($oferta);
	}

	function setFecha($fecha)
	{
		$this->fecha = $fecha;
	}

	function setImagen($imagen)
	{
		$this->imagen = $imagen;
	}

	public function getAll()
	{
		$productos = $this->db->query("SELECT * FROM productos ORDER BY id DESC");
		return $productos;
	}

	public function getAllCategory()
	{
		$sql = "SELECT p.*, c.nombre AS 'catnombre' FROM productos p "
			. "INNER JOIN categorias c ON c.id = p.categoria_id "
			. "WHERE p.categoria_id = {$this->getCategoria_id()} "
			. "ORDER BY id DESC";
		$productos = $this->db->query($sql);
		return $productos;
	}

	public function getRandom($limit)
	{
		$productos = $this->db->query("SELECT * FROM productos ORDER BY RAND() LIMIT $limit");
		return $productos;
	}

	public function getOne()
	{
		$producto = $this->db->query("SELECT * FROM productos WHERE id = {$this->getId()}");
		return $producto->fetch_object();
	}

	public function save()
	{
		$sql = "INSERT INTO productos VALUES(NULL, {$this->getCategoria_id()}, '{$this->getNombre()}', '{$this->getDescripcion()}', {$this->getPrecio()}, {$this->getStock()}, null, CURDATE(), '{$this->getImagen()}');";
		$save = $this->db->query($sql);

		$result = false;
		if ($save) {
			$result = true;
		}
		return $result;
	}

	public function edit()
	{
		$sql = "UPDATE productos SET nombre='{$this->getNombre()}', descripcion='{$this->getDescripcion()}', precio={$this->getPrecio()}, stock={$this->getStock()}, oferta='{$this->getOferta()}', categoria_id={$this->getCategoria_id()}  ";

		if ($this->getImagen() != null) {
			$sql .= ", imagen='{$this->getImagen()}'";
		}

		$sql .= " WHERE id={$this->id};";


		$save = $this->db->query($sql);

		$result = false;
		if ($save) {
			$result = true;
		}
		return $result;
	}

	public function delete()
	{
		$sql = "DELETE FROM productos WHERE id={$this->id}";
		$delete = $this->db->query($sql);

		$result = false;
		if ($delete) {
			$result = true;
		}
		return $result;
	}

	//Funciones gestión de productos

	//Todas las ventas
	public function getTotalVentas()
	{
		$sql = $this->db->query("SELECT SUM(unidades) FROM lineas_pedidos");
		$total_Ventas = $sql->fetch_assoc();
		return $total_Ventas['SUM(unidades)'];
	}

	//El mas vendido
	public function getMasVendido()
	{
		$sql = "SELECT productos.nombre as nombre, (SELECT sum(unidades) FROM lineas_pedidos WHERE productos.id = lineas_pedidos.producto_id) AS 'cantidad_unidades' FROM productos ORDER by cantidad_unidades DESC LIMIT 1;";
		$mas_Vendido = $this->db->query($sql);
		return $mas_Vendido;
	}
	//No se ha vendido nada
	public function getSinVentas()
	{
		$sin_Ventas = $this->db->query("SELECT * FROM productos WHERE `id` NOT IN (SELECT `producto_id` from lineas_pedidos) ");
		return $sin_Ventas;
	}
	//No hay stock
	public function getSinStock()
	{
		$sin_Stock = $this->db->query("SELECT * FROM productos WHERE stock=0");
		return $sin_Stock;
	}

	//Obtenemos la paginacion
	public function getPaginacion($limit, $offset)
	{
		$productos = $this->db->query("SELECT * FROM productos LIMIT $limit OFFSET $offset");
		return $productos;
	}
}
