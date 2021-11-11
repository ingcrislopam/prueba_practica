<?php
	require_once "../modelos/Roles.php";
	$roles = new Roles();

	$id_rol = isset($_POST["id_rol"])? limpiarCadena($_POST["id_rol"]): "";
	$nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]): ""; 

	switch ($_GET["op"]){
		case 'guardaryeditar':
			if (empty($id_rol)){
				$rspta=$roles->insertar($nombre);
				echo $rspta ? "Rol registrado" : "Rol no se pudo registrar";
			}
			else {
				$rspta=$roles->editar($id_rol,$nombre);
				echo $rspta ? "Rol actualizado" : "Rol no se pudo actualizar";
			}
		break;

		case 'desactivar':
			$rspta = $roles->desactivar($id_rol);
			echo $rspta ? "Rol desactivado" : "Rol no se puede desactivar";
		break;

		case 'activar':
			$rspta = $roles->activar($id_rol);
			echo $rspta ? "Rol activado" : "Rol no se puede activar";
		break;

		case 'mostrar':
			$rspta = $rol->mostrar($id_rol);
			//Codificar el resultado utilizando json
			echo json_encode($rspta);
		break;

		case 'listar':
			$rspta = $roles->listar();
			//Vamos a declarar un array
			$data = Array();
			while ($reg = $rspta->fetch_object()) {
				$data[] = array(
					"0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_rol.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-danger" onclick="desactivar('.$reg->id_rol.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning" onclick="mostrar('.$reg->id_rol.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-primary" onclick="activar('.$reg->id_rol.')"><i class="fa fa-check"></i></button>',
					"1"=>$reg->nombre,
					"2"=>($reg->estado)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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
	}
?>