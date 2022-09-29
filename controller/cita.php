<?php 
require_once "../model/Cita.php";

$cita=new Cita();

$idcita=isset($_POST["idcita"])? limpiarCadena($_POST["idcita"]):"";
$idseguro=isset($_POST["idseguro"])? limpiarCadena($_POST["idseguro"]):"";
$idmedico=isset($_POST["idmedico"])? limpiarCadena($_POST["idmedico"]):"";
$tipocita=isset($_POST["tipocita"])? limpiarCadena($_POST["tipocita"]):"";
$pacienteovisitador=isset($_POST["pacienteovisitador"])? limpiarCadena($_POST["pacienteovisitador"]):"";

$visitador=isset($_POST["visitador"])? limpiarCadena($_POST["visitador"]):"";
$asunto=isset($_POST["asunto"])? limpiarCadena($_POST["asunto"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
$hora=isset($_POST["hora"])? limpiarCadena($_POST["hora"]):"";
$estadocita=isset($_POST["estadocita"])? limpiarCadena($_POST["estadocita"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idcita)){
			$rspta=$cita->insertar($idseguro,$idmedico,$tipocita,$pacienteovisitador,$visitador, $asunto, $telefono, $fecha,$hora, $estadocita);
			echo $rspta ? 1 : 2;
		}
		else {
			$rspta=$cita->editar($idcita,$idseguro,$idmedico,$tipocita,$pacienteovisitador,$visitador, $asunto, $telefono, $fecha, $hora, $estadocita);
			echo $rspta ? 3 : 4;
		}
	break;

	case 'desactivar':
		$rspta=$cita->desactivar($idcita);
 		echo $rspta ? "Cita Desactivada" : "Cita no se puede desactivar";
	break;

	case 'activar':
		$rspta=$cita->activar($idcita);
 		echo $rspta ? "Cita activada" : "Cita no se puede activar";
	break;

	case 'mostrar':
		$rspta=$cita->mostrar($idcita);
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$cita->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
				"0"=>(($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idcita.')"><i class="fas fa-edit"></i></button>'.
				' <button class="btn btn-danger" onclick="desactivar('.$reg->idcita.')"><i class="far fa-times-circle"></i></button>':
				'<button class="btn btn-warning" onclick="mostrar('.$reg->idcita.')"><i class="fas fa-edit"></i></button>'.
				' <button class="btn btn-primary" onclick="activar('.$reg->idcita.')"><i class="fa fa-check"></i></button>'),
				"1"=>$reg->medico,
				"2"=>$reg->seguro,
				"3"=>$reg->tipocita,
 				"4"=>$reg->paciente,
 				"5"=>$reg->visitador,
 				"6"=>$reg->asunto,
 				"7"=>$reg->telefono,
 				"8"=>$reg->horariocitaunica,
 				"9"=>$reg->estado
				
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


    case "selectSeguro":
		require_once "../model/Seguro.php";
		$seguro = new Seguro();

		$rspta = $seguro->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idseguro . '>' . $reg->nombre . '</option>';
				}
	break;

}
?>