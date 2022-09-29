<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Cmedico
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function consultaGinecologica($idpaciente,$fecha_inicio,$fecha_fin)
	{
		$sql="SELECT concat(pac.nombre,' ', pac.apellido) as paciente, cg.peso, cg.estatura, cg.temperatura, cg.pa as precionarterial, cg.fc as frecuenciacardiaca, cg.fr as frecuenciarespiratoria, cg.fecha_reg from  paciente as pac INNER JOIN cginecologica as cg on pac.idpaciente = cg.idpaciente
        WHERE DATE(cg.fecha_reg)>='$fecha_inicio' AND DATE(cg.fecha_reg)<='$fecha_fin' and cg.condicion=1 and pac.idpaciente = '$idpaciente';
       ";
		return ejecutarConsulta($sql);		
	}
	
	
	public function consultaPediatrica($idpaciente,$fecha_inicio,$fecha_fin)
	{
		$sql="SELECT concat(pac.nombre,' ', pac.apellido) as paciente, cg.peso, cg.estatura, cg.temperatura, cg.pa as precionarterial, cg.fc as frecuenciacardiaca, cg.fr as frecuenciarespiratoria, cg.fecha_reg from  paciente as pac INNER JOIN cpediatrica as cg on pac.idpaciente = cg.idpaciente
        WHERE DATE(cg.fecha_reg)>='$fecha_inicio' AND DATE(cg.fecha_reg)<='$fecha_fin' and cg.condicion=1 and pac.idpaciente = '$idpaciente';
       ";
		return ejecutarConsulta($sql);		
	}
	
	
	public function totalPrenatal($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT IFNULL(SUM(cp.montoacobrar),0) as total FROM cprenatal as cp WHERE  cp.condicion =1 and DATE(cp.fecha_reg)>='$fecha_inicio' AND DATE(cp.fecha_reg)<='$fecha_fin'";
		return ejecutarConsulta($sql);		
	}
	
	
	
	public function totalPediatrica($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT IFNULL(SUM(cp.montoacobrar),0) as total FROM cpediatrica as cp WHERE  cp.condicion =1 and DATE(cp.fecha_reg)>='$fecha_inicio' AND DATE(cp.fecha_reg)<='$fecha_fin'";
		return ejecutarConsulta($sql);		
	}
	
	
	
	public function totalGinecologica($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT IFNULL(SUM(cp.montoacobrar),0) as total FROM cginecologica as cp WHERE  cp.condicion =1 and DATE(cp.fecha_reg)>='$fecha_inicio' AND DATE(cp.fecha_reg)<='$fecha_fin'";
		return ejecutarConsulta($sql);		
	}
	
	
	

	
    
    

    

}

?>