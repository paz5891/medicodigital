<?php
require_once "../model/Cprenatal.php";

$cprenatal = new Cprenatal();

$idcprenatal = isset($_POST["idcprenatal"]) ? limpiarCadena($_POST["idcprenatal"]) : "";
$idpaciente = isset($_POST["idpaciente"]) ? limpiarCadena($_POST["idpaciente"]) : "";
$idembarazo = isset($_POST["idembarazo"]) ? limpiarCadena($_POST["idembarazo"]) : "";
$idseguro = isset($_POST["idseguro"]) ? limpiarCadena($_POST["idseguro"]) : "";
$historia = isset($_POST["historia"]) ? limpiarCadena($_POST["historia"]) : "";
$edadgestaact = isset($_POST["edadgestaact"]) ? limpiarCadena($_POST["edadgestaact"]) : "";
$peso = isset($_POST["peso"]) ? limpiarCadena($_POST["peso"]) : "";
$estatura = isset($_POST["estatura"]) ? limpiarCadena($_POST["estatura"]) : "";
$temperatura = isset($_POST["temperatura"]) ? limpiarCadena($_POST["temperatura"]) : "";
$pa = isset($_POST["pa"]) ? limpiarCadena($_POST["pa"]) : "";
$fc = isset($_POST["fc"]) ? limpiarCadena($_POST["fc"]) : "";
$fr = isset($_POST["fr"]) ? limpiarCadena($_POST["fr"]) : "";
$examenmamas = isset($_POST["examenmamas"]) ? limpiarCadena($_POST["examenmamas"]) : "";
$examenginec = isset($_POST["examenginec"]) ? limpiarCadena($_POST["examenginec"]) : "";
$examenfisico = isset($_POST["examenfisico"]) ? limpiarCadena($_POST["examenfisico"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";
$descripcionresexadiag = isset($_POST["descripcionresexadiag"]) ? limpiarCadena($_POST["descripcionresexadiag"]) : "";
$usgobs = isset($_POST["usgobs"]) ? limpiarCadena($_POST["usgobs"]) : "";
$ic = isset($_POST["ic"]) ? limpiarCadena($_POST["ic"]) : "";
$tx = isset($_POST["tx"]) ? limpiarCadena($_POST["tx"]) : "";
$ordenexadiag = isset($_POST["ordenexadiag"]) ? limpiarCadena($_POST["ordenexadiag"]) : "";
$proximacita = isset($_POST["proximacita"]) ? limpiarCadena($_POST["proximacita"]) : "";
$montoacobrar = isset($_POST["montoacobrar"]) ? limpiarCadena($_POST["montoacobrar"]) : "";
$observaciones = isset($_POST["observaciones"]) ? limpiarCadena($_POST["observaciones"]) : "";




switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
			$imagen = $_POST["imagenactual"];
		} else {
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "application/pdf") {
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/examendiagnosticoprental/" . $imagen);
			}
		}
		if (empty($idcprenatal)) {
			$rspta = $cprenatal->insertar($idpaciente, $idembarazo, $idseguro, $historia ,$edadgestaact, $peso, $estatura, $temperatura, $pa, $fc, $fr, $examenmamas, $examenginec, $examenfisico, $imagen, $descripcionresexadiag, $usgobs, $ic, $tx, $ordenexadiag, $proximacita, $montoacobrar, $observaciones);
			echo $rspta ? 1 : 2;
		} else {
			$rspta = $cprenatal->editar($idcprenatal, $idpaciente, $idembarazo, $idseguro, $historia, $edadgestaact, $peso, $estatura, $temperatura, $pa, $fc, $fr, $examenmamas, $examenginec, $examenfisico, $imagen, $descripcionresexadiag, $usgobs, $ic, $tx, $ordenexadiag, $proximacita, $montoacobrar, $observaciones);
			echo $rspta ? 3 : 4;
		}
		break;

	case 'desactivar':
		$rspta = $cprenatal->desactivar($idcprenatal);
		echo $rspta ? "Consulta prenatal desactivada" : "Consulta prenatal no se puede desactivar";
		break;

	case 'activar':
		$rspta = $cprenatal->activar($idcprenatal);
		echo $rspta ? "Consulta prenatal activada" : "Consulta prenatal no se puede activar";
		break;

	case 'mostrar':
		$rspta = $cprenatal->mostrar($idcprenatal);
		echo json_encode($rspta);
		break;

	case 'listar':
		$rspta = $cprenatal->listar();
		//Vamos a declarar un array
		$data = array();


		while ($reg = $rspta->fetch_object()) {

			$url = '../reportes/cprenatal.php?id=';
			$data[] = array(
				"0" => (($reg->condicion) ? '<button class="btn btn-warning" onclick="mostrar(' . $reg->idcprenatal . ')"><i class="fas fa-edit"></i></button>' .
					' <button class="btn btn-danger" onclick="desactivar(' . $reg->idcprenatal . ')"><i class="far fa-times-circle"></i></button>' :
					'<button class="btn btn-warning" onclick="mostrar(' . $reg->idcprenatal . ')"><i class="fas fa-edit"></i></button>' .
					' <button class="btn btn-primary" onclick="activar(' . $reg->idcprenatal . ')"><i class="fa fa-check"></i></button>') .
					'<a target="_blank" href="' . $url . $reg->idcprenatal . '"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
				"1" => $reg->paciente,
				"2" => $reg->seguro,
				"3" => $reg->montoacobrar,
				"4" => $reg->fecha_reg,
				"5"=>"<a href='../files/examendiagnosticoprental/".$reg->resexadiag."' target='_blank'>Ver</a>",
				"6" => ($reg->condicion) ? '<span class="label bg-green">Activado</span>' :
					'<span class="label bg-red">Desactivado</span>'
			);
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData" => $data
		);
		echo json_encode($results);

		break;
	case "selectPacienteEmbarazo":
		require_once "../model/Paciente.php";
		$paciente = new Paciente();

		$rspta = $paciente->selectPacienteEmbarazo();

		while ($reg = $rspta->fetch_object()) {
			echo '<option value=' . $reg->idpaciente . '>' . $reg->nombres . '</option>';
		}
		break;

	case "selectSeguro":
		require_once "../model/Seguro.php";
		$seguro = new Seguro();

		$rspta = $seguro->select();

		while ($reg = $rspta->fetch_object()) {
			echo '<option value=' . $reg->idseguro . '>' . $reg->nombre . '</option>';
		}
		break;
	case "selectEmbarazo":
		require_once "../model/Embarazo.php";
		$embarazo = new Embarazo();

		$rspta = $embarazo->select();

		while ($reg = $rspta->fetch_object()) {
			echo '<option value=' . $reg->idembarazo . '>' . $reg->embarazo . '</option>';
		}
		break;
}
