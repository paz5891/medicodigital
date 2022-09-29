<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consultaseis
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	
	//Implementar un método para listar los registros
	public function datosReferencias($id)
	{
		$sql="SELECT ref.idreferencia, ref.idpaciente, concat(p.nombre,' ', p.apellido) as paciente,p.sexo, 
        DATE_FORMAT(p.fechanac, '%d/%m/%Y') as fechanac,ref.referir, med.numcolegiatura,
       
       TIMESTAMPDIFF(YEAR, p.fechanac,CURDATE()) AS edad,ref.idmedico, concat(med.nombre, ' ',med.apellido) as medico, ref.institucion, ref.motivo,ref.historial, ref.observaciones,  DATE_FORMAT(ref.fecha, '%d/%m/%Y %H:%i') as fecha, ref.condicion FROM referencia ref INNER JOIN paciente p on ref.idpaciente = p.idpaciente
       INNER JOIN medico med on med.idmedico = ref.idmedico WHERE ref.idreferencia = '$id' and ref.condicion =1;";
		return ejecutarConsulta($sql);		
	}


}

?>