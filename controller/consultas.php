<?php 
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
require_once "../model/Consultas.php";

$consulta=new Consultas();

$idcita=isset($_POST["idcita"])? limpiarCadena($_POST["idcita"]):"";
$estadocita=isset($_POST["estadocita"])? limpiarCadena($_POST["estadocita"]):"";

$idmedico = $_SESSION["idmedico"];
$idusuario = $_SESSION["idusuario"];



switch ($_GET["op"]){

    case 'guardaryeditar':
		
			$rspta=$consulta->editar($idcita,$estadocita);
			echo $rspta ? 3 : 4;
		
	break;

	case 'citasporfecha':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
        

		$rspta=$consulta->citasporfecha($fecha_inicio,$fecha_fin, $idmedico);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
				"0"=>(($reg->condicion)?
				
				'<button class="btn btn-warning" onclick="mostrar('.$reg->idcita.')"><i class="fas fa-edit"></i></button>':' <button class="btn btn-danger" onclick="desactivar('.$reg->idcita.')"><i class="far fa-times-circle"></i></button>'),
 				"1"=>$reg->seguro,
 				"2"=>$reg->medico,
 				"3"=>$reg->tipocita,
 				"4"=>$reg->paciente. ' '.$reg->visitador,
 				"5"=>$reg->asunto,
 				"6"=>$reg->telefono,
 				"7"=>$reg->fechahora,
 				"8"=>$reg->estadocita
 			
            );
		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
        
        
        
}
?>