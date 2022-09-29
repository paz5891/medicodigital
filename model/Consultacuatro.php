<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consultacuatro
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	
	//Implementar un método para listar los registros
	public function datosPediatrica($id)
	{
		$sql="SELECT 
        DATE_FORMAT(cp.fecha_reg, '%d/%m/%Y %H:%i') as fecha_reg, 
        concat(p.nombre, ' ', p.apellido ) as paciente, 
        TIMESTAMPDIFF(YEAR, p.fechanac,CURDATE()) AS edad,
        cp.idseguro, 
        s.nombre as seguro, 
       	cp.mc as motivoconsulta,
        cp.historia,
        concat (cp.peso,' Libras') as peso,
        concat (cp.estatura,' Centimetros') as estatura,
        concat (cp.temperatura,' °C') as temperatura,
        cp.adecuacion,
        cp.pa as presionarterial,
        cp.fc as frecuenciacardiaca,
        cp.fr as frecuenciarespiratoria,
        cp.examendental,
        cp.descripcionresexadiag as descripcionresexadiag,
        cp.ic as impresionclinica,
        cp.tx as tratamiento,
        cp.ordenexadiag as ordendeexamendiagnostico,
        DATE_FORMAT(cp.proximacita, '%d/%m/%Y') as proximacita, 
         cp.montoacobrar, 
        cp.observaciones, 
        cp.idcpediatrica, 
        cp.idpaciente, 
       
        cp.condicion
        FROM cpediatrica cp INNER JOIN paciente p  on cp.idpaciente = p.idpaciente
                          INNER JOIN seguro s  on s.idseguro = cp.idseguro where cp.idcpediatrica = '$id' order by cp.idcpediatrica desc;";
		return ejecutarConsulta($sql);		
	}


}

?>