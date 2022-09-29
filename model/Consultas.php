<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consultas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

    

	public function citasporfecha($fecha_inicio,$fecha_fin, $idmedico)
	{
		$sql="SELECT c.condicion, c.idcita, seg.nombre as seguro, concat(med.nombre, ' ', med.apellido) as medico, c.tipocita, concat(pac.nombre, ' ', pac.apellido) as paciente, c.visitador, c.asunto, c.telefono, concat(DATE_FORMAT(c.fecha, '%d/%m/%Y'), ' ', c.hora) as fechahora, c.estadocita from cita c 
        INNER JOIN seguro seg on c.idseguro = seg.idseguro 
        INNER JOIN medico med on med.idmedico = c.idmedico
        LEFT JOIN paciente pac on pac.idpaciente = c.pacienteovisitador WHERE DATE(c.fecha)>='$fecha_inicio' AND DATE(c.fecha)<='$fecha_fin' and c.idmedico = '$idmedico' and c.condicion = 1";
		return ejecutarConsulta($sql);		
	}

    	//Implementamos un método para editar registros
	public function editar($idcita,$estadocita)
	{
		$sql="UPDATE cita SET estadocita='$estadocita' WHERE idcita='$idcita'";
		return ejecutarConsulta($sql);
	}



    

/////// fin de consulta no administradores//////////////////////////////////////////////////////
    
   


    
    

}

?>