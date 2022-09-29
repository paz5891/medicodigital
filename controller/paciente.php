<?php 
require_once "../model/Paciente.php";

$paciente=new Paciente();

$idpaciente=isset($_POST["idpaciente"])? limpiarCadena($_POST["idpaciente"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$seguros=isset($_POST["seguros"])? limpiarCadena($_POST["seguros"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$apellido=isset($_POST["apellido"])? limpiarCadena($_POST["apellido"]):"";
$apellidocasada=isset($_POST["apellidocasada"])? limpiarCadena($_POST["apellidocasada"]):"";
$municipio=isset($_POST["municipio"])? limpiarCadena($_POST["municipio"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$movil=isset($_POST["movil"])? limpiarCadena($_POST["movil"]):"";
$sexo=isset($_POST["sexo"])? limpiarCadena($_POST["sexo"]):"";
$fechanac=isset($_POST["fechanac"])? limpiarCadena($_POST["fechanac"]):"";
$nacionalidad=isset($_POST["nacionalidad"])? limpiarCadena($_POST["nacionalidad"]):"";
$numero_documento=isset($_POST["numero_documento"])? limpiarCadena($_POST["numero_documento"]):"";
$religion=isset($_POST["religion"])? limpiarCadena($_POST["religion"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$observaciones=isset($_POST["observaciones"])? limpiarCadena($_POST["observaciones"]):"";

$nencargado=isset($_POST["nencargado"])? limpiarCadena($_POST["nencargado"]):"";
$parentesco=isset($_POST["parentesco"])? limpiarCadena($_POST["parentesco"]):"";
$tel_referencia=isset($_POST["tel_referencia"])? limpiarCadena($_POST["tel_referencia"]):"";

$estadocivil=isset($_POST["estadocivil"])? limpiarCadena($_POST["estadocivil"]):"";

$gsanguineo=isset($_POST["gsanguineo"])? limpiarCadena($_POST["gsanguineo"]):"";




switch ($_GET["op"]){
	case 'guardaryeditar':
        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/pacientes/" . $imagen);
			}
		}

		if (empty($idpaciente)){
			$rspta=$paciente->insertar($imagen,$seguros,$nombre,$apellido,$apellidocasada,$estadocivil,$municipio,$direccion,$movil,$sexo,$gsanguineo,$fechanac,$nacionalidad, $numero_documento,$religion, $email,$observaciones,$nencargado,$parentesco, $tel_referencia);
			echo $rspta ? 1 : 2;
		}
		else {
			$rspta=$paciente->editar($idpaciente,$imagen,$seguros,$nombre,$apellido,$apellidocasada,$estadocivil,$municipio,$direccion,$movil,$sexo,$gsanguineo,$fechanac,$nacionalidad,$numero_documento, $religion, $email, $observaciones, $nencargado,$parentesco, $tel_referencia);
			echo $rspta ? 3 : 4;
		}
	break;

	case 'desactivar':
		$rspta=$paciente->desactivar($idpaciente);
 		echo $rspta ? "Paciente Desactivado" : "Paciente no se puede desactivar";
	break;

	case 'activar':
		$rspta=$paciente->activar($idpaciente);
 		echo $rspta ? "Paciente activado" : "Paciente no se puede activar";
	break;

	case 'mostrar':
		$rspta=$paciente->mostrar($idpaciente);
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$paciente->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
			$url='../reportes/historialmedico.php?id=';
 			$data[]=array(
 				"0"=>(($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idpaciente.')"><i class="fas fa-edit"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idpaciente.')"><i class="far fa-times-circle"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idpaciente.')"><i class="fas fa-edit"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idpaciente.')"><i class="fa fa-check"></i></button>').
					 '<a target="_blank" href="'.$url.$reg->idpaciente.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
                "1"=>"<img src='../files/pacientes/".$reg->imagen."' height='50px' width='50px' >",
 				"2"=>$reg->nombres,
                "3"=>$reg->direccion,
                "4"=>$reg->movil,
				"5"=>$reg->seguros,
				"6"=>$reg->fecha_reg,
 				"7"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
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