<?php 

    session_start();
$nombre_y_apellido = [];	
    if ($_SESSION['perfil'] == 'Alumno') {





    $server = "localhost";
  $usuario = "root";
  $contra = "";
  $basedato = "profesorado_cef";
 
  $id_alumno = $_GET['id_alumno'];
  $id_materia = $_GET['id_materia'];




 $dni = $_SESSION['dni'];


   $con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = $con->prepare('SELECT nombre_y_apellido FROM alumnos WHERE id_alumnos = :id_alumno');
    $sql->execute(array(
        'id_alumno' => $id_alumno
      ));

    $i=0;
      while ($datos = $sql->fetch(PDO::FETCH_ASSOC)) {
     	
     	 $nombre_y_apellido= $datos['nombre_y_apellido'];

     
      }


      	  $sql = $con->prepare('SELECT condicion FROM alumnos_catedras WHERE id_alumno = :id_alumno');
    $sql->execute(array(
        'id_alumno' => $id_alumno
      ));

    $i=0;
      while ($datos = $sql->fetch(PDO::FETCH_ASSOC)) {
     	
     	 $condicion= $datos['condicion'];

     
      }





      $sql = $con->prepare('
      		SELECT nombre FROM catedras WHERE id_materia = :id_materia;
      	');

      $sql->execute(
      	array(
   			'id_materia'  => $id_materia
      		));

      while ($datos = $sql->fetch(PDO::FETCH_ASSOC)) {
     	
    
     	$nombre = $datos['nombre'];
     }


     $sql = $con->prepare('SELECT fecha,hora FROM calendario_examenes WHERE id_materia = :id_materia AND fecha > NOW() ORDER BY fecha DESC');

          $sql->execute(array(
            'id_materia' => $id_materia
            ));
        while ($datos=$sql->fetch(PDO::FETCH_ASSOC) ) {


			
        	$fecha = $datos['fecha'];
        
        	$hora = $datos['hora'];
        }


require_once('tcpdf/tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'cef.jpeg';
        $this->Image($image_file, 6, 5, 15, '', 'JPG', '', 'T', false, 600, '', false, false, 0, false, false, false);
        // Set font
       

    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-20);
        // Set font
        $this->SetFont('helvetica', 'B', 8);
        // Page number
       
        $this->Cell(0, 15, ' ESTE COMPROBANTE ESTA CERTIFICADO POR POR EL SIPPA Y EL I.S.F.D ', 0, false, 'L', 0, '', 0, false, 'M', 'M');



    }

}

// create new PDF document
//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SIPPA');
$pdf->SetTitle('CERTIFICADO');
$pdf->SetSubject('SIPPA');



$pdf->SetMargins(20, 20, 8);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



	$hora_actual = date("Y-m-d G:i:s");
// add a page
$pdf->AddPage();
 //$pdf->SetFont('helvetica', 'B', 20);

       
        $pdf->SetFont('Helvetica', 'U', 12);
        $pdf->Cell(0, 15, 'COMPROBANTE DE EXAMEN FINAL DE LA CATEDRA: '.$id_materia.' ', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        
        $pdf->SetY(10);

       $pdf->Cell(0, 15, 'I.S.F.D ED. FISICA LA RIOJA ', 0, false, 'C', 0, '', 0, false, 'M', 'M');

$pdf->SetFont('Helvetica', '', 12	);

        $pdf->SetY(25);

// set some text to print
$content = '';
  
  $content .= '
  <div class="row justify-content-center ">
          
       <h1 style="text-align:center; position-top:-10px;"></h1>
   

       	<p> NOMBRE DE LA MATERIA: '.$nombre.'</p>
     	<p> NOMBRE DEL EXAMEN FINAL: '.$fecha.'</p>
        <p> HORA DEL EXAMEN FINAL: '.$hora.'</p>
        <p> CONDICION: '.$condicion.'</p>

         <p> FECHA Y HORA DE REGISTRO: '.$hora_actual.'</p>
		
    

 
';




  
  $pdf->writeHTML($content, true, 0, true, 0);

  $pdf->lastPage();
  $pdf->output('Acta_de_regularidad.pdf', 'I');









}
else{

header("location:pagina_principal.php");
}















 ?>