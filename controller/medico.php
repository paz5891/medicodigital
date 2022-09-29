<?php 
require_once "../model/Medico.php";

$medico=new Medico();

$idmedico=isset($_POST["idmedico"])? limpiarCadena($_POST["idmedico"]):"";
$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$idespecialidad=isset($_POST["idespecialidad"])? limpiarCadena($_POST["idespecialidad"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$apellido=isset($_POST["apellido"])? limpiarCadena($_POST["apellido"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$movil=isset($_POST["movil"])? limpiarCadena($_POST["movil"]):"";
$sexo=isset($_POST["sexo"])? limpiarCadena($_POST["sexo"]):"";
$fechanac=isset($_POST["fechanac"])? limpiarCadena($_POST["fechanac"]):"";
$numero_documento=isset($_POST["numero_documento"])? limpiarCadena($_POST["numero_documento"]):"";
$numcolegiatura=isset($_POST["numcolegiatura"])? limpiarCadena($_POST["numcolegiatura"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idmedico)){
			$rspta=$medico->insertar($idusuario,$idespecialidad,$nombre,$apellido,$direccion,$movil,$sexo,$fechanac,$numero_documento,$numcolegiatura);
			echo $rspta ? 1 : 2;
		}
		else {
			$rspta=$medico->editar($idusuario,$idmedico,$idespecialidad,$nombre,$apellido,$direccion,$movil,$sexo,$fechanac,$numero_documento,$numcolegiatura);
			echo $rspta ? 3 : 4;
		}
	break;

	case 'desactivar':
		$rspta=$medico->desactivar($idmedico);
 		echo $rspta ? "Médico Desactivado" : "Médico no se puede desactivar";
	break;

	case 'activar':
		$rspta=$medico->activar($idmedico);
 		echo $rspta ? "Médico activado" : "Médico no se puede activar";
	break;

	case 'mostrar':
		$rspta=$medico->mostrar($idmedico);
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$medico->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idmedico.')"><i class="fas fa-edit"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idmedico.')"><i class="far fa-times-circle"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idmedico.')"><i class="fas fa-edit"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idmedico.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->especialidad,
 				"2"=>$reg->medico,
                "3"=>$reg->direccion,
                "4"=>$reg->movil,
                "5"=>$reg->numero_documento,
                "6"=>$reg->numcolegiatura,
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

	case "selectUsuario":
		require_once "../model/Usuario.php";
		$usuario = new Usuario();

		$rspta = $usuario->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idusuario . '>' . $reg->nombres . '</option>';
				}
	break;


    case "selectEspecialidad":
		require_once "../model/Especialidad.php";
		$especialidad = new Especialidad();

		$rspta = $especialidad->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idespecialidad . '>' . $reg->nombre . '</option>';
				}
	break;
}
?>