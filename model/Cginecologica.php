<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Cginecologica
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	//Implementamos un método para insertar registros
	public function insertar($idpaciente,$idseguro,$mc,$historia,$peso,$fur, $temperatura,$pa,$fc,$fr,$examenmamas,$examenginec,$examenfisico, $resexadiag,$descripcionresexadiag,$usgpelv,$ic,$tx,$ordenexadiag,$proximacita,$montoacobrar,$observaciones)
	{
		$sql="INSERT INTO cginecologica(idpaciente,idseguro,mc,historia,peso, fur, temperatura,pa, fc, fr, examenmamas, examenginec, examenfisico, resexadiag, descripcionresexadiag,usgpelv,ic, tx, ordenexadiag,proximacita, montoacobrar, observaciones, condicion)
		VALUES ('$idpaciente', '$idseguro', '$mc','$historia','$peso','$fur','$temperatura', '$pa', '$fc','$fr','$examenmamas', '$examenginec', '$examenfisico', '$resexadiag','$descripcionresexadiag','$usgpelv','$ic','$tx','$ordenexadiag', '$proximacita', '$montoacobrar','$observaciones','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idcginecologica,$idpaciente,$idseguro,$mc,$historia,$peso,$fur,$temperatura,$pa,$fc,$fr,$examenmamas, $examenginec, $examenfisico, $resexadiag,$descripcionresexadiag,$usgpelv,$ic,$tx,$ordenexadiag,$proximacita,$montoacobrar,$observaciones)
	{
		$sql="UPDATE cginecologica SET idpaciente='$idpaciente',idseguro='$idseguro',mc='$mc', historia='$historia', peso='$peso', fur='$fur', 
		temperatura='$temperatura', pa='$pa', fc='$fc', fr='$fr', examenmamas='$examenmamas', examenginec='$examenginec', examenfisico='$examenfisico', resexadiag='$resexadiag', descripcionresexadiag='$descripcionresexadiag', usgpelv = '$usgpelv', ic='$ic', tx='$tx', 
		ordenexadiag='$ordenexadiag', proximacita='$proximacita', montoacobrar='$montoacobrar', observaciones='$observaciones' WHERE idcginecologica='$idcginecologica'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idcginecologica)
	{
		$sql="UPDATE cginecologica SET condicion='0' WHERE idcginecologica='$idcginecologica'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idcginecologica)
	{
		$sql="UPDATE cginecologica SET condicion='1' WHERE idcginecologica='$idcginecologica'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcginecologica)
	{
		$sql="SELECT * FROM cginecologica WHERE idcginecologica='$idcginecologica'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
        cp.idcginecologica, 
        cp.idpaciente, 
        concat(p.nombre, ' ', p.apellido ) as paciente, 
        cp.mc, 
        s.nombre as seguro, 
        cp.montoacobrar, 
		cp.resexadiag,
		DATE_FORMAT(cp.fecha_reg, '%d/%m/%Y %H:%i') as fecha_reg,
        cp.condicion
        FROM cginecologica cp INNER JOIN paciente p  on cp.idpaciente = p.idpaciente
                          INNER JOIN seguro s  on s.idseguro = cp.idseguro;";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM cginecologica where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>