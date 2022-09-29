<?php 
require "../config/Conexion.php";
Class Seguro
{
	public function __construct()
	{
	}
	public function insertar($nombre,$descripcion)
	{
		$sql="INSERT INTO seguro (nombre,descripcion,condicion)
		VALUES ('$nombre','$descripcion','1')";
		return ejecutarConsulta($sql);
	}
	public function editar($idseguro,$nombre,$descripcion)
	{
		$sql="UPDATE seguro SET nombre='$nombre',descripcion='$descripcion' WHERE idseguro='$idseguro'";
		return ejecutarConsulta($sql);
	}
	public function desactivar($idseguro)
	{
		$sql="UPDATE seguro SET condicion='0' WHERE idseguro='$idseguro'";
		return ejecutarConsulta($sql);
	}
	public function activar($idseguro)
	{
		$sql="UPDATE seguro SET condicion='1' WHERE idseguro='$idseguro'";
		return ejecutarConsulta($sql);
	}
	public function mostrar($idseguro)
	{
		$sql="SELECT * FROM seguro WHERE idseguro='$idseguro'";
		return ejecutarConsultaSimpleFila($sql);
	}
	public function listar()
	{
		$sql="SELECT * FROM seguro";
		return ejecutarConsulta($sql);		
	}
	public function select()
	{
		$sql="SELECT * FROM seguro where condicion=1";
		return ejecutarConsulta($sql);		
	}
}
?>