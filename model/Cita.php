<?php 
require "../config/Conexion.php";

Class Cita
{
	public function __construct()
	{

	}


	public function insertar($idseguro,$idmedico,$tipocita,$pacienteovisitador,$visitador, $asunto, $telefono, $fecha,$hora,$estadocita)
	{
		$sql="CALL sp_registrar_citas('$idseguro', '$idmedico','$tipocita','$pacienteovisitador', '$visitador', '$asunto', '$telefono', '$fecha','$hora','$estadocita')";
		return ejecutarConsulta($sql);
	}


	public function editar($idcita,$idseguro,$idmedico,$tipocita,$pacienteovisitador, $visitador, $asunto, $telefono, $fecha,$hora,$estadocita)
	{
		$sql="CALL sp_actualizar_citas('$idcita','$idseguro', '$idmedico','$tipocita','$pacienteovisitador', '$visitador', '$asunto', '$telefono', '$fecha','$hora','$estadocita')";
		return ejecutarConsulta($sql);
	}

	public function desactivar($idcita)
	{
		$sql="delete  from cita WHERE idcita='$idcita'";
		return ejecutarConsulta($sql);
	}
	public function activar($idcita)
	{
		$sql="UPDATE cita SET condicion='1' WHERE idcita='$idcita'";
		return ejecutarConsulta($sql);
	}

	public function mostrar($idcita)
	{
		$sql="SELECT * FROM cita WHERE idcita='$idcita'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listar()
	{
		$sql="SELECT c.idcita, c.condicion, c.estadocita as estado, concat(med.nombre, ' ', med.apellido) as medico,seg.nombre as seguro, c.tipocita, concat(pac.nombre, ' ', pac.apellido) as paciente, c.visitador,
		c.asunto, c.telefono, 
        concat(DATE_FORMAT(c.fecha, '%d/%m/%Y'), ' ', c.hora) as horariocitaunica
        
        
        from cita c INNER JOIN seguro seg
		INNER JOIN medico med on med.idmedico = c.idmedico 
        LEFT JOIN paciente pac on pac.idpaciente = c.pacienteovisitador
        GROUP by c.idcita";
		return ejecutarConsulta($sql);		
	}
	public function select()
	{
		$sql="SELECT * FROM cita where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>