<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION["nombre"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
}
else
{
if ($_SESSION['pacientes']==1 || $_SESSION['medicos']==1)
{

require( '../fpdf183/fpdf.php' );

class PDF extends FPDF {
    // Cabecera de página

    function Header() {
     
      //  $sig = date( "d/m/Y", strtotime( "+1 day" ) );

      $this->SetDrawColor( 0, 80, 180 );
      $this->SetFillColor( 230, 230, 0 );
      $this->SetTextColor( 23, 32, 42 );
      // Logo
      $this->Image( 'logo.jpeg', 10, 10, 50 );
      // Arial bold 15
      $this->SetFont( 'Arial', 'B', 10 );
      // Movernos a la derecha
      $this->Cell( 80 );
      // Títuloutf8_decode
      $this->Cell( 35, 5, utf8_decode( 'REPORTE DEL EMBARAZO' ), 0, 0, 'C' );
      $this->Cell( -119 );
      $this->Cell( 0, 15, utf8_decode( 'CENTRO MATERNO INFANTIL GÉNESIS'), 0, 0, 'C' );

      // Salto de línea
      $this->Ln( 10 );
  }

  // Pie de página


}
date_default_timezone_set("America/Guatemala");
$fechaActual = date( 'd-m-Y' );
$sig  = date( 'd/m/Y' );

$pdf = new PDF( 'p', 'mm', 'letter' );
$pdf->AliasNbPages();
$pdf->AddPage();

require_once "../model/Consultauno.php";
$id = $_GET["id"];
$consultauno = new Consultauno();
$rspta = $consultauno->datosEmbGenerales($id);
$reg = $rspta->fetch_object();

$pdf->SetFont( 'Arial', 'B', 8 );
$pdf->SetFillColor( 255, 255, 255 );
$pdf->SetFont( 'Arial', 'B', 9 );
$pdf->Cell( 196, 5, utf8_decode('GENERADO EL - DÍA '.$sig), 0, 1, 'C' );
$fecharegistro = $reg->fecharegistro;
$pdf->Cell( 60, 5, utf8_decode("Embarazo abierto el: ".$fecharegistro), 0, 1, 'L', 1 );


$pdf->Ln();





$pdf->SetFont( 'Arial', 'B', 8 );
$pdf->SetFillColor( 255, 255, 255 );
$pdf->SetFont( 'Arial', 'B', 9 );
$pdf->Cell( 196, 5, utf8_decode($reg->nombre), 0, 1, 'C' );
$pdf->Ln();

$pdf->Cell( 60, 5, utf8_decode("Edad: ". $reg->edad), 0, 1, 'L', 1 );
$pdf->Cell( 60, 5, utf8_decode("Fecha probable de parto: ". $reg->fpp), 0, 1, 'L', 1 );
$pdf->Cell( 60, 5, utf8_decode("Generada por: ". $reg->edadgestapor), 0, 1, 'L', 1 );

$pdf->MultiCell( 60, 5, utf8_decode("Detalle del estado gestacional: ".$reg->detallesestado), 0, 1, 'J', 1 );

$pdf->Cell( 60, 5, utf8_decode("Nivel de riego: ".$reg->nivelriesgoinicial), 0, 1, 'L', 0 );

$pdf->MultiCell( 195, 5, utf8_decode("OBSERVACIONES: ".$reg->observaciones), 0, 1, 'J', 1 );


//detalles del embarazo
$pdf->Ln();

$rspta1 = $consultauno->detalleConsultaPrenatal($id);

$increment = 1;
while( $registro = $rspta1->fetch_array( MYSQLI_BOTH ) ) {
  $pdf->SetFont( 'Arial', 'B', 9 );
  $pdf->Cell(196, 5, utf8_decode($registro['fecha'] ), 0, 1, 'C');

$pdf->SetFont( 'Arial', 'B', 8 );
$pdf->SetFillColor( 160, 220, 247 );
$pdf->SetFont( 'Arial', 'B', 9 );

$pdf->SetFillColor( 160, 220, 247 );
$pdf->SetFont( 'Arial', 'B', 8 );

$pdf->Cell( 38, 10, utf8_decode('Edad Gest.'), 1, 0, 'C', 1 );
$pdf->Cell( 38, 10, utf8_decode('Peso'), 1, 0, 'C', 1 );
$pdf->Cell( 38, 10, utf8_decode('Temp.'), 1, 0, 'C', 1 );
$pdf->Cell( 39, 10, utf8_decode('F. Cardiaca'), 1, 0, 'C', 1 );
$pdf->Cell( 40, 10, utf8_decode('P. Arterial'), 1, 1, 'C', 1 );
//21
//23  $pdf->Cell( 23, 10, utf8_decode('E. Ginecológico'), 1, 0, 'C', 1 ); 23
//51 $pdf->Cell( 51, 10, utf8_decode('Tratamiento'), 1, 0, 'C', 1 );

//$pdf->Cell( 0, 10, 'Imprimiendo línea número '.$i, 0, 1 );
$pdf->SetFillColor( 255, 255, 255 );
$pdf->SetFont( 'Arial', 'B', 8 );

        $pdf->SetFillColor( 255, 255, 255 );
        
        
        $pdf->Cell( 38, 20, utf8_decode( $registro['edadgestaact']." Semanas" ), 1, 0, 'C', 1 );
        $pdf->Cell( 38, 20, utf8_decode( $registro['peso']. " Lbrs" ), 1, 0, 'C', 1 );
        $pdf->Cell( 38, 20, utf8_decode( $registro['temperatura']." °C" ), 1, 0, 'C', 1 );
        $pdf->Cell( 39, 20, utf8_decode( $registro['fcardiaca'] ), 1, 0, 'C', 1 );
        $pdf->Cell( 40, 20, utf8_decode( $registro['presionarterial'] ), 1, 1, 'C', 1 );
     //21
     //23   $pdf->Cell( 23, 20, utf8_decode( $registro['eginecologico'] ), 1, 0, 'C', 1 );
     //51   $pdf->Cell( 51, 20, utf8_decode( $registro['tratamiento'] ), 1, 0, 'C', 1 );

   
       
        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell(193, 5, utf8_decode("Historia de la enfermedad"), 1, 1, 'C');
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->MultiCell( 193, 5, utf8_decode($registro['historia']), 1, 1, 'J', 1 );

        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell(193, 5, utf8_decode("Examen físico"), 1, 1, 'C');
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->MultiCell( 193, 5, utf8_decode($registro['examenfisico']), 1, 1, 'J', 1 );

        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell(193, 5, utf8_decode("Impresión clínica"), 1, 1, 'C');
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->MultiCell( 193, 5, utf8_decode($registro['ic']), 1, 1, 'J', 1 );


        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell(193, 5, utf8_decode("Ultrasonido Obstétrico"), 1, 1, 'C');
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->MultiCell( 193, 5, utf8_decode($registro['usgobs']), 1, 1, 'J', 1 );

        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell(193, 5, utf8_decode("Descripción de resultado examen"), 1, 1, 'C');
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->MultiCell( 193, 5, utf8_decode($registro['descripcionresexadiag']), 1, 1, 'J', 1 );

        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell(193, 5, utf8_decode("Orden de Examen de Diagnóstico"), 1, 1, 'C');
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->MultiCell( 193, 5, utf8_decode($registro['ordenexadiag']), 1, 1, 'J', 1 );
        
        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell(193, 5, utf8_decode("Tratamiento"), 1, 1, 'C');
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->MultiCell( 193, 5, utf8_decode($registro['tratamiento']), 1, 1, 'J', 1 );
        
        
        $pdf->SetFont( 'Arial', 'B', 8 );
        $pdf->Cell(193, 5, utf8_decode("Observaciones"), 1, 1, 'C');
        $pdf->SetFont( 'Arial', '', 8 );
        $pdf->MultiCell( 193, 5, utf8_decode($registro['observaciones']), 1, 1, 'J', 1 );
        
        $pdf->Ln();
        $increment++;
}



$sig = date( "d/m/Y");
$datelleEmbarazo ='Detalle_embarazo'.$sig;



//$pdf->Output();
//$pdf->Output($datelleEmbarazo.'.pdf','D'); 

$pdf->Output(); 

?>
<?php

}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>