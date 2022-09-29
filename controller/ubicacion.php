<?php 
require_once "../model/Ubicacion.php";

$ubicacion=new Ubicacion();

$idubicacion=isset($_POST["idubicacion"])? limpiarCadena($_POST["idubicacion"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idubicacion)){
			$rspta=$ubicacion->insertar($nombre,$descripcion);
			echo $rspta ? 1 : 2;
		}
		else {
			$rspta=$ubicacion->editar($idubicacion,$nombre,$descripcion);
			echo $rspta ? 3 : 4;
		}
	break;

	case 'desactivar':
		$rspta=$ubicacion->desactivar($idubicacion);
 		echo $rspta ? "Ubicación Desactivada" : "Ubicación no se puede desactivar";
	break;

	case 'activar':
		$rspta=$ubicacion->activar($idubicacion);
 		echo $rspta ? "Ubicación activada" : "Ubicación no se puede activar";
	break;

	case 'mostrar':
		$rspta=$ubicacion->mostrar($idubicacion);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$ubicacion->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
                "0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idubicacion.')"><i class="fas fa-edit"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->idubicacion.')"><i class="far fa-times-circle"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->idubicacion.')"><i class="fas fa-edit"></i></button>'.
                ' <button class="btn btn-primary" onclick="activar('.$reg->idubicacion.')"><i class="fa fa-check"></i></button>',
 			"1"=>$reg->nombre,
 				"2"=>$reg->descripcion,
 				"3"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
}
?>