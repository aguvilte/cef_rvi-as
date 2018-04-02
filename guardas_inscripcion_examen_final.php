<?php 




 $server = "localhost";
  $usuario = "root";
  $contra = "";
  $basedato = "profesorado_cef";

  $id_materia = $_GET['id_materia'];

  $fecha_examen = $_GET['fecha_examen'];
  $fecha_y_hora_actual = $_GET['fecha_y_hora_actual'];
  $condicion = $_GET['condicion'];
  $id_alumno = $_GET['id_alumno'];




  	$a_aprobado[0] = '';
	   $apto = "false";
     $apto1 = "false";
     $aviso="";

  try {
    $con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



     $cadena = "SELECT r_evaluacion FROM catedras WHERE id_materia = :id_materia";
    $sql = $con->prepare($cadena);
    $sql->execute(
      array(
          'id_materia' => $id_materia
        ));
    
    while ($datos = $sql->fetch(PDO::FETCH_ASSOC)) {
      $r_evaluacion = @explode('-', $datos['r_evaluacion']);
      
    }

    $i=0;
    $cont="";
    $aviso.="PORQUE SOLO ADMITE CONDICION: ";
     foreach($r_evaluacion as $llave => $valores) {
     
  
   $cont[$i] = $valores;

     $aviso.=" ".$cont[$i]."-";


    if($cont[$i] != $condicion ){
      $apto = "false";
    }
    else{
      //$apto="true";
      $apto1 = "true";


    }
    
   $i++;

  }






    $cadena = "SELECT a_aprobado FROM correlatividades WHERE id_materia = :id_materia";
    $sql = $con->prepare($cadena);
    $sql->execute(
    	array(
          'id_materia' => $id_materia
        ));

  // echo  $cadena;


     while($datos = $sql->fetch(PDO::FETCH_ASSOC)){
    $a_aprobado = @explode('-', $datos['a_aprobado']);

    
  
    }



    $contador=0;


  foreach($a_aprobado as $llave => $valores) {
     
      $contador++;

  }



	
  $sql = $con->prepare('SELECT nota FROM historial_alumnos_catedras WHERE id_materia = :id_materia AND id_alumno = :id_alumno');
  
if($a_aprobado[0] != '') {


  
  for ($i=0; $i < $contador; $i++) {
  
    $sql->execute(array(':id_materia' => $a_aprobado[$i], ':id_alumno' => $id_alumno ));

    while( $datos = $sql->fetch(PDO::FETCH_ASSOC)){
 
   			 if($datos['nota'] >= 4) {
  			


   			 }
    		else {
      
      $apto1 = "false";
      $aviso = "DEBE PRIMEO AROBAR LA MATERIA :".$a_aprobado[$i]."PARA PODER INSCRIBIRSE A ESTA MATERIA";
    }
  }
}}


	$cadena ="";

		if($apto1 == "true" ){

		$sql = $con->prepare('SELECT nombre FROM catedras WHERE id_materia = :id_materia');
		$sql->execute(array(
			'id_materia' => $id_materia

			));	

		while ($datos = $sql->fetch(PDO::FETCH_ASSOC)) {
			$nombre_materia = $datos['nombre'];
			 
		}

  }

  else {
   $cadena.="USTED NO SE PUEDEN INSCRIBIR A ESTA MATERIA ".$aviso;
  }


  if($apto1 == "true" ){

  $sql = $con->prepare(
      'INSERT INTO alumnos_examenes (id_alumno,id_materia) VALUES (:alumno,:materia)'
    );

  


   
    if($sql->execute(array(':alumno'=>$id_alumno, ':materia'=> $id_materia)))
    {

     
 
    $cadena.="
<div id='comprobante' class='form-conatiner'>
<div class='card text-center'>
  <div class='card-header'>
    COMPROBANTE
  </div>
  <div class='card-body'>
    <h4 class='card-title'>ALUMNO ".$id_alumno."</h4>
    <p class='card-text'>MATERIA: ".$nombre_materia."</p>
    <p class='card-text'>fECHA DE EXAMEN: ".$fecha_examen."</p>
    
    <p class='card-text'>FECHA DE REGISTRO: ".$fecha_y_hora_actual."</p>
    <p class='card-text'>CONDICION: ".$condicion."</p>

<a href='' class='btn btn-primary'>Imprimir</a>
  </div>
  <div class='card-footer text-muted'>
    PROFESORADO CEF5
  </div>
</div>
</div>";
    }
    else{

    	$cadena.= 'ERROR...
  "USTED YA SE ENCUENTRA INSCRIPTO A ESTA MATERIA. "
  " O NO SE HA PODIDO ESTABLECER UNA CONEXION CON EL SERVIDOR"
  "INTENTELO MAS TARDE."';

    }


  	
}
}




   
  catch(PDOException $e) {

  	$cadena.= 'ERROR...
  "USTED YA SE ENCUENTRA INSCRIPTO A ESTA MATERIA. "
  " O NO SE HA PODIDO ESTABLECER UNA CONEXION CON EL SERVIDOR"
  "INTENTELO MAS TARDE."';
    
  }


echo $cadena;









 ?>