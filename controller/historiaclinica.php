<?php 
require_once "../model/Historiaclinica.php";

$historiaclinica=new Historiaclinica();

$idhistoriaclinica=isset($_POST["idhistoriaclinica"])? limpiarCadena($_POST["idhistoriaclinica"]):"";
$idpaciente=isset($_POST["idpaciente"])? limpiarCadena($_POST["idpaciente"]):"";
$enfermedadingreso=isset($_POST["enfermedadingreso"])? limpiarCadena($_POST["enfermedadingreso"]):"";
$antecedentesmedicos=isset($_POST["antecedentesmedicos"])? limpiarCadena($_POST["antecedentesmedicos"]):"";
$antecedentesgin=isset($_POST["antecedentesgin"])? limpiarCadena($_POST["antecedentesgin"]):"";
$antecedentesquir=isset($_POST["antecedentesquir"])? limpiarCadena($_POST["antecedentesquir"]):"";
$antecedentesfam=isset($_POST["antecedentesfam"])? limpiarCadena($_POST["antecedentesfam"]):"";
$alergias=isset($_POST["alergias"])? limpiarCadena($_POST["alergias"]):"";
$medicamentos=isset($_POST["medicamentos"])? limpiarCadena($_POST["medicamentos"]):"";
$habitos=isset($_POST["habitos"])? limpiarCadena($_POST["habitos"]):"";
$observaciones=isset($_POST["observaciones"])? limpiarCadena($_POST["observaciones"]):"";

$antecedentespren=isset($_POST["antecedentespren"])? limpiarCadena($_POST["antecedentespren"]):"";

$gestas=isset($_POST["gestas"])? limpiarCadena($_POST["gestas"]):"";
$hv=isset($_POST["hv"])? limpiarCadena($_POST["hv"]):"";
$hm=isset($_POST["hm"])? limpiarCadena($_POST["hm"]):"";
$fup=isset($_POST["fup"])? limpiarCadena($_POST["fup"]):"";
$fupap=isset($_POST["fupap"])? limpiarCadena($_POST["fupap"]):"";
$estatura=isset($_POST["estatura"])? limpiarCadena($_POST["estatura"]):"";
$ciclos=isset($_POST["ciclos"])? limpiarCadena($_POST["ciclos"]):"";
$planfam=isset($_POST["planfam"])? limpiarCadena($_POST["planfam"]):"";
$infecciones=isset($_POST["infecciones"])? limpiarCadena($_POST["infecciones"]):"";
$observacionesg=isset($_POST["observacionesg"])? limpiarCadena($_POST["observacionesg"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

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
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/pdfhistorialantes/" . $imagen);
			}
		}
		if (empty($idhistoriaclinica)){
	
				$rspta=$historiaclinica->insertar($idpaciente,$enfermedadingreso,$antecedentesmedicos,$antecedentesgin,$antecedentesquir,$antecedentespren,$antecedentesfam,$alergias,$medicamentos, $habitos, $observaciones,$gestas,$hv,$hm,$fup,$fupap,$estatura,$ciclos,$planfam, $infecciones, $observacionesg, $imagen,$_POST['vacuna']);
				echo $rspta ? 1 : 2;
			
			
		}
		else {
			$rspta=$historiaclinica->editar($idhistoriaclinica,$idpaciente,$enfermedadingreso,$antecedentesmedicos,$antecedentesgin,$antecedentesquir,$antecedentespren,$antecedentesfam,$alergias,$medicamentos, $habitos, $observaciones,$gestas,$hv,$hm,$fup,$fupap,$estatura,$ciclos,$planfam, $infecciones, $observacionesg,$imagen,$_POST['vacuna']);
			echo $rspta ? 3 : 4;
		}
	break;

	case 'desactivar':
		$rspta=$historiaclinica->desactivar($idhistoriaclinica);
 		echo $rspta ? "Historia clinica desactivada" : "Historia clinica no se puede desactivar";
	break;

	case 'activar':
		$rspta=$historiaclinica->activar($idhistoriaclinica);
 		echo $rspta ? "Historia clinica activada" : "Historia clinica no se puede activar";
	break;
	case 'mostrar':
		$rspta=$historiaclinica->mostrar($idhistoriaclinica);
 		echo json_encode($rspta);
	break;
	case 'listar':
		$rspta=$historiaclinica->listar();
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idhistoriaclinica.')"><i class="fas fa-edit"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idhistoriaclinica.')"><i class="far fa-times-circle"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idhistoriaclinica.')"><i class="fas fa-edit"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idhistoriaclinica.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombres,
                "2"=>$reg->enfermedadingreso,
                "3"=>$reg->fecha_creacion,
				"4"=>"<a href='../files/pdfhistorialantes/".$reg->espediente."' target='_blank'>Ver</a>",
 				"5"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
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

	case 'vacunas':
		//Obtenemos todos los permisos de la tabla permisos
		require_once "../model/Vacuna.php";
		$vacuna = new Vacuna();
		$rspta = $vacuna->listar();

		//Obtener los permisos asignados al usuario
		$id=$_GET['id'];
		$marcados = $historiaclinica->listarmarcados($id);
		//Declaramos el array para almacenar todos los permisos marcados
		$valores=array();

		//Almacenar los permisos asignados al usuario en el array
		while ($vac = $marcados->fetch_object())
			{
				array_push($valores, $vac->idvacuna);
			}

		//Mostramos la lista de permisos en la vista y si están o no marcados
		while ($reg = $rspta->fetch_object())
				{
					$sw=in_array($reg->idvacuna,$valores)?'checked':'';
					echo '<li> <input type="checkbox" '.$sw.'  name="vacuna[]" value="'.$reg->idvacuna.'">'.$reg->nombre.'</li>';
				}
	break;
}
?>