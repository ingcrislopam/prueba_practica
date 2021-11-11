<?php
	require_once "../modelos/Usuarios.php";
	$usuarios = new Usuarios();

	$id_usuario = isset($_POST["id_usuario"])? limpiarCadena($_POST["id_usuario"]): "";
	$usuario = isset($_POST["usuario"])? limpiarCadena($_POST["usuario"]): "";
	$nombres = isset($_POST["nombres"])? limpiarCadena($_POST["nombres"]): "";
	$apellidos = isset($_POST["apellidos"])? limpiarCadena($_POST["apellidos"]): "";
	$clave = isset($_POST["clave"])? limpiarCadena($_POST["clave"]): "";
	$fecha_nacimiento = isset($_POST["fecha_nacimiento"])? limpiarCadena($_POST["fecha_nacimiento"]): "";
	$cedula = isset($_POST["cedula"])? limpiarCadena($_POST["cedula"]): "";
	$rol = isset($_POST["rol"])? limpiarCadena($_POST["rol"]): "";

	switch ($_GET["op"]){
		case 'guardaryeditar':
			if (empty($id_usuario)){
				$rspta=$usuarios->insertar($usuario, $nombres, $apellidos, $clave, $fecha_nacimiento, $cedula, $rol);
				echo $rspta ? "Usuario registrado" : "Usuario no se pudo registrar";
			}
			else {
				$rspta=$usuarios->editar($id_usuario ,$usuario, $nombres, $apellidos, $clave, $fecha_nacimiento, $cedula, $rol);
				echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
			}
		break;

		case 'desactivar':
			$rspta = $usuarios->desactivar($id_usuario);
			echo $rspta ? "Usuario desactivado" : "Usuario no se puede desactivar";
		break;

		case 'activar':
			$rspta = $usuarios->activar($id_usuario);
			echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
		break;

		case 'mostrar':
			$rspta = $usuarios->mostrar($id_usuario);
			//Codificar el resultado utilizando json
			echo json_encode($rspta);
		break;

		case 'listar':
			$rspta = $usuarios->listar();
			//Vamos a declarar un array
			$data = Array();
			while ($reg = $rspta->fetch_object()) {
				$data[] = array(
					"0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_usuario.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-danger" onclick="desactivar('.$reg->id_usuario.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning" onclick="mostrar('.$reg->id_usuario.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-primary" onclick="activar('.$reg->id_usuario.')"><i class="fa fa-check"></i></button>',
					"1"=>$reg->usuario,
					"2"=>$reg->nombres,
					"3"=>$reg->apellidos,
					"4"=>$reg->clave,
					"5"=>$reg->fecha_nacimiento,
					"6"=>$reg->cedula,
					"7"=>$reg->rol,
					"8"=>($reg->estado)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
				);
			}
			$results = array(
				"sEcho"=>1, //Información para el datatables
				"iTotalRecords"=>count($data), //Enviamos el total de registros al datatable
				"iTotalDisplayRecords"=>count($data), //Enviamos el total de registros a visualizar
				"aaData"=>$data
			);
			echo json_encode($results);
		break;

		case "selectRoles":
			require_once "../modelos/Roles.php";
			$roles = new Roles();
			$rspta = $roles->select();

			while ($reg = $rspta->fetch_object()) {
				echo '<option value=' . $reg->id_rol . '>' . $reg->nombre . '</option>';
			}
		break;
	}
?>