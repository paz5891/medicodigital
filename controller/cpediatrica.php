<?php 
require_once "../model/Cpediatrica.php";

$cpediatrica=new Cpediatrica();

$idcpediatrica=isset($_POST["idcpediatrica"])? limpiarCadena($_POST["idcpediatrica"]):"";
$idpaciente=isset($_POST["idpaciente"])? limpiarCadena($_POST["idpaciente"]):"";
$idseguro=isset($_POST["idseguro"])? limpiarCadena($_POST["idseguro"]):"";
$mc=isset($_POST["mc"])? limpiarCadena($_POST["mc"]):"";
$historia=isset($_POST["historia"])? limpiarCadena($_POST["historia"]):"";
$peso=isset($_POST["peso"])? limpiarCadena($_POST["peso"]):"";
$estatura=isset($_POST["estatura"])? limpiarCadena($_POST["estatura"]):"";
$temperatura=isset($_POST["temperatura"])? limpiarCadena($_POST["temperatura"]):"";
$adecuacion=isset($_POST["adecuacion"])? limpiarCadena($_POST["adecuacion"]):"";
$pa=isset($_POST["pa"])? limpiarCadena($_POST["pa"]):"";
$fc=isset($_POST["fc"])? limpiarCadena($_POST["fc"]):"";
$fr=isset($_POST["fr"])? limpiarCadena($_POST["fr"]):"";

$examendental=isset($_POST["examendental"])? limpiarCadena($_POST["examendental"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$descripcionresexadiag=isset($_POST["descripcionresexadiag"])? limpiarCadena($_POST["descripcionresexadiag"]):"";

$ic=isset($_POST["ic"])? limpiarCadena($_POST["ic"]):"";
$tx=isset($_POST["tx"])? limpiarCadena($_POST["tx"]):"";
$ordenexadiag=isset($_POST["ordenexadiag"])? limpiarCadena($_POST["ordenexadiag"]):"";
$proximacita=isset($_POST["proximacita"])? limpiarCadena($_POST["proximacita"]):"";
$montoacobrar=isset($_POST["montoacobrar"])? limpiarCadena($_POST["montoacobrar"]):"";
$observaciones=isset($_POST["observaciones"])? limpiarCadena($_POST["observaciones"]):"";




switch ($_GET["op"]){
	case 'guardaryeditar':
		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "application/pdf")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/examendiagnosticopediatrica/" . $imagen);
			}
		}
		if (empty($idcpediatrica)){
			$rspta=$cpediatrica->insertar($idpaciente,$idseguro,$mc,$historia,$peso,$estatura, $temperatura, $adecuacion, $pa,$fc,$fr,$examendental, $imagen,$descripcionresexadiag,$ic,$tx,$ordenexadiag,$proximacita,$montoacobrar,$observaciones);
			echo $rspta ? 1 : 2;
		}
		else {
			$rspta=$cpediatrica->editar($idcpediatrica,$idpaciente,$idseguro,$mc,$historia,$peso,$estatura,$temperatura, $adecuacion, $pa,$fc,$fr,$examendental, $imagen,$descripcionresexadiag,$ic,$tx,$ordenexadiag,$proximacita,$montoacobrar,$observaciones);
			echo $rspta ? 3 : 4;
		}
	break;

	case 'desactivar':
		$rspta=$cpediatrica->desactivar($idcpediatrica);
 		echo $rspta ? "Consulta pediátrica  desactivada" : "Consulta pediátrica  no se puede desactivar";
	break;

	case 'activar':
		$rspta=$cpediatrica->activar($idcpediatrica);
 		echo $rspta ? "Consulta pediátrica  activada" : "Consulta pediátrica  no se puede activar";
	break;

	case 'mostrar':
		$rspta=$cpediatrica->mostrar($idcpediatrica);
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$cpediatrica->listar();
 		//Vamos a declarar un array
 		$data= Array();
		 $url = '../reportes/cpediatrica.php?id=';
 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
				"0" => (($reg->condicion) ? '<button class="btn btn-warning" onclick="mostrar(' . $reg->idcpediatrica . ')"><i class="fas fa-edit"></i></button>' .
				' <button class="btn btn-danger" onclick="desactivar(' . $reg->idcpediatrica . ')"><i class="far fa-times-circle"></i></button>' :
				'<button class="btn btn-warning" onclick="mostrar(' . $reg->idcpediatrica . ')"><i class="fas fa-edit"></i></button>' .
				' <button class="btn btn-primary" onclick="activar(' . $reg->idcpediatrica . ')"><i class="fa fa-check"></i></button>') .
				'<a target="_blank" href="' . $url . $reg->idcpediatrica . '"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
 				"1"=>$reg->paciente,
 				"2"=>$reg->mc,
                "3"=>$reg->montoacobrar,
                "4"=>$reg->fecha_reg,
				"5"=>"<a href='../files/examendiagnosticopediatrica/".$reg->resexadiag."' target='_blank'>Ver</a>",
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