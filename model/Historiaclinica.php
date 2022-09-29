<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Historiaclinica
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}
	//Implementamos un método para insertar registros



	public function insertar($idpaciente, $enfermedadingreso, $antecedentesmedicos, $antecedentesgin, $antecedentesquir, $antecedentespren, $antecedentesfam, $alergias, $medicamentos, $habitos, $observaciones, $gestas, $hv, $hm, $fup, $fupap, $estatura, $ciclos, $planfam, $infecciones, $observacionesg, $espediente, $vacunas)
	{
		$sql = "INSERT INTO historiaclinica(idpaciente,enfermedadingreso,antecedentesmedicos, antecedentesgin, antecedentesquir,antecedentespren, antecedentesfam, alergias, medicamentos, habitos, observaciones, gestas,hv,hm, fup, fupap,estatura, ciclos, planfam, infecciones, observacionesg, espediente, condicion)
		VALUES ('$idpaciente','$enfermedadingreso','$antecedentesmedicos','$antecedentesgin','$antecedentesquir', '$antecedentespren', '$antecedentesfam','$alergias','$medicamentos', '$habitos', '$observaciones','$gestas','$hv','$hm','$fup','$fupap', '$estatura', '$ciclos','$planfam','$infecciones', '$observacionesg', '$espediente','1')";
		//return ejecutarConsulta($sql);
		$idhistoriaclinicanew = ejecutarConsulta_retornarID($sql);

		$num_elementos = 0;
		$sw = true;

		while ($num_elementos < count($vacunas)) {
			$sql_detalle = "INSERT INTO historiaclinica_vacuna(idhistoriaclinica, idvacuna) VALUES('$idhistoriaclinicanew', '$vacunas[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos = $num_elementos + 1;
		}

		return $sw;
	}




	//Implementamos un método para editar registros
	public function editar($idhistoriaclinica, $idpaciente, $enfermedadingreso, $antecedentesmedicos, $antecedentesgin, $antecedentesquir, $antecedentespren, $antecedentesfam, $alergias, $medicamentos, $habitos, $observaciones, $gestas, $hv, $hm, $fup, $fupap, $estatura, $ciclos, $planfam, $infecciones, $observacionesg, $espediente, $vacunas)
	{
		$sql = "UPDATE historiaclinica SET idpaciente='$idpaciente', enfermedadingreso = '$enfermedadingreso', antecedentesmedicos='$antecedentesmedicos', antecedentesgin='$antecedentesgin', 
		antecedentesquir='$antecedentesquir', antecedentespren='$antecedentespren', antecedentesfam='$antecedentesfam', alergias='$alergias', medicamentos='$medicamentos', habitos='$habitos', observaciones='$observaciones', gestas='$gestas', hv = '$hv', hm='$hm', fup='$fup', 
		fupap='$fupap', estatura='$estatura', ciclos='$ciclos', planfam='$planfam', infecciones='$infecciones', observacionesg='$observacionesg', espediente='$espediente' WHERE idhistoriaclinica='$idhistoriaclinica'";
		ejecutarConsulta($sql);

		//Eliminamos todos los permisos asignados para volverlos a registrar
		$sqldel = "DELETE FROM historiaclinica_vacuna WHERE idhistoriaclinica='$idhistoriaclinica'";
		ejecutarConsulta($sqldel);

		$num_elementos = 0;
		$sw = true;

		while ($num_elementos < count($vacunas)) {
			$sql_detalle = "INSERT INTO historiaclinica_vacuna(idhistoriaclinica, idvacuna) VALUES('$idhistoriaclinica', '$vacunas[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos = $num_elementos + 1;
		}

		return $sw;
	}



	//Implementamos un método para desactivar categorías
	public function desactivar($idhistoriaclinica)
	{
		$sql = "UPDATE historiaclinica SET condicion='0' WHERE idhistoriaclinica='$idhistoriaclinica'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idhistoriaclinica)
	{
		$sql = "UPDATE historiaclinica SET condicion='1' WHERE idhistoriaclinica='$idhistoriaclinica'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idhistoriaclinica)
	{
		$sql = "SELECT * FROM historiaclinica WHERE idhistoriaclinica='$idhistoriaclinica'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql = "SELECT hc.idhistoriaclinica, DATE_FORMAT(hc.fecha_creacion, '%d/%m/%Y') as fecha_creacion, hc.idpaciente, concat(p.nombre,' ',p.apellido) as nombres, hc.enfermedadingreso, hc.antecedentesmedicos, hc.condicion, hc.espediente FROM historiaclinica hc INNER JOIN paciente p on hc.idpaciente = p.idpaciente";
		return ejecutarConsulta($sql);
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql = "SELECT * FROM historiaclinica where condicion=1";
		return ejecutarConsulta($sql);
	}


	public function listarmarcados($idhistoriaclinica)
	{
		$sql = "SELECT * FROM historiaclinica_vacuna WHERE idhistoriaclinica='$idhistoriaclinica'";
		return ejecutarConsulta($sql);
	}
}
