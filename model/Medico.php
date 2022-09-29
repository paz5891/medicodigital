<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Medico
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	//Implementamos un método para insertar registros
	public function insertar($idusuario, $idespecialidad,$nombre,$apellido,$direccion,$movil,$sexo,$fechanac,$numero_documento,$numcolegiatura)
	{
		$sql="INSERT INTO medico(idusuario,idespecialidad,nombre,apellido,direccion, movil, sexo, fechanac, numero_documento, numcolegiatura,condicion)
		VALUES ('$idusuario','$idespecialidad','$nombre','$apellido','$direccion','$movil','$sexo','$fechanac','$numero_documento','$numcolegiatura','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idusuario,$idmedico,$idespecialidad,$nombre,$apellido,$direccion,$movil,$sexo,$fechanac,$numero_documento,$numcolegiatura)
	{
		$sql="UPDATE medico SET idusuario='$idusuario',idespecialidad='$idespecialidad',nombre='$nombre', apellido = '$apellido', direccion='$direccion', movil='$movil', 
		sexo='$sexo', fechanac='$fechanac', numero_documento='$numero_documento', numcolegiatura='$numcolegiatura' WHERE idmedico='$idmedico'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idmedico)
	{
		$sql="UPDATE medico SET condicion='0' WHERE idmedico='$idmedico'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idmedico)
	{
		$sql="UPDATE medico SET condicion='1' WHERE idmedico='$idmedico'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idmedico)
	{
		$sql="SELECT * FROM medico WHERE idmedico='$idmedico'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT m.idmedico, m.idespecialidad, esp.nombre as especialidad, concat(m.nombre, ' ',m.apellido) as medico, m.direccion, m.movil, m.numero_documento, m.numcolegiatura, m.condicion from medico m INNER JOIN especialidad esp on m.idespecialidad = esp.idespecialidad
        ";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT idmedico, concat(nombre, ' ', apellido) as nombres FROM medico where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>