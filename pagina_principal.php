<?php

session_start();
$server = "localhost";
$usuario = "root";
$contra = "MyNewPass";
$basedato = "profesorado_cef";

if(isset($_SESSION['dni'])) {
  try {
    $con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = $con->prepare('SELECT nombre_y_apellido FROM alumnos WHERE dni = '.$_SESSION['dni'].'');
    $sql->execute();

    if($datos = $sql->fetch(PDO::FETCH_ASSOC)){
      $nombre_y_apellido = $datos['nombre_y_apellido'];
    }
    else {
      $sql = $con->prepare('SELECT nombre_y_apellido FROM profesores WHERE dni = '.$_SESSION['dni'].'');
      $sql->execute();

      while($datos = $sql->fetch(PDO::FETCH_ASSOC)){
        // echo gettype($datos);
        // echo count($datos);
        $nombre_y_apellido = $datos['nombre_y_apellido'];
      }
    }

    // echo '¡Bienvenido, '.$nombre_y_apellido.'!';
    $sesion_nombre = $nombre_y_apellido;
    $sesion_perfil = $_SESSION['perfil'];
  }
  catch(PDOException $e) {
    $mensaje = $e->getMessage();
  }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Página principal</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>
  <body style="background-color:#EDECEA;">
    <br />
    <div class="container">
      <?php
      echo '<div class="row justify-content-end">';
      echo '<div class="col-md-7"><h2 align="left">Sistema Informático</h2></div>';
      if(isset($sesion_nombre)) {
        echo '<div class="col-sm-8 col-md-3">';
        echo '<p class="p-1 mb-2 bg-secondary text-white border rounded" style="max-width:250px; text-align:center;">';
        echo $sesion_nombre;
        echo '</p></div>';
        // echo '<span class="border border-secondary" style="padding:5px;">'.$sesion_nombre.'</span>';
      }
      if(isset($sesion_perfil)) {
        echo '<div class="col-sm-4 col-md-2" style="margin:0">';
        echo '<p class="p-1 mb-2 bg-dark text-white border rounded" style="max-width:250px; text-align:center;">';
        echo $sesion_perfil;
        echo '</p></div>';
      }
      echo '</div>';
      ?>
      <br><br>
      <div class="row justify-content-md-center">
        <div class="col-sm-6 col-md-4 text-center" style="padding:10px;">
          <div class="card">
            <div class="card-body border border-dark rounded">
              <?php
              if($sesion_perfil == 'Alumno') {
                echo '<h5 class="card-title"><b>Inscripción a materias</b></h5>';
                echo '<p class="card-text">Inscríbete a las materias que quieras <b>cursar</b> en el próximo cuatrimestre haciendo clic acá.</p>';
                echo '<a href="./inscripcion_materias.php" class="btn btn-primary">Inscribirse</a>';
              }
              else {
                echo '<h5 class="card-title"><b>Acta de regularidad</b></h5>';
                echo '<p class="card-text">Puedes <b>ver, ingresar y/o modificar las notas y condiciones de regularidad</b> de los alumnos.</p>';
                echo '<a href="./materias_profesor.php" class="btn btn-primary">Entrar</a>';
              }
              ?>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 text-center" style="padding:10px;">
          <div class="card">
            <div class="card-body border border-dark rounded">
              <?php
              if($sesion_perfil == 'Alumno') {
                echo '<h5 class="card-title"><b>Inscripción a exámenes finales</b></h5>';
                echo '<p class="card-text">Inscríbete a las materias que quieras <b>rendir</b> en la próxima mesa de finales haciendo clic acá.</p>';
                echo '<a href="#" class="btn btn-primary">Inscribirse</a>';
              }
              else {
                echo '<h5 class="card-title"><b>Acta de exámenes finales</b></h5>';
                echo '<p class="card-text">Puedes <b>ver, ingresar y/o modificar las notas de exámenes finales</b> de los alumnos.</p>';
                echo '<a href="#" class="btn btn-primary">Entrar</a>';
              }
              ?>
            </div>
          </div>
        </div>
        <?php
        if($sesion_perfil == 'Alumno') {
          echo '<div class="col-sm-6 col-md-4 text-center" style="padding:10px;">';
          echo '<div class="card">';
          echo '<div class="card-body border border-dark rounded">';
          echo '<h5 class="card-title"><b>Solicitud de certificados</b></h5>';
          echo '<p class="card-text">Descargá tu <b>certificado de alumno regular</b> o tu <b>historial académico</b> haciendo clic acá.</p>';
          echo '<a href="#" class="btn btn-primary">Descargar</a>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
        ?>
        <div class="col-sm-6 col-md-4 text-center" style="padding:10px;">
          <div class="card">
            <div class="card-body border border-dark rounded">
              <h5 class="card-title"><b>Ver plan de estudios</b></h5>
              <p class="card-text">Podés ver el plan de estudios haciendo clic acá.</p>
              <a href="#" class="btn btn-primary">Ver plan de estudios</a>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 text-center" style="padding:10px;">
          <div class="card">
            <div class="card-body border border-dark rounded">
              <h5 class="card-title"><b>Cambiar contraseña</b></h5>
              <p class="card-text">Si necesitás cambiar tu contraseña, podés hacerlo haciendo clic acá.</p>
              <a href="./cambiar_contrasena.php" class="btn btn-primary">Cambiar contraseña</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
