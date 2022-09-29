<?php 
require_once "../model/Seguro.php";

$seguro=new Seguro();

$idseguro=isset($_POST["idseguro"])? limpiarCadena($_POST["idseguro"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idseguro)){
			$rspta=$seguro->insertar($nombre,$descripcion);
			echo $rspta ? 1 : 2;
		}
		else {
			$rspta=$seguro->editar($idseguro,$nombre,$descripcion);
			echo $rspta ? 3 : 4;
		}
	break;

	case 'desactivar':
		$rspta=$seguro->desactivar($idseguro);
 		echo $rspta ? "Seguro Desactivada" : "Seguro no se puede desactivar";
	break;

	case 'activar':
		$rspta=$seguro->activar($idseguro);
 		echo $rspta ? "Seguro activada" : "Seguro no se puede activar";
	break;

	case 'mostrar':
		$rspta=$seguro->mostrar($idseguro);
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$seguro->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idseguro.')"><i class="fas fa-edit"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idseguro.')"><i class="far fa-times-circle"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idseguro.')"><i class="fas fa-edit"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idseguro.')"><i class="fa fa-check"></i></button>',
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