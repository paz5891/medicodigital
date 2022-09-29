<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Venta
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

    /////$idmesa,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$total_venta,$idarticulo,$cantidad,$precio_venta,
	//Implementamos un método para insertar registros
	public function insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$total_venta,$idarticulo,$cantidad,$precio_venta,$descuento)
	{
		$sql="INSERT INTO venta (idcliente,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,total_venta,estado)
		VALUES ('$idcliente','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$total_venta','Aceptado')";
		//return ejecutarConsulta($sql);
		$idventanew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idarticulo))
		{
			$sql_detalle = "INSERT INTO detalle_venta(idventa, idarticulo,cantidad,precio_venta,descuento) VALUES ('$idventanew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}




	//Implementamos considerado como cerrar venta
	public function anular($idventa)
	{
		$sql = "UPDATE venta v INNER JOIN detalle_venta dv on v.idventa= dv.idventa  
		SET v.condicion=0, dv.estado= 'Termino' WHERE dv.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	public function desactivar($idventa)
	{
		$sql = "UPDATE venta v INNER JOIN
     detalle_venta dv on v.idventa = dv.idventa
     set  v.estado = 'Anulado', dv.condicion = 0 WHERE v.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}




	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idventa)
	{
		$sql = "SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,
		u.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,
		v.num_comprobante,v.total_venta,v.estado FROM venta v 
		INNER JOIN persona p ON v.idcliente=p.idpersona 
		INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idventa)
	{
		$sql = "SELECT dv.idventa,dv.idarticulo,a.nombre,dv.cantidad,dv.precio_venta,
		dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal FROM detalle_venta dv 
		inner join articulo a on dv.idarticulo=a.idarticulo where dv.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql = "SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,
		u.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,
		sum(cantidad*precio_venta) as total_venta,v.estado FROM venta v 
INNER JOIN persona p ON v.idcliente=p.idpersona 
INNER JOIN usuario u ON v.idusuario=u.idusuario
INNER JOIN detalle_venta dv on v.idventa= dv.idventa
WHERE v.condicion=1
AND
v.estado = 'Aceptado'
GROUP by dv.idventa
ORDER by v.idventa desc";
		return ejecutarConsulta($sql);
	}

	public function ventacabecera($idventa)
	{
		
		$sql = "SELECT v.idventa,v.idcliente,p.nombre as cliente,p.telefono as descripcion,v.idusuario,u.nombre as usuario,
		v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,DATE_FORMAT(v.fecha_hora, '%d/%m/%Y') as fecha,
		sum(cantidad*precio_venta) as total_venta

FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona 
INNER JOIN usuario u ON v.idusuario=u.idusuario
INNER JOIN detalle_venta dv on v.idventa= dv.idventa
WHERE v.idventa='$idventa'
GROUP by v.idventa";
		return ejecutarConsulta($sql);
	}

	public function ventadetalle($idventa)
	{
		$sql = "SELECT a.nombre as articulo,d.cantidad,d.precio_venta,d.descuento,
		(d.cantidad*d.precio_venta-d.descuento) as subtotal 
		FROM detalle_venta d 
		INNER JOIN articulo a ON d.idarticulo=a.idarticulo 
		WHERE d.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}
}
