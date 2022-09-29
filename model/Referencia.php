<?php 
require "../config/Conexion.php";

Class Referencia
{
	public function __construct()
	{

	}


	public function insertar($idmedico,$idpaciente,$referir,$institucion, $motivo, $historial, $observaciones)
	{
		$sql="INSERT INTO referencia (idmedico,idpaciente,referir,institucion,motivo,historial,observaciones,condicion)
		VALUES ('$idmedico','$idpaciente','$referir','$institucion','$motivo','$historial','$observaciones','1')";
		return ejecutarConsulta($sql);
	}
	public function editar($idmedico,$idreferencia,$idpaciente,$referir,$institucion, $motivo, $historial, $observaciones)
	{
		$sql="UPDATE referencia SET idmedico='$idmedico', idpaciente='$idpaciente', referir='$referir', institucion='$institucion', motivo = '$motivo', historial='$historial', observaciones='$observaciones' WHERE idreferencia='$idreferencia'";
		return ejecutarConsulta($sql);
	}

	public function desactivar($idreferencia)
	{
		$sql="UPDATE referencia SET condicion='0' WHERE idreferencia='$idreferencia'";
		return ejecutarConsulta($sql);
	}
	public function activar($idreferencia)
	{
		$sql="UPDATE referencia SET condicion='1' WHERE idreferencia='$idreferencia'";
		return ejecutarConsulta($sql);
	}

	public function mostrar($idreferencia)
	{
		$sql="SELECT * FROM referencia WHERE idreferencia='$idreferencia'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listar()
	{
		$sql="SELECT ref.idreferencia, ref.idpaciente, concat(p.nombre,' ', p.apellido) as paciente, ref.idmedico, concat(med.nombre, ' ',med.apellido) as medico, ref.institucion, ref.motivo, DATE_FORMAT(ref.fecha, '%d/%m/%Y') as fecha, ref.condicion FROM referencia ref INNER JOIN paciente p on ref.idpaciente = p.idpaciente
		INNER JOIN medico med on med.idmedico = ref.idmedico";
		return ejecutarConsulta($sql);		
	}
	public function select()
	{
		$sql="SELECT * FROM referencia where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>