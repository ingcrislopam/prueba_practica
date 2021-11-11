<?php
	//Incluimos inicialmente la conexión a la base de datos
	require "../config/Conexion.php";

	class Usuarios
	{
		//Implementamos nuestro constructor
		public function __construct()
		{
			
		}

		//Implementamos un método para insertar registros
		public function insertar($usuario, $nombres, $apellidos, $clave, $fecha_nacimiento, $cedula, $rol){
			$sql = "INSERT INTO morador (usuario, nombres, apellidos, clave, fecha_nacimiento, cedula, rol, estado) VALUES ('$usuario','$nombres','$apellidos','$clave','$fecha_nacimiento','$cedula','$rol','1')";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para editar registros
		public function editar($id_usuario ,$usuario, $nombres, $apellidos, $clave, $fecha_nacimiento, $cedula, $rol){
			$sql = "UPDATE usuarios SET usuario='$usuario', nombres='$nombres', apellidos='$apellidos', clave='$clave', fecha_nacimiento='$fecha_nacimiento', cedula='$cedula', rol='$rol' WHERE id_usuario='$id_usuario'";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para desactivar registros
		public function desactivar($id_usuario){
			$sql = "UPDATE usuarios SET estado='0' WHERE id_usuario='$id_usuario'";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para activar registros
		public function activar($id_usuario){
			$sql = "UPDATE usuarios SET estado='1' WHERE id_usuario='$id_usuario'";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para mostrar los datos de un registro a modificar
		public function mostrar($id_usuario){
			$sql = "SELECT * FROM usuarios WHERE id_usuario='$id_usuario'";
			return ejecutarConsultaSimpleFila($sql);
		}

		//Implementamos un método para listar los registros
		public function listar(){
			//$sql = "SELECT m.id_morador, m.id_vivienda, v.nombre as vivienda, m.id_parentesco, p.nombre as parentesco, m.cedula, m.nombres, m.apellidos, m.fecha_nacimiento, m.celular, m.estado FROM morador m INNER JOIN vivienda v ON m.id_vivienda=v.id_vivienda INNER JOIN parentesco p ON m.id_parentesco=p.id_parentesco";
			$sql = "SELECT * FROM usuarios";
			return ejecutarConsulta($sql);
		}
	}
?>