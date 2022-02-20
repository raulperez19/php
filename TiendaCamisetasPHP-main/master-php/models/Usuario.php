<?php

class Usuario
{
	private $id;
	private $nombre;
	private $apellidos;
	private $email;
	private $password;
	private $rol;
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

	function getNombre()
	{
		return $this->nombre;
	}

	function getApellidos()
	{
		return $this->apellidos;
	}

	function getEmail()
	{
		return $this->email;
	}

	function getPassword()
	{
		return password_hash($this->db->real_escape_string($this->password), PASSWORD_BCRYPT, ['cost' => 4]);
	}

	function getRol()
	{
		return $this->rol;
	}

	function getImagen()
	{
		return $this->imagen;
	}

	function setId($id)
	{
		$this->id = $id;
	}

	function setNombre($nombre)
	{
		$this->nombre = $this->db->real_escape_string($nombre);
	}

	function setApellidos($apellidos)
	{
		$this->apellidos = $this->db->real_escape_string($apellidos);
	}

	function setEmail($email)
	{
		$this->email = $this->db->real_escape_string($email);
	}

	function setPassword($password)
	{
		$this->password = $password;
	}

	function setRol($rol)
	{
		$this->rol = $rol;
	}

	function setImagen($imagen)
	{
		$this->imagen = $imagen;
	}

	public function save()
	{

		$sql = "INSERT INTO usuarios VALUES(NULL, '{$this->getNombre()}', '{$this->getApellidos()}', '{$this->getEmail()}', '{$this->getPassword()}', 'user', null);";
		$save = $this->db->query($sql);
		$result = false;
		if ($save) {
			$result = true;
		}
		return $result;
	}

	public function login()
	{

		$result = false;
		$email = $this->email;
		$password = $this->password;

		// Comprobar si existe el usuario
		$sql = "SELECT * FROM usuarios WHERE email = '$email'";
		$login = $this->db->query($sql);


		if ($login && $login->num_rows == 1) {
			$usuario = $login->fetch_object();

			// Verificar la contraseña
			$verify = password_verify($password, $usuario->password);

			if ($verify) {
				$result = $usuario;
			}
		}

		return $result;
	}

	//Funcion para mostrar todos los datos
	public function getAll()
	{
		$usuarios = $this->db->query("SELECT u.id, nombre, apellidos, email, rol, 
		(SELECT sum(coste) FROM `pedidos` WHERE usuario_id = u.id) AS 'Coste_Pedidos', 
		(SELECT count(*) FROM `pedidos` WHERE usuario_id = u.id AND estado = 'confirm') AS 'Pendientes' FROM `usuarios` u ORDER by id DESC ");
		return $usuarios;
	}

	//Funcion para cambiar datos
	public function edit()
	{
		$sql = "UPDATE usuarios SET nombre='{$this->getNombre()}', 
		apellidos='{$this->getApellidos()}',
		email='{$this->getEmail()}', 
		password='{$this->getPassword()}', 
		rol='{$this->getRol()}', 
		imagen='{$this->getImagen()}' ";

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

	//Funcion para borrar datos
	public function delete()
	{
		$sql2 = "DELETE FROM pedidos WHERE usuario_id = {$this->id}";
		$sql3 = "DELETE FROM usuarios WHERE id={$this->id}";

		$this->db->query($sql2);
		$delete = $this->db->query($sql3);

		$result = false;
		if ($delete) {
			$result = true;
		}
		return $result;
	}

	//Funcion para ver los pedidos del usuario
	public function checkPedidos()
	{
		$control = false;
		$query =  $this->db->query("SELECT * FROM `pedidos` WHERE usuario_id = '{$this->getId()}' AND estado = 'sended';");
		if ($query->num_rows == 0) {
			$control = true;
		}
		return $control;
	}

	//Funcion para obtener usuarios
	public function getOne()
	{
		$sql = "SELECT * FROM usuarios WHERE id = ?";

		$stmt = $this->db->prepare($sql);
		$id = $this->getId();
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();

		return $result->fetch_object();
	}

	//Funcion para revisar el correo del usuario
	public function checkEmail($email): bool
	{
		$query = $this->db->query("SELECT * FROM `usuarios` WHERE email = '{$email}'");

		if ($query->num_rows > 0) {
			return false;
		} else {
			return true;
		}
	}

	//Funcion para actualizar usuarios
	public function updateUsuario($arrMod)
	{

		$textSQL = "UPDATE usuarios SET ";

		foreach ($arrMod as $attribute => $value) {
			$textSQL .= $attribute . " = '" . $value . "', ";
		}
		$textSQL = substr($textSQL, 0, -2);

		$textSQL .= " WHERE id = " . $this->getId();

		$save = $this->db->query($textSQL);

		$result = false;
		if ($save) {
			$result = true;
		}
		return $result;
	}
}
