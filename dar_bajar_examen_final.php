<?php 


	 $server = "localhost";
  $usuario = "root";
  $contra = "";
  $basedato = "profesorado_cef";

  $id_materia = $_GET['id_materia'];
  $id_alumno = $_GET['id_alumno'];




try {
    $con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



     $cadena = "DELETE FROM alumnos_examenes WHERE id_materia = :id_materia AND id_alumno = :id_alumno";
    $sql = $con->prepare($cadena);
    $sql->execute(
      array(
          'id_materia' => $id_materia,
          'id_alumno' => $id_alumno
        ));
    
  if($sql->execute()){

	echo "SE DIO DE BAJA CON EXITO";
  }	
   
  }catch(PDOException $e) {

  	echo "HA OCURRIDO UN ERROR";
    
  }





 ?>