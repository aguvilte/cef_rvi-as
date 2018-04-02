<?php 


 $server = "localhost";
  $usuario = "root";
  $contra = "";
  $basedato = "profesorado_cef";

$id_materia = $_GET['id_materia'];
$id_alumno = $_GET['id_alumno'];



 $nombre = "";
  $fecha = "";
 $hora = "";
$condicion = "";
  

  try {
    $con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = $con->prepare('SELECT fecha,hora FROM calendario_examenes WHERE id_materia = :id_materia AND  fecha > NOW()  ORDER BY fecha DESC ');
    $sql->execute(
      array(
        'id_materia' => $id_materia
        ));

    while ($datos = $sql->fetch(PDO::FETCH_ASSOC)) {
       
      $fecha= $datos['fecha'];
      $hora = $datos['hora'];

    }



    $sql = $con->prepare(
      'SELECT c.nombre,c_a.condicion FROM  catedras AS c INNER JOIN alumnos_catedras AS c_a ON  c.id_materia = c_a.id_materia  WHERE id_alumno = :id_alumno AND c.id_materia = :id_materia'
    );

    $sql->execute(
    	array(
          'id_materia' => $id_materia,
          'id_alumno' => $id_alumno
        )

    	);

  $cadena = "";

 if($sql != null){

    while( $datos = $sql->fetch(PDO::FETCH_ASSOC)){
 

		
		$nombre = $datos['nombre'];
    $condicion = $datos['condicion'];




		
}

  header('Content-Type: application/json');
//Guardamos los datos en un array
$datoss = array(
    'nombre_final' => $nombre,
    'fecha_final' => $fecha,
    'hora_final' => $hora,
    'condicion' => $condicion
    
);
//



}


echo json_encode($datoss, JSON_FORCE_OBJECT);


 } catch(PDOException $e) {
    //echo 'Error: ' . $e->getMessage();
  }




?>