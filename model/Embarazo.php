<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Embarazo
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	//Implementamos un método para insertar registros
	public function insertar($idpaciente,$edadgestaini,$edadgestapor,$fpp,$estadogesta,$detallesestado,$nivelriesgo,$observaciones)
	{
		$sql="INSERT INTO embarazo(idpaciente,edadgestaini,edadgestapor,fpp, estadogesta, detallesestado,nivelriesgo, observaciones, condicion)
		VALUES ('$idpaciente','$edadgestaini','$edadgestapor','$fpp','$estadogesta','$detallesestado', '$nivelriesgo', '$observaciones','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idembarazo,$idpaciente,$edadgestaini,$edadgestapor,$fpp,$estadogesta,$detallesestado,$nivelriesgo,$observaciones)
	{
		$sql="UPDATE embarazo SET idpaciente='$idpaciente',edadgestaini='$edadgestaini', edadgestapor = '$edadgestapor', fpp='$fpp', estadogesta='$estadogesta', 
		detallesestado='$detallesestado', nivelriesgo='$nivelriesgo', observaciones='$observaciones'  WHERE idembarazo='$idembarazo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idembarazo)
	{
		$sql="UPDATE embarazo SET condicion='0' WHERE idembarazo='$idembarazo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idembarazo)
	{
		$sql="UPDATE embarazo SET condicion='1' WHERE idembarazo='$idembarazo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idembarazo)
	{
		$sql="SELECT * FROM embarazo WHERE idembarazo='$idembarazo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT hc.idembarazo, hc.idpaciente, concat(p.nombre,' ',p.apellido) as nombres, concat(hc.edadgestaini, ' Semanas') as edadgestaini , hc.edadgestapor, 
        DATE_FORMAT(hc.fpp, '%d/%m/%Y') as fpp, 
		DATE_FORMAT(hc.fech_reg, '%d/%m/%Y') as fech_reg,
		hc.condicion FROM embarazo hc INNER JOIN paciente p on hc.idpaciente = p.idpaciente";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT e.idembarazo, p.idpaciente, concat(p.nombre,' ', p.apellido,' ',e.nivelriesgo,' ', e.fech_reg) as embarazo  FROM embarazo e INNER JOIN paciente p on e.idpaciente = p.idpaciente where e.condicion=1
		GROUP by e.idembarazo";
		return ejecutarConsulta($sql);		
	}
}

?>