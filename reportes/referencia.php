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
 
      // Logo
      $this->Image( 'logo.jpeg', 10, 10, 50 );
      // Arial bold 15
      $this->SetFont( 'Arial', 'B', 10 );
      // Movernos a la derecha
      $this->Cell( 80 );
      // Títuloutf8_decode
      $this->Cell( 35, 5, utf8_decode( 'REFERENCIA MÉDICA' ), 0, 0, 'C' );
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

require_once "../model/Consultaseis.php";
$id = $_GET["id"];
$Consultaseis = new Consultaseis();
$rspta = $Consultaseis->datosReferencias($id);
$reg = $rspta->fetch_object();



$pdf->SetFont( 'Arial', 'B', 8 );
$pdf->SetFillColor( 255, 255, 255 );
$pdf->SetFont( 'Arial', 'B', 9 );
$pdf->Cell( 196, 5, utf8_decode('GENERADO EL - DÍA '.$sig), 0, 1, 'C' );
//$fecharegistro = $reg->fecha_reg;



$pdf->Ln();
$pdf->Ln();


$pdf->SetFont( 'Arial', 'B', 8 );
$pdf->SetFillColor( 255, 255, 255 );
$pdf->SetFont( 'Arial', 'B', 10 );
$pdf->Cell( 96, 5, utf8_decode("Paciente: "), 0, 0, 'L', 1 );

$pdf->SetFont( 'Arial', 'B', 8 );
$pdf->SetFillColor( 255, 255, 255 );
$pdf->SetFont( 'Arial', 'B', 10 );
$pdf->Cell( 96, 5, utf8_decode("Referido a: "), 0, 1, 'L', 1 );



$pdf->SetFont( 'Arial', '', 10 );
$pdf->Cell( 96, 5, utf8_decode($reg->paciente), 0, 0, 'L', 1 );
$pdf->SetFont( 'Arial', '', 10 );
$pdf->Cell( 96, 5, utf8_decode($reg->referir), 0, 1, 'L', 1 );




$pdf->SetFont( 'Arial', 'B', 8 );
$pdf->SetFillColor( 255, 255, 255 );
$pdf->SetFont( 'Arial', 'B', 10 );
$pdf->Cell( 96, 5, utf8_decode("Sexo: "), 0, 0, 'L', 1 );

$pdf->SetFont( 'Arial', 'B', 8 );
$pdf->SetFillColor( 255, 255, 255 );
$pdf->SetFont( 'Arial', 'B', 10 );
$pdf->Cell( 96, 5, utf8_decode("Institución: "), 0, 1, 'L', 1 );


$pdf->SetFont( 'Arial', '', 10 );
$pdf->Cell( 96, 5, utf8_decode($reg->sexo), 0, 0, 'L', 1 );
$pdf->SetFont( 'Arial', '', 10 );
$pdf->Cell( 96, 5, utf8_decode($reg->institucion), 0, 1, 'L', 1 );


$pdf->SetFont( 'Arial', 'B', 8 );
$pdf->SetFillColor( 255, 255, 255 );
$pdf->SetFont( 'Arial', 'B', 10 );
$pdf->Cell( 192, 5, utf8_decode("Fecha de nacimiento: "), 0, 1, 'L', 1 );
$pdf->SetFont( 'Arial', '', 10 );
$pdf->Cell( 96, 5, utf8_decode($reg->fechanac), 0, 1, 'L', 1 );

$pdf->SetFont( 'Arial', 'B', 8 );
$pdf->SetFillColor( 255, 255, 255 );
$pdf->SetFont( 'Arial', 'B', 10 );
$pdf->Cell( 192, 5, utf8_decode("Edad: "), 0, 1, 'L', 1 );
$pdf->SetFont( 'Arial', '', 10 );
$pdf->Cell( 192, 5, utf8_decode($reg->edad), 0, 1, 'L', 1 );

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont( 'Arial', 'B', 8 );
$pdf->SetFillColor( 255, 255, 255 );
$pdf->SetFont( 'Arial', 'B', 10 );
$pdf->Cell( 192, 5, utf8_decode("Diagnóstico: "), 0, 1, 'L', 1 );
$pdf->SetFont( 'Arial', '', 10 );
$pdf->MultiCell( 192, 5, utf8_decode($reg->motivo), 0, 1, 'L', 1 );

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont( 'Arial', 'B', 8 );
$pdf->SetFillColor( 255, 255, 255 );
$pdf->SetFont( 'Arial', 'B', 10 );
$pdf->Cell( 192, 5, utf8_decode("Historial/Antecedentes: "), 0, 1, 'L', 1 );
$pdf->SetFont( 'Arial', '', 10 );
$pdf->MultiCell( 192, 5, utf8_decode($reg->historial), 0, 1, 'L', 1 );


$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont( 'Arial', 'B', 8 );
$pdf->SetFillColor( 255, 255, 255 );
$pdf->SetFont( 'Arial', 'B', 10 );
$pdf->Cell( 192, 5, utf8_decode("Notas/Observaciones: "), 0, 1, 'L', 1 );
$pdf->SetFont( 'Arial', '', 10 );
$pdf->MultiCell( 192, 5, utf8_decode($reg->observaciones), 0, 1, 'L', 1 );


$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();


$pdf->SetFont( 'Arial', 'B', 10 );
$pdf->Cell( 192, 5, utf8_decode("______________________________________"), 0, 1, 'C', 1 );
$pdf->Cell( 192, 5, utf8_decode("Dr. ".$reg->medico), 0, 1, 'C', 1 );
$pdf->SetFont( 'Arial', '', 10 );
$pdf->Cell( 192, 5, utf8_decode("Colegiado No. ".$reg->numcolegiatura), 0, 1, 'C', 1 );

$pdf->Ln();
$pdf->Ln();



$sig = date( "d/m/Y");
$consultaprenatal ='consultaprenatal'.$sig;



//$pdf->Output();
//$pdf->Output($consultaprenatal.'.pdf','D'); 

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