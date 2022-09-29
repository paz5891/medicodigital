<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consultatres
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	
	//Implementar un método para listar los registros
	public function datosEmbarazo($id)
	{
		$sql="SELECT 
        TIMESTAMPDIFF(YEAR, p.fechanac,CURDATE()) AS edad,
        DATE_FORMAT(cp.fecha_reg, '%d/%m/%Y %H:%i') as fecha_reg, 
        cp.historia,
        concat(cp.edadgestaact,' Semanas') as edadgestacionalactual,
        concat (cp.peso,' Libras') as peso,
        concat (cp.estatura,' Centimetros') as estatura,
        concat (cp.temperatura,' °C') as temperatura,
        cp.pa as presionarterial,
        cp.fc as frecuenciacardiaca,
        cp.fr as frecuenciarespiratoria,
        cp.examenmamas,
        cp.examenginec,
        cp.examenfisico,
        cp.usgobs as ultrasonidostretico,
        cp.ic as impresionclinica,
        cp.tx as tratamiento,
        cp.descripcionresexadiag,
        cp.ordenexadiag as ordendeexamendiagnostico,
        DATE_FORMAT(cp.proximacita, '%d/%m/%Y') as proximacita, 
        cp.observaciones, 
        cp.idcprenatal, 
        cp.idpaciente, 
        concat(p.nombre, ' ', p.apellido ) as paciente, 
        cp.idseguro, 
        s.nombre as seguro, 
        cp.montoacobrar, 
    
        cp.condicion
        FROM cprenatal cp INNER JOIN paciente p  on cp.idpaciente = p.idpaciente
                          INNER JOIN seguro s  on s.idseguro = cp.idseguro where cp.idcprenatal = '$id' order by cp.idcprenatal desc;";
		return ejecutarConsulta($sql);		
	}


}

?>