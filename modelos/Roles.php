<?php
	//Incluimos inicialmente la conexión a la base de datos
	require "../config/Conexion.php";

	class Roles
	{
		//Implementamos nuestro constructor
		public function __construct()
		{
			
		}

		//Implementamos un método para insertar registros
		public function insertar($nombre){
			$sql = "INSERT INTO roles (nombre, estado) VALUES ('$nombre','1')";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para editar registros
		public function editar($id_rol, $nombre){
			$sql = "UPDATE roles SET nombre='$nombre' WHERE id_rol='$id_rol'";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para desactivar registros
		public function desactivar($id_rol){
			$sql = "UPDATE roles SET estado='0' WHERE id_rol='$id_rol'";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para activar registros
		public function activar($id_rol){
			$sql = "UPDATE roles SET estado='1' WHERE id_rol='$id_rol'";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para mostrar los datos de un registro a modificar
		public function mostrar($id_rol){
			$sql = "SELECT * FROM roles WHERE id_rol='$id_rol'";
			return ejecutarConsultaSimpleFila($sql);
		}

		//Implementamos un método para listar los registros
		public function listar(){
			$sql = "SELECT * FROM roles";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para listar los registros y mostrar en el select
		public function select(){
			$sql = "SELECT * FROM roles WHERE estado=1";
			return ejecutarConsulta($sql);
		}
	}
?>