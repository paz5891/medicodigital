<?php 
require_once "../model/Referencia.php";

$referencia=new Referencia();

$idreferencia=isset($_POST["idreferencia"])? limpiarCadena($_POST["idreferencia"]):"";
$idmedico=isset($_POST["idmedico"])? limpiarCadena($_POST["idmedico"]):"";
$idpaciente=isset($_POST["idpaciente"])? limpiarCadena($_POST["idpaciente"]):"";
$referir=isset($_POST["referir"])? limpiarCadena($_POST["referir"]):"";
$institucion=isset($_POST["institucion"])? limpiarCadena($_POST["institucion"]):"";

$motivo=isset($_POST["motivo"])? limpiarCadena($_POST["motivo"]):"";
$historial=isset($_POST["historial"])? limpiarCadena($_POST["historial"]):"";
$observaciones=isset($_POST["observaciones"])? limpiarCadena($_POST["observaciones"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idreferencia)){
			$rspta=$referencia->insertar($idmedico,$idpaciente,$referir,$institucion, $motivo, $historial, $observaciones);
			echo $rspta ? 1 : 2;
		}
		else {
			$rspta=$referencia->editar($idmedico,$idreferencia,$idpaciente,$referir,$institucion, $motivo, $historial, $observaciones);
			echo $rspta ? 3 : 4;
		}
	break;

	case 'desactivar':
		$rspta=$referencia->desactivar($idreferencia);
 		echo $rspta ? "Referencia Desactivada" : "Referencia no se puede desactivar";
	break;

	case 'activar':
		$rspta=$referencia->activar($idreferencia);
 		echo $rspta ? "Referencia activada" : "Referencia no se puede activar";
	break;

	case 'mostrar':
		$rspta=$referencia->mostrar($idreferencia);
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$referencia->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
			$url='../reportes/referencia.php?id=';
 			$data[]=array(
				"0"=>(($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idreferencia.')"><i class="fas fa-edit"></i></button>'.
				' <button class="btn btn-danger" onclick="desactivar('.$reg->idreferencia.')"><i class="far fa-times-circle"></i></button>':
				'<button class="btn btn-warning" onclick="mostrar('.$reg->idreferencia.')"><i class="fas fa-edit"></i></button>'.
				' <button class="btn btn-primary" onclick="activar('.$reg->idreferencia.')"><i class="fa fa-check"></i></button>').
				'<a target="_blank" href="'.$url.$reg->idreferencia.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
				"1"=>$reg->medico,
				"2"=>$reg->paciente,
 				"3"=>$reg->institucion,
 				"4"=>$reg->motivo,
 				"5"=>$reg->fecha,
 				"6"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
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

	case "selectMedico":
		require_once "../model/Medico.php";
		$medico = new Medico();

		$rspta = $medico->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idmedico . '>' . $reg->nombres . '</option>';
				}
	break;

    case "selectPaciente":
		require_once "../model/Paciente.php";
		$paciente = new Paciente();

		$rspta = $paciente->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idpaciente . '>' . $reg->nombres . '</option>';
				}
	break;

}
?>