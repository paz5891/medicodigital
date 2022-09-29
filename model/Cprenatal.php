<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Cprenatal
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	//Implementamos un método para insertar registros
	public function insertar($idpaciente,$idembarazo,$idseguro,$historia,$edadgestaact,$peso,$estatura, $temperatura,$pa,$fc,$fr,$examenmamas,$examenginec,$examenfisico, $resexadiag,$descripcionresexadiag,$usgobs,$ic,$tx,$ordenexadiag,$proximacita,$montoacobrar,$observaciones)
	{
		$sql="INSERT INTO cprenatal(idpaciente,idembarazo,idseguro,historia,edadgestaact,peso, estatura, temperatura,pa, fc, fr, examenmamas, examenginec, examenfisico, resexadiag, descripcionresexadiag,usgobs,ic, tx, ordenexadiag,proximacita, montoacobrar, observaciones, condicion)
		VALUES ('$idpaciente', '$idembarazo', '$idseguro','$historia','$edadgestaact','$peso','$estatura','$temperatura', '$pa', '$fc','$fr','$examenmamas', '$examenginec', '$examenfisico', '$resexadiag','$descripcionresexadiag','$usgobs','$ic','$tx','$ordenexadiag', '$proximacita', '$montoacobrar','$observaciones','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idcprenatal,$idpaciente,$idembarazo,$idseguro,$historia,$edadgestaact,$peso,$estatura,$temperatura,$pa,$fc,$fr,$examenmamas, $examenginec, $examenfisico, $resexadiag,$descripcionresexadiag,$usgobs,$ic,$tx,$ordenexadiag,$proximacita,$montoacobrar,$observaciones)
	{
		$sql="UPDATE cprenatal SET idpaciente='$idpaciente',idembarazo='$idembarazo',idseguro='$idseguro', historia='$historia',edadgestaact = '$edadgestaact', peso='$peso', estatura='$estatura', 
		temperatura='$temperatura', pa='$pa', fc='$fc', fr='$fr', examenmamas='$examenmamas', examenginec='$examenginec', examenfisico='$examenfisico', resexadiag='$resexadiag', descripcionresexadiag='$descripcionresexadiag', usgobs = '$usgobs', ic='$ic', tx='$tx', 
		ordenexadiag='$ordenexadiag', proximacita='$proximacita', montoacobrar='$montoacobrar', observaciones='$observaciones' WHERE idcprenatal='$idcprenatal'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idcprenatal)
	{
		$sql="UPDATE cprenatal SET condicion='0' WHERE idcprenatal='$idcprenatal'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idcprenatal)
	{
		$sql="UPDATE cprenatal SET condicion='1' WHERE idcprenatal='$idcprenatal'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcprenatal)
	{
		$sql="SELECT * FROM cprenatal WHERE idcprenatal='$idcprenatal'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
        cp.idcprenatal, 
        cp.idpaciente, 
        concat(p.nombre, ' ', p.apellido ) as paciente, 
        cp.idseguro, 
        s.nombre as seguro, 
        cp.montoacobrar, 
		cp.resexadiag,
		DATE_FORMAT(cp.fecha_reg, '%d/%m/%Y %H:%i') as fecha_reg,
        
        cp.condicion
        FROM cprenatal cp INNER JOIN paciente p  on cp.idpaciente = p.idpaciente
                          INNER JOIN seguro s  on s.idseguro = cp.idseguro order by cp.idcprenatal desc";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM cprenatal where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>