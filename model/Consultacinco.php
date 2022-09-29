<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consultacinco
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	
	//Implementar un método para listar los registros
	public function datosGinecologica($id)
	{
		$sql="SELECT 
         DATE_FORMAT(cg.fecha_reg, '%d/%m/%Y %H:%i') as fecha_reg, 
         TIMESTAMPDIFF(YEAR, p.fechanac,CURDATE()) AS edad,
        concat(p.nombre, ' ', p.apellido ) as paciente, 
        cg.idseguro, 
        s.nombre as seguro, 
       	cg.mc as motivoconsulta,
        cg.historia,
        concat (cg.peso,' Libras') as peso,
        concat (cg.fur) as fur,
        concat (cg.temperatura,' °C') as temperatura,
    
        cg.pa as presionarterial,
        cg.fc as frecuenciacardiaca,
        cg.fr as frecuenciarespiratoria,
        cg.examenfisico,
        cg.examenmamas,
        cg.examenginec,
        
        cg.descripcionresexadiag as descripcionresexadiag,
        cg.usgpelv as ultrasonidopelvico,
        cg.ic as impresionclinica,
        cg.tx as tratamiento,
        cg.ordenexadiag as ordendeexamendiagnostico,
        
        DATE_FORMAT(cg.proximacita, '%d/%m/%Y') as proximacita, 
        cg.observaciones, 
        cg.idcginecologica, 
        cg.idpaciente, 
       
        cg.condicion
        FROM cginecologica cg INNER JOIN paciente p  on cg.idpaciente = p.idpaciente
                          INNER JOIN seguro s  on s.idseguro = cg.idseguro where cg.idcginecologica = '$id' order by cg.idcginecologica desc;";
		return ejecutarConsulta($sql);		
	}


}

?>