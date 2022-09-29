<?php 
require "../config/Conexion.php";

Class Insumo
{
	public function __construct()
	{

	}


	public function insertar($nombre,$descripcion)
	{
		$sql="INSERT INTO insumo (nombre,descripcion,condicion)
		VALUES ('$nombre','$descripcion','1')";
		return ejecutarConsulta($sql);
	}
	public function editar($idinsumo,$nombre,$descripcion)
	{
		$sql="UPDATE insumo SET nombre='$nombre',descripcion='$descripcion' WHERE idinsumo='$idinsumo'";
		return ejecutarConsulta($sql);
	}

	public function desactivar($idinsumo)
	{
		$sql="UPDATE insumo SET condicion='0' WHERE idinsumo='$idinsumo'";
		return ejecutarConsulta($sql);
	}
	public function activar($idinsumo)
	{
		$sql="UPDATE insumo SET condicion='1' WHERE idinsumo='$idinsumo'";
		return ejecutarConsulta($sql);
	}

	public function mostrar($idinsumo)
	{
		$sql="SELECT * FROM insumo WHERE idinsumo='$idinsumo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listar()
	{
		$sql="SELECT * FROM insumo";
		return ejecutarConsulta($sql);		
	}
	public function select()
	{
		$sql="SELECT * FROM insumo where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>