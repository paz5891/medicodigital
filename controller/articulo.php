<?php 
require_once "../model/Articulo.php";

$articulo=new Articulo();

$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$idubicacion=isset($_POST["idubicacion"])? limpiarCadena($_POST["idubicacion"]):"";
$medida=isset($_POST["medida"])? limpiarCadena($_POST["medida"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/articulos/" . $imagen);
			}
		}
		if (empty($idarticulo)){
			$rspta=$articulo->insertar($idcategoria,$idubicacion,$medida,$nombre,$descripcion,$imagen);
            echo $rspta ? 1 : 2;
		}
		else {
			$rspta=$articulo->editar($idarticulo,$idcategoria,$idubicacion,$medida,$nombre,$descripcion,$imagen);
			echo $rspta ? 3 : 4;
		}
	break;

	case 'desactivar':
		$rspta=$articulo->desactivar($idarticulo);
 		echo $rspta ? "Artículo Desactivado" : "Artículo no se puede desactivar";
	break;

	case 'activar':
		$rspta=$articulo->activar($idarticulo);
 		echo $rspta ? "Artículo activado" : "Artículo no se puede activar";
	break;

	case 'mostrar':
		$rspta=$articulo->mostrar($idarticulo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$articulo->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
                "0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idarticulo.')"><i class="fas fa-edit"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->idarticulo.')"><i class="far fa-times-circle"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->idarticulo.')"><i class="fas fa-edit"></i></button>'.
                ' <button class="btn btn-primary" onclick="activar('.$reg->idarticulo.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->categoria,
            
 				"3"=>$reg->stock,
				"4"=>$reg->ubicacion,
				"5"=>$reg->precio_compra,
				"6"=>$reg->precio_venta,
 				"7"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >",
 				"8"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case "selectCategoria":
		require_once "../model/Categoria.php";
		$categoria = new Categoria();

		$rspta = $categoria->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idcategoria . '>' . $reg->nombre . '</option>';
				}
	break;

	case "selectUbicacion":
		require_once "../model/Ubicacion.php";
		$ubicacion = new Ubicacion();

		$rspta = $ubicacion->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idubicacion . '>' . $reg->nombre . '</option>';
				}
	break;
        
        
       
}
?>