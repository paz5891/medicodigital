<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Ubicacion
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$descripcion)
	{
		$sql="INSERT INTO ubicacion (nombre,descripcion,condicion)
		VALUES ('$nombre','$descripcion','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idubicacion,$nombre,$descripcion)
	{
		$sql="UPDATE ubicacion SET nombre='$nombre',descripcion='$descripcion' WHERE idubicacion='$idubicacion'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idubicacion)
	{
		$sql="UPDATE ubicacion SET condicion='0' WHERE idubicacion='$idubicacion'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idubicacion)
	{
		$sql="UPDATE ubicacion SET condicion='1' WHERE idubicacion='$idubicacion'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idubicacion)
	{
		$sql="SELECT * FROM ubicacion WHERE idubicacion='$idubicacion'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM ubicacion";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM ubicacion where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>