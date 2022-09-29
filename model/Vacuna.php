<?php 
require "../config/Conexion.php";

Class Vacuna
{
	public function __construct()
	{

	}


	public function insertar($nombre,$descripcion)
	{
		$sql="INSERT INTO vacuna (nombre,descripcion,condicion)
		VALUES ('$nombre','$descripcion','1')";
		return ejecutarConsulta($sql);
	}
	public function editar($idvacuna,$nombre,$descripcion)
	{
		$sql="UPDATE vacuna SET nombre='$nombre',descripcion='$descripcion' WHERE idvacuna='$idvacuna'";
		return ejecutarConsulta($sql);
	}

	public function desactivar($idvacuna)
	{
		$sql="UPDATE vacuna SET condicion='0' WHERE idvacuna='$idvacuna'";
		return ejecutarConsulta($sql);
	}
	public function activar($idvacuna)
	{
		$sql="UPDATE vacuna SET condicion='1' WHERE idvacuna='$idvacuna'";
		return ejecutarConsulta($sql);
	}

	public function mostrar($idvacuna)
	{
		$sql="SELECT * FROM vacuna WHERE idvacuna='$idvacuna'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listar()
	{
		$sql="SELECT * FROM vacuna";
		return ejecutarConsulta($sql);		
	}
	public function select()
	{
		$sql="SELECT * FROM vacuna where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>