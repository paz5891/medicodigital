<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consultados
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	
	//Implementar un método para listar los registros
	public function datosGeneralesPaciente($id)
	{
		$sql="SELECT 
        imagen, 
        concat(nombre, ' ', apellido) as paciente, 
        DATE_FORMAT(fechanac, '%d/%m/%Y') as fechanac,
        estadocivil,
        seguros,
        nacionalidad,
        sexo,
        gsanguineo,
        TIMESTAMPDIFF(YEAR,fechanac,CURDATE()) AS edad,
        municipio, 
        direccion, 
        movil, 
        email, 
        numero_documento as dni,
        religion, 
        nencargado as encargado,
        parentesco as enparentesco,
        observaciones,
        DATE_FORMAT(fecha_reg, '%d/%m/%Y %H:%i') as fecha_reg,
        tel_referencia as entelreferencia from paciente
        WHERE idpaciente = '$id' and condicion = 1;";
		return ejecutarConsulta($sql);		
	}

	public function historialMedicoPaciente($id)
	{
		$sql="SELECT 
        pac.idpaciente,
        concat(pac.nombre,' ',pac.apellido) as paciente,
        enfermedadingreso,
        antecedentesmedicos,
        antecedentesquir,
        antecedentesfam,
        alergias,
        medicamentos,
        habitos,
        antecedentespren,
        
        
        antecedentesgin,
        gestas,
        hv as hijosvivos,
        hm as hijosmuertos,
        fup as fultparto,
        fupap as fechapapanicolao,
        estatura as  estatura,
        ciclos,
        planfam,
        infecciones,
        observacionesg
        FROM historiaclinica hc INNER JOIN paciente pac on hc.idpaciente = pac.idpaciente WHERE pac.idpaciente = '$id' and pac.condicion = 1;";
		return ejecutarConsulta($sql);		
	}


    
	public function vacunasPaciente($id)
	{
		$sql="SELECT vac.nombre as vacuna, vac.descripcion from 

        paciente pa INNER JOIN historiaclinica hc on pa.idpaciente = hc.idpaciente
                    INNER JOIN historiaclinica_vacuna hcv on hc.idhistoriaclinica = hcv.idhistoriaclinica
                    INNER JOIN vacuna vac on vac.idvacuna = hcv.idvacuna WHERE pa.idpaciente = '$id' and pa.condicion =1;";
		return ejecutarConsulta($sql);		
	}

    public function datosGinecologicaUna($id)
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
                          INNER JOIN seguro s  on s.idseguro = cg.idseguro where p.idpaciente = '$id' and cg.condicion =1 order by cg.idcginecologica  asc limit 1;";
		return ejecutarConsulta($sql);		
	}

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
                          INNER JOIN seguro s  on s.idseguro = cg.idseguro where p.idpaciente = '$id' and cg.condicion =1 order by cg.idcginecologica asc;";
		return ejecutarConsulta($sql);		
	}
    public function datosGinecologicaConteo($id)
	{
		$sql="SELECT 
         COUNT(*) as contador
        FROM cginecologica cg INNER JOIN paciente p  on cg.idpaciente = p.idpaciente
                          INNER JOIN seguro s  on s.idseguro = cg.idseguro where p.idpaciente = '$id' and cg.condicion =1 order by cg.idcginecologica asc;";
		return ejecutarConsulta($sql);		
	}

/*CONSULTA PEDIATRICA*/
public function datosPediatrica($id)
{
    $sql="SELECT 
    DATE_FORMAT(cp.fecha_reg, '%d/%m/%Y %H:%i') as fecha_reg, 
    TIMESTAMPDIFF(YEAR, p.fechanac,CURDATE()) AS edad,
   concat(p.nombre, ' ', p.apellido ) as paciente, 
   cp.idseguro, 
   s.nombre as seguro, 
      cp.mc as motivoconsulta,
   cp.historia,
   concat (cp.peso,' Libras') as peso,
   concat (cp.estatura) as estatura,
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
   cp.observaciones, 
   cp.idcpediatrica, 
   cp.idpaciente, 
  
   cp.condicion
   FROM cpediatrica cp INNER JOIN paciente p  on cp.idpaciente = p.idpaciente
                     INNER JOIN seguro s  on s.idseguro = cp.idseguro where p.idpaciente = '$id' and cp.condicion =1 order by cp.idcpediatrica  asc;";
    return ejecutarConsulta($sql);		
}

    
    public function datosPediatricaUna($id)
	{
		$sql="SELECT 
        DATE_FORMAT(cp.fecha_reg, '%d/%m/%Y %H:%i') as fecha_reg, 
        TIMESTAMPDIFF(YEAR, p.fechanac,CURDATE()) AS edad,
       concat(p.nombre, ' ', p.apellido ) as paciente, 
       cp.idseguro, 
       s.nombre as seguro, 
          cp.mc as motivoconsulta,
       cp.historia,
       concat (cp.peso,' Libras') as peso,
       concat (cp.estatura) as estatura,
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
       cp.observaciones, 
       cp.idcpediatrica, 
       cp.idpaciente, 
      
       cp.condicion
       FROM cpediatrica cp INNER JOIN paciente p  on cp.idpaciente = p.idpaciente
                         INNER JOIN seguro s  on s.idseguro = cp.idseguro where p.idpaciente = '$id' and cp.condicion =1 order by cp.idcpediatrica  asc limit 1;";
		return ejecutarConsulta($sql);		
	}

 
    public function datosPediatricaConteo($id)
	{
		$sql="SELECT 
        COUNT(*) as contador
       FROM cpediatrica cp INNER JOIN paciente p  on cp.idpaciente = p.idpaciente
                         INNER JOIN seguro s  on s.idseguro = cp.idseguro where p.idpaciente = '$id' and cp.condicion =1 order by cp.idcpediatrica asc;";
		return ejecutarConsulta($sql);		
	}


}

?>