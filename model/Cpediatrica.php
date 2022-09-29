<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Cpediatrica
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	//Implementamos un método para insertar registros
	public function insertar($idpaciente,$idseguro,$mc,$historia,$peso,$estatura, $temperatura,$adecuacion,$pa,$fc,$fr,$examendental, $resexadiag,$descripcionresexadiag,$ic,$tx,$ordenexadiag,$proximacita,$montoacobrar,$observaciones)
	{
		$sql="INSERT INTO cpediatrica(idpaciente,idseguro,mc,historia,peso, estatura, temperatura,adecuacion,pa, fc, fr, examendental, resexadiag, descripcionresexadiag,ic, tx, ordenexadiag,proximacita, montoacobrar, observaciones, condicion)
		VALUES ('$idpaciente', '$idseguro', '$mc','$historia','$peso','$estatura','$temperatura', '$adecuacion','$pa', '$fc','$fr', '$examendental', '$resexadiag','$descripcionresexadiag','$ic','$tx','$ordenexadiag', '$proximacita', '$montoacobrar','$observaciones','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idcpediatrica,$idpaciente,$idseguro,$mc,$historia,$peso,$estatura,$temperatura,$adecuacion,$pa,$fc,$fr,$examendental, $resexadiag,$descripcionresexadiag,$ic,$tx,$ordenexadiag,$proximacita,$montoacobrar,$observaciones)
	{
		$sql="UPDATE cpediatrica SET idpaciente='$idpaciente',idseguro='$idseguro',mc='$mc', historia='$historia', peso='$peso', estatura='$estatura', 
		temperatura='$temperatura', adecuacion='$adecuacion', pa='$pa', fc='$fc', fr='$fr', examendental='$examendental', resexadiag='$resexadiag', descripcionresexadiag='$descripcionresexadiag', ic='$ic', tx='$tx', 
		ordenexadiag='$ordenexadiag', proximacita='$proximacita', montoacobrar='$montoacobrar', observaciones='$observaciones' WHERE idcpediatrica='$idcpediatrica'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idcpediatrica)
	{
		$sql="UPDATE cpediatrica SET condicion='0' WHERE idcpediatrica='$idcpediatrica'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idcpediatrica)
	{
		$sql="UPDATE cpediatrica SET condicion='1' WHERE idcpediatrica='$idcpediatrica'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcpediatrica)
	{
		$sql="SELECT * FROM cpediatrica WHERE idcpediatrica='$idcpediatrica'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
        cp.idcpediatrica, 
        cp.idpaciente, 
        concat(p.nombre, ' ', p.apellido ) as paciente, 
        cp.mc, 
        s.nombre as seguro, 
        cp.montoacobrar, 
		cp.resexadiag,
      
		DATE_FORMAT(cp.fecha_reg, '%d/%m/%Y %H:%i') as fecha_reg,
        cp.condicion
        FROM cpediatrica cp INNER JOIN paciente p  on cp.idpaciente = p.idpaciente
                          INNER JOIN seguro s  on s.idseguro = cp.idseguro;";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM cpediatrica where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>