<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1)
  session_start();

if (!isset($_SESSION["nombre"])) {
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
} else {
  if ($_SESSION['pacientes'] == 1 || $_SESSION['medicos'] == 1) {

    require('../fpdf183/fpdf.php');

    class PDF extends FPDF
    {
      // Cabecera de página

      function Header()
      {

        //  $sig = date( "d/m/Y", strtotime( "+1 day" ) );

        $this->SetDrawColor(0, 80, 180);
        $this->SetFillColor(230, 230, 0);
        $this->SetTextColor(23, 32, 42);
        // Logo
        $this->Image( 'logo.jpeg', 10, 10, 50 );
        // Arial bold 15
        $this->SetFont('Arial', 'B', 10);
        // Movernos a la derecha
        $this->Cell(80);
        // Títuloutf8_decode
        $this->Cell(35, 5, utf8_decode('FICHA MEDICA'), 0, 0, 'C');
        $this->Cell(-119);
        $this->Cell(0, 15, utf8_decode('CENTRO MATERNO INFANTIL GÉNESIS'), 0, 0, 'C');

        // Salto de línea
        $this->Ln(10);
      }

      // Pie de página


    }
    date_default_timezone_set("America/Guatemala");
    $fechaActual = date('d-m-Y');
    $sig  = date('d/m/Y');

    $pdf = new PDF('p', 'mm', 'letter');
    $pdf->AliasNbPages();
    $pdf->AddPage();

    require_once "../model/Consultados.php";
    /*require_once "../model/Consultacinco.php";*/


    $id = $_GET["id"];
    $consultados = new Consultados();
    $rspta = $consultados->datosGeneralesPaciente($id);
    $reg = $rspta->fetch_object();


    $rspta1 = $consultados->historialMedicoPaciente($id);
    $reg1 = $rspta1->fetch_object();

    $rspta2 = $consultados->vacunasPaciente($id);
    $reg2 = $rspta2->fetch_object();
   
    //conulta ginecologica
    $rspta3 = $consultados->datosGinecologica($id);
    $reg3 = $rspta3->fetch_object();
     
    $rspta4 = $consultados->datosGinecologicaUna($id);
    $reg4 = $rspta4->fetch_object();
     
    $rspta5 = $consultados->datosGinecologicaConteo($id);
    $reg5 = $rspta5->fetch_object();

    //consulta pediatrica

    $rspta6 = $consultados->datosPediatrica($id);
    $reg6 = $rspta6->fetch_object();
     
    $rspta7 = $consultados->datosPediatricaUna($id);
    $reg7 = $rspta7->fetch_object();
     
    $rspta8 = $consultados->datosPediatricaConteo($id);
    $reg8 = $rspta8->fetch_object();




    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(196, 5, utf8_decode('GENERADO EL - DÍA ' . $sig), 0, 1, 'C');
    $fecharegistro = $reg->fecha_reg;
    $pdf->Cell(60, 5, utf8_decode("El paciente registrado el: " . $fecharegistro), 0, 1, 'L', 1);

    // Inserta un logo en la esquina superior izquierda a 300 ppp

    if($reg->imagen != null){

      $pdf->Image('../files/pacientes/' . $reg->imagen, 150, 18, -700, 20);
      // Inserta una imagen dinámica a través de una URL
    }



    $pdf->Ln();
    $pdf->Ln();





    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(193, 5, utf8_decode($reg->paciente), 0, 1, 'C');
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 9);

    $pdf->Cell(64, 5, utf8_decode("Fecha de nacimiento: " . $reg->fechanac), 1, 0, 'L', 1);
    $pdf->Cell(64, 5, utf8_decode("Edad: " . $reg->edad), 1, 0, 'L', 1);
    $pdf->Cell(64, 5, utf8_decode("Estado civil: " . $reg->estadocivil), 1, 1, 'L', 1);


    $pdf->Cell(64, 5, utf8_decode("Nacionalidad: " . $reg->nacionalidad), 1, 0, 'L', 1);
    $pdf->Cell(64, 5, utf8_decode("Sexo: " . $reg->sexo), 1, 0, 'L', 1);
    $pdf->Cell(64, 5, utf8_decode("Grupo Sanguineo: " . $reg->gsanguineo), 1, 1, 'L', 1);


    $pdf->Cell(64, 5, utf8_decode("Municipio: " . $reg->municipio), 1, 0, 'L', 1);
    $pdf->Cell(64, 5, utf8_decode("Dirección: " . $reg->direccion), 1, 0, 'L', 1);
    $pdf->Cell(64, 5, utf8_decode("Móvil: " . $reg->movil), 1, 1, 'L', 1);


    $pdf->Cell(64, 5, utf8_decode("Gmail: " . $reg->email), 1, 0, 'L', 1);
    $pdf->Cell(64, 5, utf8_decode("DPI: " . $reg->dni), 1, 0, 'L', 1);
    $pdf->Cell(64, 5, utf8_decode("Religión: " . $reg->religion), 1, 1, 'L', 1);

    $pdf->Cell(192, 5, utf8_decode("Seguros"), 1, 1, 'C', 1);
    $pdf->MultiCell(192, 5, utf8_decode($reg->seguros), 1, 1, 'J', 1);
 


    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(196, 5, utf8_decode("Información del contacto de emergencia"), 0, 1, 'C');
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(64, 5, utf8_decode("Encargado: " . $reg->encargado), 1, 0, 'L', 1);
    $pdf->Cell(64, 5, utf8_decode("Parentesco: " . $reg->enparentesco), 1, 0, 'L', 1);
    $pdf->Cell(64, 5, utf8_decode("Teléfono: " . $reg->entelreferencia), 1, 0, 'L', 1);


    $pdf->Ln();
    $pdf->Ln();
    $pdf->MultiCell(195, 5, utf8_decode("OBSERVACIONES: " . $reg->observaciones), 0, 1, 'J', 1);

    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 10);
    if (isset($reg1->idpaciente)) {
      $pdf->Cell(196, 5, utf8_decode("HISTORIAL CLÍNICO"), 0, 1, 'C');
      $pdf->SetFont('Arial', 'B', 10);
      $pdf->Ln();
      $pdf->Cell(196, 5, utf8_decode("Información general"), 0, 1, 'C');


      $pdf->SetFont('Arial', 'B', 9);

      $pdf->MultiCell(192, 5, utf8_decode("Enfermedad por la que ingreso: " . $reg1->enfermedadingreso), 1, 1, 'J', 1);
      $pdf->MultiCell(192, 5, utf8_decode("Antecedentes médicos: " . $reg1->antecedentesmedicos), 1, 1, 'J', 1);
      $pdf->MultiCell(192, 5, utf8_decode("Antecedentes quirúrgicos: " . $reg1->antecedentesquir), 1, 1, 'J', 1);
      $pdf->MultiCell(192, 5, utf8_decode("Antecedentes familiaress: " . $reg1->antecedentesfam), 1, 1, 'J', 1);
      $pdf->MultiCell(192, 5, utf8_decode("Alergias: " . $reg1->alergias), 1, 1, 'J', 1);
      $pdf->MultiCell(192, 5, utf8_decode("Medicamentos: " . $reg1->medicamentos), 1, 1, 'J', 1);
      $pdf->MultiCell(192, 5, utf8_decode("Hábitos: " . $reg1->habitos), 1, 1, 'J', 1);
      $pdf->MultiCell(192, 5, utf8_decode("Antecedentes prenatales: " . $reg1->antecedentespren), 1, 1, 'J', 1);
      $pdf->Ln();

      


      $pdf->SetFont('Arial', 'B', 10);
      $pdf->Cell(192, 7, utf8_decode('Vacunas'), 0, 1, 'C', 1);
      $pdf->SetFillColor(255, 255, 255);
      $pdf->Cell(6, 7, utf8_decode('No.'), 1, 0, 'C', 1);
      $pdf->Cell(92, 7, utf8_decode('Nombre'), 1, 0, 'C', 1);
      $pdf->Cell(94, 7, utf8_decode('Descripción'), 1, 1, 'C', 1);


      $increment = 1;
      while( $registro = $rspta2->fetch_array( MYSQLI_BOTH ) ) {
        $pdf->SetFillColor( 255, 255, 255 );
        $pdf->Cell( 6, 5, utf8_decode($increment), 1, 0, 'C', 1 );
        $pdf->Cell( 92, 5, utf8_decode( $registro['vacuna'] ), 1, 0, 'C', 1 );
        $pdf->Cell( 94, 5, utf8_decode( $registro['descripcion'] ), 1, 1, 'C', 1 );
        $increment++; 

   
      }
      //$pdf->Cell( 0, 10, 'Imprimiendo línea número '.$i, 0, 1 );


      $pdf->Ln();
      $pdf->SetFillColor(255, 255, 255);
      $pdf->SetFont('Arial', 'B', 10);
      $pdf->Cell(196, 5, utf8_decode("Información ginecológica"), 0, 1, 'C');
      $pdf->SetFont('Arial', 'B', 10);
      $pdf->Ln();
      $pdf->MultiCell(192, 5, utf8_decode("Antecedentes ginecológicos: " . $reg1->antecedentesgin), 1, 1, 'J', 1);
      $pdf->MultiCell(192, 5, utf8_decode("Gestas: " . $reg1->gestas), 1, 1, 'J', 1);

      $pdf->Cell(96, 5, utf8_decode("Hijos vivos: " . $reg1->hijosvivos), 1, 0, 'L', 1);
      $pdf->Cell(96, 5, utf8_decode("Hijos muertos: " . $reg1->hijosmuertos), 1, 1, 'L', 1);
      $pdf->Cell(62, 5, utf8_decode("Fecha último parto: " . $reg1->fultparto), 1, 0, 'L', 1);
      $pdf->Cell(68, 5, utf8_decode("Fecha último papanicolau: " . $reg1->fechapapanicolao), 1, 0, 'L', 1);
      $pdf->Cell(62, 5, utf8_decode("Estatura: " . $reg1->estatura), 1, 1, 'L', 1);
      $pdf->MultiCell(192, 5, utf8_decode("Ciclos: " . $reg1->ciclos), 1, 1, 'J', 1);
      $pdf->MultiCell(192, 5, utf8_decode("Planificación familiar: " . $reg1->planfam), 1, 1, 'J', 1);
      $pdf->MultiCell(192, 5, utf8_decode("Infecciones: " . $reg1->infecciones), 1, 1, 'J', 1);
      $pdf->MultiCell(192, 5, utf8_decode("Observaciones ginecológicas: " . $reg1->observacionesg), 1, 1, 'J', 1);

    } else {
      $pdf->Cell(196, 5, utf8_decode("NO CUENTA CON UN HISTORIAL CLÍNICO REGISTRADO"), 0, 1, 'C');
    }

    //consultas ginecologicas
    $pdf->Ln();
    $pdf->Ln();


    $pdf->Ln();
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(196, 5, utf8_decode("CONSULTAS GINECOLÓGICAS"), 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 10);


    if (isset($reg3->idcginecologica)) {

      $pdf->Ln();
      $pdf->SetFont( 'Arial', 'B', 10 );
      $pdf->Cell( 64, 5, utf8_decode("Fecha de registro: ".$reg4->fecha_reg), 0, 0, 'L', 1 );
      $pdf->Ln();
      $pdf->Ln();
      
      $pdf->SetFont( 'Arial', 'B', 9 );
      $pdf->Cell( 64, 5, utf8_decode("Edad: ".$reg4->edad), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Seguro: ".$reg4->seguro), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Próxima cita: ".$reg4->proximacita), 1, 1, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Presión arterial: ".$reg4->presionarterial), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Frecuencia cardíaca: ".$reg4->frecuenciacardiaca), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Frecuencia respiratoria: ".$reg4->frecuenciarespiratoria), 1, 1, 'L', 1 );
      $pdf->Cell( 96, 5, utf8_decode("Peso: ".$reg4->peso), 1, 0, 'L', 1 );
      $pdf->Cell( 96, 5, utf8_decode("Temperatura: ".$reg4->temperatura), 1, 1, 'L', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Fecha última regla"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg4->fur), 1, 1, 'J', 1 );
      
      $pdf->Cell( 192, 5, utf8_decode("Motivo consulta"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg4->motivoconsulta), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Historia de la enfermedad"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg4->historia), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Examen físico"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg4->examenfisico), 1, 1, 'J', 1 );
      $pdf->SetFont( 'Arial', 'B', 9 );
      $pdf->Cell( 192, 5, utf8_decode("Descripción de resultado examen"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg4->descripcionresexadiag), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Ultrasonido Pélvico"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg4->ultrasonidopelvico), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Impresión clínica"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg4->impresionclinica), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Tratamiento"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg4->tratamiento), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Orden de examen de diagnóstico"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg4->ordendeexamendiagnostico), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Observaciones"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg4->observaciones), 1, 1, 'J', 1 );
      $pdf->Ln();

      $incremento = 0;
      while( $registro1 = $rspta3->fetch_array( MYSQLI_BOTH ) ) {
        $pdf->SetFont( 'Arial', 'B', 10 );
        $pdf->Cell( 64, 5, utf8_decode("Fecha de registro: ".$registro1['fecha_reg'] ), 0, 0, 'L', 1 );
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont( 'Arial', 'B', 9 );
        $pdf->Cell( 64, 5, utf8_decode("Edad: ".$registro1['edad'] ), 1, 0, 'L', 1 );
        $pdf->Cell( 64, 5, utf8_decode("Seguro: ".$registro1['seguro']), 1, 0, 'L', 1 );
        $pdf->Cell( 64, 5, utf8_decode("Próxima cita: ".$registro1['proximacita']), 1, 1, 'L', 1 );
        $pdf->Cell( 64, 5, utf8_decode("Presión arterial: ".$registro1['presionarterial']), 1, 0, 'L', 1 );
        $pdf->Cell( 64, 5, utf8_decode("Frecuencia cardíaca: ".$registro1['frecuenciacardiaca'] ), 1, 0, 'L', 1 );
        $pdf->Cell( 64, 5, utf8_decode("Frecuencia respiratoria: ".$registro1['frecuenciarespiratoria']), 1, 1, 'L', 1 );
        $pdf->Cell( 96, 5, utf8_decode("Peso: ".$registro1['peso']), 1, 0, 'L', 1 );
        $pdf->Cell( 96, 5, utf8_decode("Temperatura: ".$registro1['temperatura']), 1, 1, 'L', 1 );
        $pdf->Cell( 192, 5, utf8_decode("Fecha última regla"), 1, 1, 'C', 1 );
        $pdf->MultiCell( 192, 5, utf8_decode($registro1['fur']), 1, 1, 'J', 1 );
        $pdf->Cell( 192, 5, utf8_decode("Motivo consulta"), 1, 1, 'C', 1 );
        $pdf->MultiCell( 192, 5, utf8_decode($registro1['motivoconsulta']), 1, 1, 'J', 1 );
        $pdf->Cell( 192, 5, utf8_decode("Historia de la enfermedad"), 1, 1, 'C', 1 );
        $pdf->MultiCell( 192, 5, utf8_decode($registro1['historia']), 1, 1, 'J', 1 );
        $pdf->Cell( 192, 5, utf8_decode("Examen físico"), 1, 1, 'C', 1 );
        $pdf->MultiCell( 192, 5, utf8_decode($registro1['examenfisico']), 1, 1, 'J', 1 );
        $pdf->SetFont( 'Arial', 'B', 9 );
        $pdf->Cell( 192, 5, utf8_decode("Descripción de resultado examen"), 1, 1, 'C', 1 );
        $pdf->MultiCell( 192, 5, utf8_decode($registro1['descripcionresexadiag']), 1, 1, 'J', 1 );
        $pdf->Cell( 192, 5, utf8_decode("Ultrasonido Pélvico"), 1, 1, 'C', 1 );
        $pdf->MultiCell( 192, 5, utf8_decode($registro1['ultrasonidopelvico']), 1, 1, 'J', 1 );
        $pdf->Cell( 192, 5, utf8_decode("Impresión clínica"), 1, 1, 'C', 1 );
        $pdf->MultiCell( 192, 5, utf8_decode($registro1['impresionclinica']), 1, 1, 'J', 1 );
        $pdf->Cell( 192, 5, utf8_decode("Tratamiento"), 1, 1, 'C', 1 );
        $pdf->MultiCell( 192, 5, utf8_decode($registro1['tratamiento']), 1, 1, 'J', 1 );
        $pdf->Cell( 192, 5, utf8_decode("Orden de examen de diagnóstico"), 1, 1, 'C', 1 );
        $pdf->MultiCell( 192, 5, utf8_decode($registro1['ordendeexamendiagnostico']), 1, 1, 'J', 1 );
        $pdf->Cell( 192, 5, utf8_decode("Observaciones"), 1, 1, 'C', 1 );
        $pdf->MultiCell( 192, 5, utf8_decode($registro1['observaciones']), 1, 1, 'J', 1 );
        $pdf->Ln();
        $incremento++; 
      }
    }elseif($reg5->contador == 1){
      $pdf->Ln();
      $pdf->SetFont( 'Arial', 'B', 10 );
      $pdf->Cell( 64, 5, utf8_decode("Fecha de registro: ".$reg4->fecha_reg), 0, 0, 'L', 1 );
      $pdf->Ln();
      $pdf->Ln();
      
      $pdf->SetFont( 'Arial', 'B', 9 );
      $pdf->Cell( 64, 5, utf8_decode("Edad: ".$reg4->edad), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Seguro: ".$reg4->seguro), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Próxima cita: ".$reg4->proximacita), 1, 1, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Presión arterial: ".$reg4->presionarterial), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Frecuencia cardíaca: ".$reg4->frecuenciacardiaca), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Frecuencia respiratoria: ".$reg4->frecuenciarespiratoria), 1, 1, 'L', 1 );
      $pdf->Cell( 96, 5, utf8_decode("Peso: ".$reg4->peso), 1, 0, 'L', 1 );
      $pdf->Cell( 96, 5, utf8_decode("Temperatura: ".$reg4->temperatura), 1, 1, 'L', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Fecha última regla"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg4->fur), 1, 1, 'J', 1 );
      
      $pdf->Cell( 192, 5, utf8_decode("Motivo consulta"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg4->motivoconsulta), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Historia de la enfermedad"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg4->historia), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Examen físico"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg4->examenfisico), 1, 1, 'J', 1 );
      $pdf->SetFont( 'Arial', 'B', 9 );
      $pdf->Cell( 192, 5, utf8_decode("Descripción de resultado examen"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg4->descripcionresexadiag), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Ultrasonido Pélvico"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg4->ultrasonidopelvico), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Impresión clínica"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg4->impresionclinica), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Tratamiento"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg4->tratamiento), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Orden de examen de diagnóstico"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg4->ordendeexamendiagnostico), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Observaciones"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg4->observaciones), 1, 1, 'J', 1 );
      $pdf->Ln();



    } 
    
    
    else {
      $pdf->Cell(196, 5, utf8_decode("NO CUENTA CON CONSULTAS GINECOLÓGICAS"), 0, 1, 'C');
    }


    //consultas pediatricas
    
    $pdf->Ln();
    $pdf->Ln();


    $pdf->Ln();
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(196, 5, utf8_decode("CONSULTAS PEDIÁTRICAS"), 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 10);


    if (isset($reg6->idcpediatrica)) {

      $pdf->Ln();
      $pdf->SetFont( 'Arial', 'B', 10 );
      $pdf->Cell( 64, 5, utf8_decode("Fecha de registro: ".$reg7->fecha_reg), 0, 0, 'L', 1 );
      $pdf->Ln();
      $pdf->Ln();
      
      $pdf->SetFont( 'Arial', 'B', 9 );
      $pdf->Cell( 64, 5, utf8_decode("Edad: ".$reg7->edad), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Seguro: ".$reg7->seguro), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Próxima cita: ".$reg7->proximacita), 1, 1, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Presión arterial: ".$reg7->presionarterial), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Frecuencia cardíaca: ".$reg7->frecuenciacardiaca), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Frecuencia respiratoria: ".$reg7->frecuenciarespiratoria), 1, 1, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Peso: ".$reg7->peso), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Temperatura: ".$reg7->temperatura), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Estatura: ".$reg7->estatura), 1, 1, 'L', 1 );
            
      $pdf->Cell( 192, 5, utf8_decode("Motivo consulta"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg7->motivoconsulta), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Historia de la enfermedad"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg7->historia), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Examen dental"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg7->examendental), 1, 1, 'J', 1 );
      $pdf->SetFont( 'Arial', 'B', 9 );
      $pdf->Cell( 192, 5, utf8_decode("Descripción de resultado examen"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg7->descripcionresexadiag), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Adecuación"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg7->adecuacion), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Impresión clínica"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg7->impresionclinica), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Tratamiento"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg7->tratamiento), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Orden de examen de diagnóstico"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg7->ordendeexamendiagnostico), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Observaciones"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg7->observaciones), 1, 1, 'J', 1 );
      $pdf->Ln();

      $incremento = 0;
      while( $registro1 = $rspta6->fetch_array( MYSQLI_BOTH ) ) {
        $pdf->SetFont( 'Arial', 'B', 10 );
        $pdf->Cell( 64, 5, utf8_decode("Fecha de registro: ".$registro1['fecha_reg'] ), 0, 0, 'L', 1 );
        //
        
      $pdf->Ln();
      $pdf->SetFont( 'Arial', 'B', 10 );
      $pdf->Cell( 64, 5, utf8_decode("Fecha de registro: ".$registro1['fecha_reg']), 0, 0, 'L', 1 );
      $pdf->Ln();
      $pdf->Ln();
      
      $pdf->SetFont( 'Arial', 'B', 9 );
      $pdf->Cell( 64, 5, utf8_decode("Edad: ".$registro1['edad'] ), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Seguro: ".$registro1['seguro']), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Próxima cita: ".$registro1['proximacita']), 1, 1, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Presión arterial: ".$registro1['presionarterial']), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Frecuencia cardíaca: ".$registro1['frecuenciacardiaca']), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Frecuencia respiratoria: ".$registro1['frecuenciarespiratoria']), 1, 1, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Peso: ".$registro1['peso']), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Temperatura: ".$registro1['temperatura']), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Estatura: ".$registro1['estatura']), 1, 1, 'L', 1 );
      
      $pdf->Cell( 192, 5, utf8_decode("Motivo consulta"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($registro1['motivoconsulta']), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Historia de la enfermedad"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($registro1['historia']), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Examen dental"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($registro1['examendental']), 1, 1, 'J', 1 );
      $pdf->SetFont( 'Arial', 'B', 9 );
      $pdf->Cell( 192, 5, utf8_decode("Descripción de resultado examen"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($registro1['descripcionresexadiag']), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Adecuación"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($registro1['adecuacion']), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Impresión clínica"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($registro1['impresionclinica']), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Tratamiento"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($registro1['tratamiento']), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Orden de examen de diagnóstico"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($registro1['ordendeexamendiagnostico']), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Observaciones"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($registro1['observaciones']), 1, 1, 'J', 1 );
        $pdf->Ln();
        $incremento++; 
      }
    }elseif($reg8->contador == 1){
     
      $pdf->Ln();
      $pdf->SetFont( 'Arial', 'B', 10 );
      $pdf->Cell( 64, 5, utf8_decode("Fecha de registro: ".$reg7->fecha_reg), 0, 0, 'L', 1 );
      $pdf->Ln();
      $pdf->Ln();
      
      $pdf->SetFont( 'Arial', 'B', 9 );
      $pdf->Cell( 64, 5, utf8_decode("Edad: ".$reg7->edad), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Seguro: ".$reg7->seguro), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Próxima cita: ".$reg7->proximacita), 1, 1, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Presión arterial: ".$reg7->presionarterial), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Frecuencia cardíaca: ".$reg7->frecuenciacardiaca), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Frecuencia respiratoria: ".$reg7->frecuenciarespiratoria), 1, 1, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Peso: ".$reg7->peso), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Temperatura: ".$reg7->temperatura), 1, 0, 'L', 1 );
      $pdf->Cell( 64, 5, utf8_decode("Estatura: ".$reg7->estatura), 1, 1, 'L', 1 );
      
      $pdf->Cell( 192, 5, utf8_decode("Motivo consulta"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg7->motivoconsulta), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Historia de la enfermedad"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg7->historia), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Examen dental"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg7->examendental), 1, 1, 'J', 1 );
      $pdf->SetFont( 'Arial', 'B', 9 );
      $pdf->Cell( 192, 5, utf8_decode("Descripción de resultado examen"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg7->descripcionresexadiag), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Adecuación"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg7->adecuacion), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Impresión clínica"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg7->impresionclinica), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Tratamiento"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg7->tratamiento), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Orden de examen de diagnóstico"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg7->ordendeexamendiagnostico), 1, 1, 'J', 1 );
      $pdf->Cell( 192, 5, utf8_decode("Observaciones"), 1, 1, 'C', 1 );
      $pdf->MultiCell( 192, 5, utf8_decode($reg7->observaciones), 1, 1, 'J', 1 );
      $pdf->Ln();


    } 
    
    
    else {
      $pdf->Cell(196, 5, utf8_decode("NO CUENTA CON CONSULTAS PEDIÁTRICAS"), 0, 1, 'C');
    }




    $sig = date("d/m/Y");
    $historialmedico = 'historialmedico' . $sig;



    //$pdf->Output();
    //$pdf->Output($historialmedico . '.pdf', 'D');

    $pdf->Output(); 

?>
<?php

  } else {
    echo 'No tiene permiso para visualizar el reporte';
  }
}
ob_end_flush();
?>