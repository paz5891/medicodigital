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
      $this->Cell( 35, 5, utf8_decode( 'CONSULTA PRENATAL' ), 0, 0, 'C' );
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

require_once "../model/Consultatres.php";
$id = $_GET["id"];
$consultatres = new Consultatres();
$rspta = $consultatres->datosEmbarazo($id);
$reg = $rspta->fetch_object();



$pdf->SetFont( 'Arial', 'B', 8 );
$pdf->SetFillColor( 255, 255, 255 );
$pdf->SetFont( 'Arial', 'B', 9 );
$pdf->Cell( 196, 5, utf8_decode('GENERADO EL - DÍA '.$sig), 0, 1, 'C' );
$fecharegistro = $reg->fecha_reg;

$pdf->Ln();
$pdf->Ln();




$pdf->SetFont( 'Arial', 'B', 8 );
$pdf->SetFillColor( 255, 255, 255 );
$pdf->SetFont( 'Arial', 'B', 10 );
$pdf->Cell( 196, 5, utf8_decode($reg->paciente), 0, 1, 'C' );
$pdf->Ln();

$pdf->Cell( 64, 5, utf8_decode("Fecha de registro: ".$reg->fecha_reg), 0, 0, 'L', 1 );
$pdf->Ln();
$pdf->Ln();


$pdf->SetFont( 'Arial', 'B', 9 );
$pdf->Cell( 64, 5, utf8_decode("Edad: ".$reg->edad), 1, 0, 'L', 1 );
$pdf->Cell( 64, 5, utf8_decode("Edad gestacional actual: ".$reg->edadgestacionalactual), 1, 0, 'L', 1 );
$pdf->Cell( 64, 5, utf8_decode("Peso: ".$reg->peso), 1, 1, 'L', 1 );

$pdf->Cell( 64, 5, utf8_decode("Estatura: ".$reg->estatura), 1, 0, 'L', 1 );
$pdf->Cell( 64, 5, utf8_decode("Temperatura: ".$reg->temperatura), 1, 0, 'L', 1 );
$pdf->Cell( 64, 5, utf8_decode("Presión arterial: ".$reg->presionarterial), 1, 1, 'L', 1 );

$pdf->Cell( 48, 5, utf8_decode("Frecuencia cardíaca: ".$reg->frecuenciacardiaca), 1, 0, 'L', 1 );
$pdf->Cell( 48, 5, utf8_decode("Frecuencia respiratoria: ".$reg->frecuenciarespiratoria), 1, 0, 'L', 1 );
$pdf->Cell( 48, 5, utf8_decode("Seguro: ".$reg->seguro), 1, 0, 'L', 1 );

$pdf->Cell( 48, 5, utf8_decode("Próxima cita: ".$reg->proximacita), 1, 1, 'L', 1 );



$pdf->SetFont( 'Arial', 'B', 9 );
$pdf->Cell( 192, 5, utf8_decode("Historia de la enfermedad"), 1, 1, 'C', 1 );
$pdf->MultiCell( 192, 5, utf8_decode($reg->historia), 1, 1, 'J', 1 );
$pdf->SetFont( 'Arial', 'B', 9 );
$pdf->Cell( 192, 5, utf8_decode("Examen de mamas"), 1, 1, 'C', 1 );
$pdf->MultiCell( 192, 5, utf8_decode($reg->examenmamas), 1, 1, 'J', 1 );
$pdf->Cell( 192, 5, utf8_decode("Examen ginecológico"), 1, 1, 'C', 1 );
$pdf->MultiCell( 192, 5, utf8_decode($reg->examenginec), 1, 1, 'J', 1 );
$pdf->Cell( 192, 5, utf8_decode("Examen físico"), 1, 1, 'C', 1 );
$pdf->MultiCell( 192, 5, utf8_decode($reg->examenfisico), 1, 1, 'J', 1 );
$pdf->Cell( 192, 5, utf8_decode("Descripción de resultado examen"), 1, 1, 'C', 1 );
$pdf->MultiCell( 192, 5, utf8_decode($reg->descripcionresexadiag), 1, 1, 'J', 1 );


$pdf->Cell( 192, 5, utf8_decode("Ultrasonido Obstétrico"), 1, 1, 'C', 1 );
$pdf->MultiCell( 192, 5, utf8_decode($reg->ultrasonidostretico), 1, 1, 'J', 1 );
$pdf->Cell( 192, 5, utf8_decode("Impresión clinica"), 1, 1, 'C', 1 );
$pdf->MultiCell( 192, 5, utf8_decode($reg->impresionclinica), 1, 1, 'J', 1 );
$pdf->Cell( 192, 5, utf8_decode("Tratamiento"), 1, 1, 'C', 1 );
$pdf->MultiCell( 192, 5, utf8_decode($reg->tratamiento), 1, 1, 'J', 1 );
$pdf->Cell( 192, 5, utf8_decode("Orden de examen de diagnóstico"), 1, 1, 'C', 1 );
$pdf->MultiCell( 192, 5, utf8_decode($reg->ordendeexamendiagnostico), 1, 1, 'J', 1 );


$pdf->Cell( 192, 5, utf8_decode("Observaciones"), 1, 1, 'C', 1 );
$pdf->MultiCell( 192, 5, utf8_decode($reg->observaciones), 1, 1, 'J', 1 );

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