<?php 

if(isset($_POST['create_pdf'])){


 $server = "localhost";
  $usuario = "root";
  $contra = "";
  $basedato = "profesorado_cef";
    $id_materia = $_GET['id_materia'];

$nro_orden =0;

   

    $con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $sql = $con->prepare('SELECT fecha,hora FROM calendario_examenes WHERE id_materia = :id_materia AND fecha > NOW() ORDER BY fecha DESC');

          $sql->execute(array(
            'id_materia' => $id_materia
            ));
        while ($datos=$sql->fetch(PDO::FETCH_ASSOC) ) {


			
        	$fecha = $datos['fecha'];
        
        	$hora = $datos['hora'];
        }



    	$sql=$con->prepare('SELECT id_calendario FROM calendario_examenes WHERE id_materia = :id_materia AND fecha = :fecha AND hora = :hora');
	$sql->execute(
		array(
		'id_materia' => $id_materia,
		'fecha' => $fecha,
		'hora' =>$hora
		));

	while($datos = $sql->fetch(PDO::FETCH_ASSOC)){


		$id_calendario = $datos['id_calendario'];
	}


		$sql = $con->prepare('
		SELECT nro_orden FROM orden_planillas WHERE id_materia = :id_materia AND id_calendario = :id_calendario
		');
	$sql->execute(
		array(
			'id_materia' => $id_materia,
			'id_calendario' => $id_calendario

			));

	 $resultado = $sql->fetchAll();

		if(empty($resultado)){ 



$sql= $con->prepare('SELECT id_contador FROM contador_planillas ORDER BY id_contador DESC'); 
	$sql->execute();

	$v = "true";
	while ($datos=$sql->fetch(PDO::FETCH_ASSOC)) {
		if($v == 'true'){

			$nro_orden = $datos['id_contador'];
			$v = 'false';
		}
		
	}

}
    else{

$nro_orden ="COPIA";


}







require_once('tcpdf/tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo




    	

        $image_file = K_PATH_IMAGES.'cef.jpeg';
        $this->Image($image_file, 6, 5, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
       

    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-20);
        // Set font
        $this->SetFont('helvetica', 'B', 8);
        // Page number
       
        $this->Cell(0, 15, ' PRESIDENTE ________________  VOCAL ______________', 0, false, 'L', 0, '', 0, false, 'M', 'M');


         $this->SetY(-10);
        // Set font
        $this->SetFont('helvetica', 'B', 8);
       
        $this->Cell(1, 15, ' TOTAL ALUMNOS______ / APROBADOS______ / APLAZADOS______  / AUSENTES______ /', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        


    }

}

// create new PDF document
//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SIPPA');
$pdf->SetTitle('ACTA DE EXAMEN NRO:'.$nro_orden);
$pdf->SetSubject('TCPDF Tutorial');



$pdf->SetMargins(20, 20, 8);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


$pdf->SetFont('Helvetica', 'B', 10);

// add a page
$pdf->AddPage();
 //$pdf->SetFont('helvetica', 'B', 20);


  $sql = $con->prepare('SELECT nombre FROM catedras WHERE id_materia = :id_materia');

          $sql->execute(array(
            'id_materia' => $id_materia
            ));
        while ($datos=$sql->fetch(PDO::FETCH_ASSOC) ) {
        	$materia = $datos['nombre'];
        }




         $sql = $con->prepare('SELECT fecha,hora FROM calendario_examenes WHERE id_materia = :id_materia AND fecha > NOW() ORDER BY fecha DESC');

          $sql->execute(array(
            'id_materia' => $id_materia
            ));
        while ($datos=$sql->fetch(PDO::FETCH_ASSOC) ) {


			
        	$fecha = $datos['fecha'];
        
        	$hora = $datos['hora'];
        }
       
        $pdf->Cell(0, 15, 'ASIGNATURA: '.$materia, 0, false, 'C', 0, '', 0, false, 'M', 'M');
       $pdf->SetY(15);

        $pdf->Cell(0, 15, 'ACTA DE EXAMEN NRO: '.$nro_orden.' - - -  FECHA: '.$fecha.'   HORA: '.$hora, 0, false, 'C', 0, '', 0, false, 'M', 'M');
       	
       	$pdf->SetY(10);

       $pdf->Cell(0, 15, 'I.S.F.D Ed. Fisica La Rioja', 0, false, 'C', 0, '', 0, false, 'M', 'M');



      $sql = $con->prepare('SELECT id_alumno FROM alumnos_examenes WHERE id_materia = :id_materia');

          $sql->execute(array(
            'id_materia' => $id_materia
            ));

      
        $cont =0;
       
        $n_y_a = [];
        $dni =[];
        $nombre_y_apellido = [];
        
        
        
        
            while ($datos = $sql->fetch(PDO::FETCH_ASSOC)) {
              $id_alumnos[$cont] = $datos['id_alumno'];
              
              
              $cont++;
            }



            $sql = $con->prepare('SELECT nombre_y_apellido,dni FROM alumnos   WHERE id_alumnos = :id_alumnos ' );



            for ($i=0; $i < $cont; $i++) { 

          
            $sql->execute(
              array(
                'id_alumnos' => $id_alumnos[$i]

                )
              );


               while ($datos = $sql->fetch(PDO::FETCH_ASSOC)) {

               	$nombre_y_apellido[$i] = $datos['nombre_y_apellido'];
   				$dni[$i] = $datos['dni'];
   				sort($dni);
   				sort($nombre_y_apellido);
	}

          }






// set some text to print
$content = '';
	
	$content .= '
	<div class="row justify-content-center ">
        	
       <h1 style="text-align:center; position-top:-10px;"></h1>
      <table   border="1" cellpadding="5" >
       <tr>

    
    <th style="width:45px;" rowspan="2">NRO</th>
    <td  style="width:275px;" rowspan="2">APELLIDO Y NOMBRE</td>
    <td style="width:150px;" colspan="3">CLASIFICACIONES</td>
    <td style="width:150px;" rowspan="2">DOCUMENTO</td>




  </tr>

  <tr>

  
    <th>ESC</th>
    <td>ORAL</td>
    <td>PROM</td>
     

  </tr>
	';


	  for ($i=0; $i < $cont ; $i++) { 
	   
	   $j = $i +1;

       $color= '#f5f5f5'; 
	$content .= '

  <tr>

    <th>'.$j.'</th>
    <th>'.$nombre_y_apellido[$i].' </th>
    <th> </th>
     <th>  </th>
    <th>   </th>
    <th>'.$dni[$i].'</th>


  </tr>

	';
	}
	
	$content .= '</table>';
	

	
	$pdf->writeHTML($content, true, 0, true, 0);

	$pdf->lastPage();
	$pdf->output('Planilla.pdf', 'I');


	$sql=$con->prepare('SELECT id_calendario FROM calendario_examenes WHERE id_materia = :id_materia AND fecha = :fecha AND hora = :hora');
	$sql->execute(
		array(
		'id_materia' => $id_materia,
		'fecha' => $fecha,
		'hora' =>$hora
		));

	while($datos = $sql->fetch(PDO::FETCH_ASSOC)){
		$id_calendario = $datos['id_calendario'];
	}


	$sql = $con->prepare('
		SELECT nro_orden FROM orden_planillas WHERE id_materia = :id_materia AND id_calendario = :id_calendario
		');
	$sql->execute(
		array(
			'id_materia' => $id_materia,
			'id_calendario' => $id_calendario

			));

	
	
		 $resultado = $sql->fetchAll();
		if(empty($resultado)){ 




	//CARGA NUMERO DE ORDEN EN TABLA ORDEN PLANILLA

		$sql = $con->prepare('
		INSERT INTO orden_planillas(nro_orden,id_calendario,id_materia) VALUES (:nro_orden,:id_calendario,:id_materia)'
		);


	$sql->execute(
		array(
				'nro_orden' =>$nro_orden,
				'id_calendario' => $id_calendario,
				'id_materia' => $id_materia
				
			));


	$sql = $con->prepare('
		INSERT INTO planilla_examenes(nro_orden,id_alumno,id_materia,id_calendario) VALUES (:nro_orden,:id_alumno,:id_materia,:id_calendario)'
		);


//CARGA ALUMNOS EN LA PLANILLA


	for($i=0; $i < $cont ; $i++) { 

	$sql->execute(
		array(
				'nro_orden' =>$nro_orden,
				'id_materia' =>$id_materia,
				'id_calendario' =>$id_calendario,
				'id_alumno' =>$id_alumnos[$i]
			));
}










//INCREMENTA NRO DE ORDEN

$i = $nro_orden +1 ;

$sql = $con->prepare(" 
		INSERT INTO contador_planillas(id_contador) VALUES (:i)"
		);
		$sql->execute(array(
			'i' => $i));

}



	
}



?>


		 
          
        
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Exportar a PDF - Miguel Angel Caro Rojas</title>
  <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" >

    <link rel="stylesheet" type="text/css" href="image/fonts/style.css">

</head>

<body>
  <div class="container">


  <br>
  <br>
  	<?php $h1 = "Acta de Examen Nro:234 ";
                  $h2 = "Materia Nro: ".$_GET['id_materia'];  
            
        ?>
        <h1><?php echo $h1; ?></h1>
        <br>
        <h2><?php echo $h2; ?></h2>
  <br>

<div class="row justify-content-center ">
    
         
   
  <table class="table">
    <thead class="thead-dark">
    <tr>
    

       <th scope="col">#NRO</th>
        
        <th scope="col"> NOMBRE Y APELLIDO</th>
     
        <th scope="col">DNI</th>
      
        


    </tr>
     </thead>
     <tbody>
   <?php 

 $server = "localhost";
  $usuario = "root";
  $contra = "";
  $basedato = "profesorado_cef";
    $id_materia = $_GET['id_materia'];




    $con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = $con->prepare('SELECT id_alumno FROM alumnos_examenes WHERE id_materia = :id_materia');

          $sql->execute(array(
            'id_materia' => $id_materia
            ));

      
        $cont =0;
        $dni = [];
        $n_y_a = [];
        $dni =[];
        $nombre_y_apellido = [];
        
        
        
        
            while ($datos = $sql->fetch(PDO::FETCH_ASSOC)) {
              $id_alumnos[$cont] = $datos['id_alumno'];
              
              
              $cont++;
            }



            $sql = $con->prepare('SELECT nombre_y_apellido,dni FROM alumnos  WHERE id_alumnos = :id_alumnos ORDER BY nombre_y_apellido DESC');



            for ($i=0; $i < $cont; $i++) { 

          
            $sql->execute(
              array(
                'id_alumnos' => $id_alumnos[$i]

                )
              );


               while ($datos = $sql->fetch(PDO::FETCH_ASSOC)) {

               	$nombre_y_apellido[$i] = $datos['nombre_y_apellido'];
   				$dni[$i] = $datos['dni'];

   				sort($dni);
   				sort($nombre_y_apellido);
	}

          }

			for ($i=0; $i <$cont ; $i++) { 
			 	
			    ?>
          <tr >
            <td><?php echo $i+1; ?></td>
            <td><?php echo $nombre_y_apellido[$i]; ?></td>
           
            <td> <?php echo $dni[$i]; ?> </td>
        
          </tr>
         <?php } ?>

  </tbody>

  </table>
  <form method="post">
                	<input type="hidden" name="reporte_name" value="<?php echo $h1; ?>">
                	<input type="submit" name="create_pdf" class="btn btn-danger pull-right" value="Generar PDF">
                </form>
</div>


  </div>

  </body>


</html>