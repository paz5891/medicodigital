<?php 
require "../config/Conexion.php";

Class Especialidad
{
	public function __construct()
	{

	}


	public function insertar($nombre,$descripcion)
	{
		$sql="INSERT INTO especialidad (nombre,descripcion,condicion)
		VALUES ('$nombre','$descripcion','1')";
		return ejecutarConsulta($sql);
	}
	public function editar($idespecialidad,$nombre,$descripcion)
	{
		$sql="UPDATE especialidad SET nombre='$nombre',descripcion='$descripcion' WHERE idespecialidad='$idespecialidad'";
		return ejecutarConsulta($sql);
	}

	public function desactivar($idespecialidad)
	{
		$sql="UPDATE especialidad SET condicion='0' WHERE idespecialidad='$idespecialidad'";
		return ejecutarConsulta($sql);
	}
	public function activar($idespecialidad)
	{
		$sql="UPDATE especialidad SET condicion='1' WHERE idespecialidad='$idespecialidad'";
		return ejecutarConsulta($sql);
	}

	public function mostrar($idespecialidad)
	{
		$sql="SELECT * FROM especialidad WHERE idespecialidad='$idespecialidad'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listar()
	{
		$sql="SELECT * FROM especialidad";
		return ejecutarConsulta($sql);		
	}
	public function select()
	{
		$sql="SELECT * FROM especialidad where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>