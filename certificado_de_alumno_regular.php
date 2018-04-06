<?php 



    session_start();

    if ($_SESSION['perfil'] == 'Alumno') {





    $server = "localhost";
  $usuario = "root";
  $contra = "";
  $basedato = "profesorado_cef";
  $dni = "";
  $nombre_y_apellido = "";
  $matricula ="";


 $dni = $_SESSION['dni'];


    $con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = $con->prepare('SELECT id_alumnos FROM alumnos WHERE dni = :dni');
    $sql->execute(array(
        'dni' => $dni
      ));

      while ($datos = $sql->fetch(PDO::FETCH_ASSOC)) {
      $id_alumno= $datos['id_alumnos'];
      }


  try {
    $con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    $sql = $con->prepare(
      'SELECT dni,nombre_y_apellido,matricula FROM alumnos WHERE id_alumnos = :id_alumno'
    );

    $sql->execute(
      array(
        'id_alumno' => $id_alumno
        ));

    while ($datos = $sql->fetch(PDO::FETCH_ASSOC)) {
      
      $nombre_y_apellido = $datos['nombre_y_apellido'];
      $dni = $datos['dni'];
      $matricula = $datos['matricula'];
    }




    $numero = [];


for ($i=0; $i < 4; $i++) { 
  $n = rand(0,60);

  $numero[$i] = $n;
}

$num = "";

for ($i=0; $i < 4; $i++) { 

       $num.="".$numero[$i];

  }

$sql = $con->prepare('INSERT INTO comprobante_certificado(numero) VALUES (:numero)');

$sql->execute(
  array(
    'numero' => $num
    )
  );




  } catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }



}
else{

header("location:pagina_principal.php");
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
       
        $this->Cell(0, 15, ' FIRMA ________________  ', 0, false, 'L', 0, '', 0, false, 'M', 'M');



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




// add a page
$pdf->AddPage();
 //$pdf->SetFont('helvetica', 'B', 20);

       
        $pdf->SetFont('Helvetica', 'U', 12);
        $pdf->Cell(0, 15, 'CERTIFICADO DE ALUMNO REGULAR: ', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        
        $pdf->SetY(10);

       $pdf->Cell(0, 15, 'I.S.F.D ED. FISICA LA RIOJA ', 0, false, 'C', 0, '', 0, false, 'M', 'M');

$pdf->SetFont('Helvetica', '', 17);

        $pdf->SetY(50);

// set some text to print
$content = '';
  
  $content .= '
  <div class="row justify-content-center ">
          
       <h1 style="text-align:center; position-top:-10px;"></h1>
   



      <P>El Instituo Superior de Ed Fisica - La Rioja - Capital, certifica que el Alumno:'.$nombre_y_apellido.'  Con dni:'.$dni.' , se encuentra actualmente regular en la carrera de Profesorado de Educacion Fisica. A su pedido y para ser presentado ante quien corresponda se extiende el presente en la ciudad de La Rioja  a los 12 dias del mes de marzo de 2018 </P>

 
';


  
      $pdf->SetY(50);
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->Cell(0, 15, 'COMPROBANTE:'.$num.' ', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        
  

  
  $pdf->writeHTML($content, true, 0, true, 0);

  $pdf->lastPage();
  $pdf->output('Acta_de_regularidad.pdf', 'I');








 ?>