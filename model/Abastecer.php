<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Abastecer
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	
	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT nombre, stock FROM articulo WHERE stock <= 2;";
		return ejecutarConsulta($sql);		
	}

}

?>