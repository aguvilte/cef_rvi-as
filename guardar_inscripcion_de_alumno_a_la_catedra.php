<?php
$server = "localhost";
$usuario = "root";
$contra = "";
$basedato = "profesorado_cef";


$id_materia = $_GET['id_catedra'];
$id_alumno = $_GET['id_alumno'];

$c_regularizado[0] = '';
$c_aprobado[0] = '';

try {
  $con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = $con->prepare('SELECT c_regularizado,c_aprobado FROM correlatividades WHERE id_materia = '.$id_materia.'');
  $sql->execute();
    while($datos = $sql->fetch(PDO::FETCH_ASSOC)){
     $c_regularizado = @explode('-', $datos['c_regularizado']);
     $c_aprobado = @explode('-', $datos['c_aprobado']);
  
    }

	$contador=0;
	$contador1=0;

  foreach($c_regularizado as $llave => $valores) {
     
      $contador++;
  }
  foreach($c_aprobado as $llave => $valores1) {
      
      $contador1++;
  }

	$apto = "true";
  $sql = $con->prepare('SELECT condicion,id_materia FROM alumnos_catedras WHERE id_materia = :id_materia AND id_alumno = :id_alumno');
  
if($c_regularizado[0] != '') {
  
  for ($i=0; $i < $contador; $i++) {
  
    $sql->execute(array(':id_materia' => $c_regularizado[$i], ':id_alumno' => $id_alumno ));

    while( $datos = $sql->fetch(PDO::FETCH_ASSOC)){
 
   			 if($datos['condicion'] == "APROBADO") {
  
   			 }
    		else if($datos['condicion'] ==""){
      
      $apto = "false";
      $aviso = "DEBE PRIMEO REGULARIZAR LA MATERIA :".$c_regularizado[$i]."PARA PODER INSCRIBIRSE A ESTA MATERIA";
    }
    else{
       $apto = "false";
      $aviso = "DEBE PRIMEO REGULARIZAR LA MATERIA :".$c_regularizado[$i]."PARA PODER INSCRIBIRSE A ESTA MATERIA";
    }
  }
}}
    $sql = $con->prepare('SELECT nota,id_materia FROM historial_alumnos_catedras WHERE id_materia = :id_materia AND id_alumno = :id_alumno');
    	for ($i=0; $i < $contador1; $i++) {
  
      $sql->execute(array(':id_materia' => $c_aprobado[$i], ':id_alumno' => $id_alumno ));
      
      while( $datos = $sql->fetch(PDO::FETCH_ASSOC)) {
     
        if($datos['nota'] >= 4) {
         
        }
        else {
         
          $apto = "false";
          $aviso = ". DEBE PRIMERO APROBAR LA MATERIA : ".$c_aprobado[$i]." PARA PODER INSCRIBIRSE A ESTA MATERIA";
        }
      }
    }
  if($apto == "true" ){
   
    $sql = $con->prepare(
      'INSERT INTO alumnos_catedras (id_alumno,id_materia) VALUES (:alumno,:materia)'
    );
   
    if($sql->execute(array(':alumno'=>$id_alumno, ':materia'=> $id_materia))){
    	echo "USTED SE INSCRIBIO A LA MATERIA: ".$id_materia;
    }

  }

  else {
    echo "USTED NO SE PUEDEN INSCRIBIR A ESTA MATERIA ".$aviso;
  }
}
catch(PDOException $e) {
  echo 'ERROR...
  "USTED YA SE ENCUENTRA INSCRIPTO A ESTA MATERIA. "
  " O NO SE HA PODIDO ESTABLECER UNA CONEXION CON EL SERVIDOR"
  "INTENTELO MAS TARDE."';
}


 ?>