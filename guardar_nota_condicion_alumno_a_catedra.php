<?php

session_start();
$server = "localhost";
$usuario = "root";
$contra = "MyNewPass";
$basedato = "profesorado_cef";

$dni = $_GET['dni'];
$nota = $_GET['nota'];
$condicion = $_GET['condicion'];

$id_materia = $_SESSION['id_materia_elegida'];

try {
  $con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $id_alumno = [];

  foreach ($dni as $key => $valor) {
    $sql = $con->prepare('SELECT id_alumnos FROM alumnos WHERE dni = '.$valor);
    $sql->execute();

    $i = $key;

    while($datos = $sql->fetch(PDO::FETCH_ASSOC)) {
      $id_alumno[$i] = $datos['id_alumnos'];
    }

    $sql = $con->prepare(
      'UPDATE alumnos_catedras SET nota=:nota, condicion=:condicion WHERE id_alumno=:id_alumno AND id_materia=:id_materia'
    );

    if($sql->execute(
      array(
        ':nota'=>$nota[$i],
        ':condicion'=> $condicion[$i],
        ':id_alumno'=> $id_alumno[$i],
        ':id_materia'=> $_SESSION['id_materia_elegida'])
      )) {
      $mensaje = 'Las notas han sido cargadas correctamente.';
    }
    else {
      $mensaje = 'Hubo un problema al momento de cargar las notas. Intente nuevamente.';
    }
    echo '<script type="text/javascript">alert("'.$mensaje.'");window.location.href = "./materias_profesor.php"</script>';
  }
}
catch(PDOException $e) {
  echo 'ERROR...
  "USTED YA SE ENCUENTRA INSCRIPTO A ESTA MATERIA. "
  " O NO SE HA PODIDO ESTABLECER UNA CONEXION CON EL SERVIDOR"
  "INTENTELO MAS TARDE."';
}

?>
