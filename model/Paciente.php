<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Paciente
{
	public function __construct()
	{

	}
	public function insertar($imagen,$seguros,$nombre,$apellido,$apellidocasada,$estadocivil,$municipio,$direccion,$movil,$sexo,$gsanguineo,$fechanac,$nacionalidad,$numero_documento,$religion,$email,$observaciones,$nencargado,$parentesco, $tel_referencia)
	{
		$sql="INSERT INTO paciente(imagen,seguros,nombre,apellido,apellidocasada,estadocivil,municipio,direccion, movil, sexo, gsanguineo, fechanac, nacionalidad, numero_documento,religion,email, observaciones,nencargado, parentesco,tel_referencia,condicion)
		VALUES ('$imagen','$seguros','$nombre','$apellido', '$apellidocasada', '$estadocivil','$municipio','$direccion','$movil','$sexo', '$gsanguineo','$fechanac', '$nacionalidad','$numero_documento', '$religion', '$email', '$observaciones', '$nencargado', '$parentesco', '$tel_referencia','1')";
		return ejecutarConsulta($sql);
	}
	public function editar($idpaciente,$imagen,$seguros,$nombre,$apellido, $apellidocasada,$estadocivil,$municipio,$direccion,$movil,$sexo, $gsanguineo, $fechanac, $nacionalidad, $numero_documento,$religion,$email, $observaciones, $nencargado, $parentesco, $tel_referencia)
	{
		$sql="UPDATE paciente SET imagen='$imagen', seguros='$seguros', nombre='$nombre', apellido = '$apellido', apellidocasada='$apellidocasada', estadocivil='$estadocivil', municipio='$municipio', direccion='$direccion', movil='$movil', 
		sexo='$sexo', gsanguineo='$gsanguineo', fechanac='$fechanac', nacionalidad='$nacionalidad', numero_documento='$numero_documento', religion='$religion', email='$email', observaciones='$observaciones', nencargado='$nencargado', parentesco='$parentesco', tel_referencia='$tel_referencia' WHERE idpaciente='$idpaciente'";
		return ejecutarConsulta($sql);
	}
	public function desactivar($idpaciente)
	{
		$sql="UPDATE paciente SET condicion='0' WHERE idpaciente='$idpaciente'";
		return ejecutarConsulta($sql);
	}
	public function activar($idpaciente)
	{
		$sql="UPDATE paciente SET condicion='1' WHERE idpaciente='$idpaciente'";
		return ejecutarConsulta($sql);
	}
	public function mostrar($idpaciente)
	{
		$sql="SELECT * FROM paciente WHERE idpaciente='$idpaciente'";
		return ejecutarConsultaSimpleFila($sql);
	}
	public function listar()
	{
		$sql="select idpaciente, imagen, concat(nombre, ' ', apellido) as  nombres, direccion, movil, seguros, condicion,
		DATE_FORMAT(fecha_reg, '%d/%m/%Y') as fecha_reg	
		  from paciente";
		return ejecutarConsulta($sql);		
	}

	public function select()
	{
		$sql="SELECT idpaciente, concat(nombre,' ',apellido) as nombres  FROM paciente where condicion=1;";
		return ejecutarConsulta($sql);		
	}

	public function selectPacienteEmbarazo()
	{
		$sql="SELECT idpaciente, concat(nombre,' ',apellido) as nombres  FROM paciente where condicion=1 and sexo = 'F';";
		return ejecutarConsulta($sql);		
	}
}

?>