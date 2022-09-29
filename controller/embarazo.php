<?php 
require_once "../model/Embarazo.php";

$embarazo=new Embarazo();

$idembarazo=isset($_POST["idembarazo"])? limpiarCadena($_POST["idembarazo"]):"";
$idpaciente=isset($_POST["idpaciente"])? limpiarCadena($_POST["idpaciente"]):"";

$edadgestaini=isset($_POST["edadgestaini"])? limpiarCadena($_POST["edadgestaini"]):"";
$edadgestapor=isset($_POST["edadgestapor"])? limpiarCadena($_POST["edadgestapor"]):"";
$fpp=isset($_POST["fpp"])? limpiarCadena($_POST["fpp"]):"";
$estadogesta=isset($_POST["estadogesta"])? limpiarCadena($_POST["estadogesta"]):"";
$detallesestado=isset($_POST["detallesestado"])? limpiarCadena($_POST["detallesestado"]):"";
$nivelriesgo=isset($_POST["nivelriesgo"])? limpiarCadena($_POST["nivelriesgo"]):"";
$observaciones=isset($_POST["observaciones"])? limpiarCadena($_POST["observaciones"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idembarazo)){
			$rspta=$embarazo->insertar($idpaciente,$edadgestaini,$edadgestapor,$fpp,$estadogesta,$detallesestado,$nivelriesgo,$observaciones);
			echo $rspta ? 1 : 2;
		}
		else {
			$rspta=$embarazo->editar($idembarazo,$idpaciente,$edadgestaini,$edadgestapor,$fpp,$estadogesta,$detallesestado,$nivelriesgo,$observaciones);
			echo $rspta ? 3 : 4;
		}
	break;

	case 'desactivar':
		$rspta=$embarazo->desactivar($idembarazo);
 		echo $rspta ? "Embarazo desactivado" : "Embarazo no se puede desactivar";
	break;

	case 'activar':
		$rspta=$embarazo->activar($idembarazo);
 		echo $rspta ? "Embarazo activada" : "Embarazo no se puede activar";
	break;

	case 'mostrar':
		$rspta=$embarazo->mostrar($idembarazo);
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$embarazo->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){

			$url='../reportes/embarazo.php?id=';
 			$data[]=array(
 				"0"=>(($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idembarazo.')"><i class="fas fa-edit"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idembarazo.')"><i class="far fa-times-circle"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idembarazo.')"><i class="fas fa-edit"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idembarazo.')"><i class="fa fa-check"></i></button>').
					 '<a target="_blank" href="'.$url.$reg->idembarazo.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
 				"1"=>$reg->nombres,
 				"2"=>$reg->edadgestaini,
                "3"=>$reg->edadgestapor,
                "4"=>$reg->fpp,
                "5"=>$reg->fech_reg,
 				"6"=>($reg->condicion)?'<span class="label bg-green">En proceso</span>':
 				'<span class="label bg-red">Finalizado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, 
 			"iTotalRecords"=>count($data), 
 			"iTotalDisplayRecords"=>count($data), 
 			"aaData"=>$data);
 		echo json_encode($results);

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
    case "selectPacienteEmbarazo":
		require_once "../model/Paciente.php";
		$paciente = new Paciente();

		$rspta = $paciente->selectPacienteEmbarazo();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idpaciente . '>' . $reg->nombres . '</option>';
				}
	break;
}
?>