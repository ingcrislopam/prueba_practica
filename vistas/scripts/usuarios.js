var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function(e){
		guardaryeditar(e);
	});

	//Cargamos los items al select rol
	$.post("../ajax/usuarios.php?op=selectRoles", function(r){
		$("#id_rol").html(r);
		$('#id_rol').selectpicker('refresh');
	});
}

//Función limpiar
function limpiar(){
	$("#id_usuario").val("");
	$("#usuario").val("");
	$("#nombres").val("");
	$("#apellidos").val("");
	$("#clave").val("");
	$("#fecha_nacimiento").val("");
	$("#cedula").val("");
	$("#id_rol").val("");
}

//Función mostrar formulario
function mostrarform(flag){
	limpiar();
	if (flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled", false);
		$("#btnagregar").hide();
	}
	else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función Cancelar Form
function cancelarform(){
	limpiar();
	mostrarform(false);
}

//Función listar
function listar(){
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/usuarios.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

//Función para guardar o editar
function guardaryeditar(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/usuarios.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function(datos){
			bootbox.alert(datos);
			mostrarform(false);
			tabla.ajax.reload();
		}
	});
	limpiar();
}

//Función para mostrar registros por el id seleccionado
function mostrar(id_usuario){
	$.post("../ajax/usuarios.php?op=mostrar",{id_usuario : id_usuario}, function(data, status){
		data = JSON.parse(data);
		mostrarform(true);

		$("#id_usuario").val(data.id_usuario);
		$("#usuario").val(data.usuario);
		$("#nombres").val(data.nombres);
		$("#apellidos").val(data.apellidos);
		$("#clave").val(data.clave);
		$("#fecha_nacimiento").val(data.fecha_nacimiento);
		$("#cedula").val(data.cedula);
		$("#id_rol").val(data.id_rol);
		$('#id_rol').selectpicker('refresh');
	})
}

//Función para desactivar registros
function desactivar(id_usuario){
	bootbox.confirm("¿Está seguro de desactivar el usuario?", function(result){
		if(result){
			$.post("../ajax/usuarios.php?op=desactivar", {id_usuario : id_usuario}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

//Función para activar registros
function activar(id_usuario){
	bootbox.confirm("¿Está seguro de activar el usuario?", function(result){
		if(result){
			$.post("../ajax/usuarios.php?op=activar", {id_usuario : id_usuario}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

init();