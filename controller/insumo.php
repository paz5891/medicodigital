<?php 
require_once "../model/Insumo.php";

$insumo=new Insumo();

$idinsumo=isset($_POST["idinsumo"])? limpiarCadena($_POST["idinsumo"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idinsumo)){
			$rspta=$insumo->insertar($nombre,$descripcion);
			echo $rspta ? 1 : 2;
		}
		else {
			$rspta=$insumo->editar($idinsumo,$nombre,$descripcion);
			echo $rspta ? 3 : 4;
		}
	break;

	case 'desactivar':
		$rspta=$insumo->desactivar($idinsumo);
 		echo $rspta ? "Insumo Desactivado" : "Insumo no se puede desactivar";
	break;

	case 'activar':
		$rspta=$insumo->activar($idinsumo);
 		echo $rspta ? "Insumo activado" : "Insumo no se puede activar";
	break;

	case 'mostrar':
		$rspta=$insumo->mostrar($idinsumo);
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$insumo->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idinsumo.')"><i class="fas fa-edit"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idinsumo.')"><i class="far fa-times-circle"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idinsumo.')"><i class="fas fa-edit"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idinsumo.')"><i class="fa fa-check"></i></button>',
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