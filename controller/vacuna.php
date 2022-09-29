<?php 
require_once "../model/Vacuna.php";

$vacuna = new Vacuna();

$idvacuna=isset($_POST["idvacuna"])? limpiarCadena($_POST["idvacuna"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idvacuna)){
			$rspta=$vacuna->insertar($nombre,$descripcion);
			echo $rspta ? 1 : 2;
		}
		else {
			$rspta=$vacuna->editar($idvacuna,$nombre,$descripcion);
			echo $rspta ? 3 : 4;
		}
	break;

	case 'desactivar':
		$rspta=$vacuna->desactivar($idvacuna);
 		echo $rspta ? "vacuna Desactivada" : "vacuna no se puede desactivar";
	break;

	case 'activar':
		$rspta=$vacuna->activar($idvacuna);
 		echo $rspta ? "vacuna activada" : "vacuna no se puede activar";
	break;

	case 'mostrar':
		$rspta=$vacuna->mostrar($idvacuna);
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$vacuna->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idvacuna.')"><i class="fas fa-edit"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idvacuna.')"><i class="far fa-times-circle"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idvacuna.')"><i class="fas fa-edit"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idvacuna.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->descripcion,
 				"3"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, 
 			"iTotalRecords"=>count($data), 
 			"iTotalDisplayRecords"=>count($data), 
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

}
?>