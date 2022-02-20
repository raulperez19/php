<?php

class Categoria{
	private $id;
	private $nombre;
	private $db;
	//Gestionar categorias
	private $valor_almacen;
	private $totalstock;
	
	public function __construct() {
		$this->db = Database::connect();
	}
	
	function getId() {
		return $this->id;
	}

	function getNombre() {
		return $this->nombre;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setNombre($nombre) {
		$this->nombre = $this->db->real_escape_string($nombre);
	}

	public function getAll(){
		$categorias = $this->db->query("SELECT * , (SELECT sum(stock*precio) FROM productos WHERE categoria_id = c.id) AS 'valor_almacen' FROM categorias c ORDER BY id DESC ");
		return $categorias;
	}
	
	public function getOne(){
		$categoria = $this->db->query("SELECT * FROM categorias WHERE id={$this->getId()}");
		return $categoria->fetch_object();
	}

	public function totalstock($id){
		$nprod = $this->db->query("SELECT COUNT(id) as 'num' FROM productos WHERE categoria_id = " .$id."");
		$res = $nprod->fetch_array()[0];
		return $res;
	}
	
	public function save(){
		if($this->getId() != null){
			$sql = "UPDATE categorias SET nombre='{$this->getNombre()}' WHERE id='{$this->getId()}';";
		}else{
			$sql = "INSERT INTO categorias VALUES(NULL, '{$this->getNombre()}');";
		}
		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
	
	// Gestion de Categorias
	public function validarAlmacen(){
		$control = false;
		$query =  $this->db->query("SELECT id FROM productos WHERE categoria_id = '{$this->getId()}';");
		if($query->num_rows == 0){
			$control = true;
		}
		return $control;
	}

	public function borrarCategoria(){
		$sql = "DELETE FROM categorias WHERE id={$this->id}";
		$delete = $this->db->query($sql);
		
		$result = false;
		if($delete){
			$result = true;
		}
		return $result;
	}
	// Fin 
}