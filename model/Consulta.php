<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consulta
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function comprasfecha($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT DATE(i.fecha_hora) as fecha,u.nombre as usuario, p.nombre as proveedor,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE DATE(i.fecha_hora)>='$fecha_inicio' AND DATE(i.fecha_hora)<='$fecha_fin' and i.estado = 'Aceptado'";
		return ejecutarConsulta($sql);		
	}
	
	
	

	public function ventasfechacliente($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT DATE(v.fecha_hora) as fecha,u.nombre as usuario, p.nombre as cliente,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' and v.estado = 'Aceptado'";
		return ejecutarConsulta($sql);		
	}
    
    
    
    public function reporteporfecha($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT a.nombre as Producto,sum(dv.cantidad) as CantidadVendidos, a.precio_compra,dv.precio_venta,
sum(dv.cantidad)*a.precio_compra as TotalCompra,

sum(dv.cantidad)* dv.precio_venta TotalBrutoProducto ,
sum(dv.cantidad)* dv.precio_venta - sum(dv.cantidad)*a.precio_compra as Ganancia 
from venta v 
INNER JOIN detalle_venta dv on v.idventa= dv.idventa
INNER JOIN articulo a on dv.idarticulo = a.idarticulo
INNER JOIN categoria c on c.idcategoria=a.idcategoria

where  v.con >='$fecha_inicio' and v.con <='$fecha_fin'
and v.estado = 'Aceptado' 
GROUP by  dv.idarticulo
ORDER by dv.idarticulo";
		return ejecutarConsulta($sql);		
	}
    
////consultas no administradores ............................................................................................
    
public function reporteporfechaNoAdmin($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT a.nombre as Producto,sum(dv.cantidad) as CantidadVendidos,dv.precio_venta,
sum(dv.cantidad)* dv.precio_venta TotalVenta 

from venta v 
INNER JOIN detalle_venta dv on v.idventa= dv.idventa
INNER JOIN articulo a on dv.idarticulo = a.idarticulo
INNER JOIN categoria c on c.idcategoria=a.idcategoria

where   v.con >='$fecha_inicio' and v.con <='$fecha_fin'
and v.estado = 'Aceptado' 
GROUP by  dv.idarticulo
ORDER by dv.idarticulo ";
		return ejecutarConsulta($sql);		
	}
    
    
/////// fin de consulta no administradores//////////////////////////////////////////////////////
    
   


    
    

	public function totalcomprahoy()
	{
		$sql="SELECT IFNULL(SUM(total_compra),0) as total_compra FROM ingreso WHERE DATE(fecha_hora)=curdate() AND estado = 'Aceptado'";
		return ejecutarConsulta($sql);
	}

	public function totalventahoy()
	{
		$sql="SELECT IFNULL(SUM(total_venta),0) as total_venta FROM venta WHERE DATE(fecha_hora)=curdate() AND estado = 'Aceptado'";
		return ejecutarConsulta($sql);
	}

	public function comprasultimos_10dias()
	{
		$sql="SELECT CONCAT(DAY(fecha_hora),'-',MONTH(fecha_hora)) as fecha,SUM(total_compra) as total FROM ingreso 
		WHERE estado = 'Aceptado'
		GROUP by fecha_hora ORDER BY fecha_hora DESC limit 0,10";
		return ejecutarConsulta($sql);
	}

	public function ventasultimos_12meses()
	{
		$sql="SELECT DATE_FORMAT(fecha_hora,'%M') as fecha,SUM(total_venta) as total FROM venta 
		WHERE estado = 'Aceptado'
		GROUP by MONTH(fecha_hora) ORDER BY fecha_hora DESC limit 0,10";
		return ejecutarConsulta($sql);
	}
}

?>