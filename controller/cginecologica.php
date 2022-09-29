<?php 
require_once "../model/Cginecologica.php";

$cginecologica=new Cginecologica();

$idcginecologica=isset($_POST["idcginecologica"])? limpiarCadena($_POST["idcginecologica"]):"";
$idpaciente=isset($_POST["idpaciente"])? limpiarCadena($_POST["idpaciente"]):"";
$idseguro=isset($_POST["idseguro"])? limpiarCadena($_POST["idseguro"]):"";
$mc=isset($_POST["mc"])? limpiarCadena($_POST["mc"]):"";
$historia=isset($_POST["historia"])? limpiarCadena($_POST["historia"]):"";
$peso=isset($_POST["peso"])? limpiarCadena($_POST["peso"]):"";
$fur=isset($_POST["fur"])? limpiarCadena($_POST["fur"]):"";
$temperatura=isset($_POST["temperatura"])? limpiarCadena($_POST["temperatura"]):"";
$pa=isset($_POST["pa"])? limpiarCadena($_POST["pa"]):"";
$fc=isset($_POST["fc"])? limpiarCadena($_POST["fc"]):"";
$fr=isset($_POST["fr"])? limpiarCadena($_POST["fr"]):"";
$examenmamas=isset($_POST["examenmamas"])? limpiarCadena($_POST["examenmamas"]):"";
$examenginec=isset($_POST["examenginec"])? limpiarCadena($_POST["examenginec"]):"";
$examenfisico=isset($_POST["examenfisico"])? limpiarCadena($_POST["examenfisico"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$descripcionresexadiag=isset($_POST["descripcionresexadiag"])? limpiarCadena($_POST["descripcionresexadiag"]):"";
$usgpelv=isset($_POST["usgpelv"])? limpiarCadena($_POST["usgpelv"]):"";
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
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/examendiagnosticoginecologica/" . $imagen);
			}
		}
		if (empty($idcginecologica)){
			$rspta=$cginecologica->insertar($idpaciente,$idseguro,$mc,$historia,$peso,$fur, $temperatura,$pa,$fc,$fr,$examenmamas,$examenginec,$examenfisico, $imagen,$descripcionresexadiag,$usgpelv,$ic,$tx,$ordenexadiag,$proximacita,$montoacobrar,$observaciones);
			echo $rspta ? 1 : 2;
		}
		else {
			$rspta=$cginecologica->editar($idcginecologica,$idpaciente,$idseguro,$mc,$historia,$peso,$fur,$temperatura,$pa,$fc,$fr,$examenmamas, $examenginec, $examenfisico, $imagen,$descripcionresexadiag,$usgpelv,$ic,$tx,$ordenexadiag,$proximacita,$montoacobrar,$observaciones);
			echo $rspta ? 3 : 4;
		}
	break;

	case 'desactivar':
		$rspta=$cginecologica->desactivar($idcginecologica);
 		echo $rspta ? "Consulta ginecológica desactivada" : "Consulta ginecológica no se puede desactivar";
	break;

	case 'activar':
		$rspta=$cginecologica->activar($idcginecologica);
 		echo $rspta ? "Consulta ginecológica activada" : "Consulta ginecológica no se puede activar";
	break;

	case 'mostrar':
		$rspta=$cginecologica->mostrar($idcginecologica);
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$cginecologica->listar();
 		//Vamos a declarar un array
 		$data= Array();
		$url = '../reportes/cginecologica.php?id=';
 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
				"0" => (($reg->condicion) ? '<button class="btn btn-warning" onclick="mostrar(' . $reg->idcginecologica . ')"><i class="fas fa-edit"></i></button>' .
				' <button class="btn btn-danger" onclick="desactivar(' . $reg->idcginecologica . ')"><i class="far fa-times-circle"></i></button>' :
				'<button class="btn btn-warning" onclick="mostrar(' . $reg->idcginecologica . ')"><i class="fas fa-edit"></i></button>' .
				' <button class="btn btn-primary" onclick="activar(' . $reg->idcginecologica . ')"><i class="fa fa-check"></i></button>') .
				'<a target="_blank" href="' . $url . $reg->idcginecologica . '"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
 				"1"=>$reg->paciente,
 				"2"=>$reg->mc,
                "3"=>$reg->montoacobrar,
                "4"=>$reg->fecha_reg,
				"5"=>"<a href='../files/examendiagnosticoginecologica/".$reg->resexadiag."' target='_blank'>Ver</a>",
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