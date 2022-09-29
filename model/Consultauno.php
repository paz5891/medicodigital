<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consultauno
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	
	//Implementar un método para listar los registros
	public function datosEmbGenerales($id)
	{
		$sql="SELECT pa.idpaciente, 
        concat(pa.nombre, ' ', pa.apellido) as nombre, 
        
        DATE_FORMAT(emb.fech_reg, '%d/%m/%Y %H:%i') as fecharegistro, 
        emb.edadgestaini as edadgestainicial, 
        TIMESTAMPDIFF(YEAR,pa.fechanac,CURDATE()) AS edad,
        emb.edadgestapor, 
        emb.estadogesta, 
        emb.detallesestado,
        emb.fpp,
        emb.nivelriesgo as nivelriesgoinicial, 
        emb.nivelriesgo, 
        emb.observaciones 
        from embarazo emb INNER JOIN paciente pa on emb.idpaciente = pa.idpaciente WHERE idembarazo ='$id'";
		return ejecutarConsulta($sql);		
	}

	public function detalleConsultaPrenatal($id)
	{
		$sql="SELECT pac.idpaciente, 
        concat(pac.nombre,' ', pac.apellido) as paciente,
        emb.idembarazo,
        cp.edadgestaact,
        cp.peso,
        cp.temperatura,
        cp.fc as fcardiaca,
        cp.pa as presionarterial,
        cp.examenmamas as emamas,
        cp.examenginec as eginecologico,
        cp.tx as tratamiento,
        cp.observaciones,
        cp.historia, 
        cp.usgobs, 
        cp.examenfisico,
        cp.ic, 
        cp.descripcionresexadiag,
        cp.ordenexadiag,
        DATE_FORMAT(cp.fecha_reg, '%d/%m/%Y') as fecha
        FROM cprenatal  cp INNER JOIN paciente pac on cp.idpaciente = pac.idpaciente INNER JOIN embarazo emb on emb.idembarazo = cp.idembarazo WHERE 
        emb.idembarazo='$id' ORDER by cp.fecha_reg DESC;";
		return ejecutarConsulta($sql);		
	}

}

?>