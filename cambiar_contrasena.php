<?php

session_start();
$server = "localhost";
$usuario = "root";
$contra = "MyNewPass";
$basedato = "profesorado_cef";

if(isset($_SESSION['dni'])) {
  // echo $_SESSION['dni'];
  // echo $_SESSION['perfil'];
  try {
    $con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_POST['cambiar_contrasena'])) {
      if(empty($_POST['contrasena_actual']) || empty($_POST['contrasena_nueva']) || empty($_POST['contrasena_nueva_validacion'])) {
        $mensaje = '<label>Todos los campos son requeridos</label>';
      }
      else {
        if($_SESSION['perfil'] == 'Alumno')
          $sql = 'SELECT * FROM alumnos WHERE dni = :dni AND contrasena = :contrasena';
        elseif($_SESSION['perfil'] == 'Bedel' || $_SESSION['perfil'] == 'Docente')
          $sql = 'SELECT * FROM profesores WHERE dni = :dni AND contrasena = :contrasena';
        $estado = $con->prepare($sql);
        $estado->execute(
          array(
            'dni' => $_SESSION['dni'],
            'contrasena' => $_POST['contrasena_actual']
          )
        );
        $contador = $estado->rowCount();
        if($contador > 0) {
          if($_POST['contrasena_nueva'] == $_POST['contrasena_nueva_validacion']) {
            try {
              if($_SESSION['perfil'] == 'Alumno')
                $sql = 'UPDATE alumnos SET contrasena = :contrasena WHERE dni = :dni';
              elseif($_SESSION['perfil'] == 'Bedel' || $_SESSION['perfil'] == 'Docente')
                $sql = 'UPDATE profesores SET contrasena = :contrasena WHERE dni = :dni';
              $estado = $con->prepare($sql);
              $estado->execute(
                array(
                  'dni' => $_SESSION['dni'],
                  'contrasena' => $_POST['contrasena_nueva']
                )
              );
                $mensaje = 'La contraseña se ha cambiado exitosamente';
            } catch (\Exception $e) {
              $mensaje = 'Ocurrió un error mientras quería actualizar su nueva contraseña';
            }
          }
          else {
            $mensaje = '<label>Los campos que solicitan su nueva contraseña no coinciden. Intente nuevamente.</label>';
          }
          // $_SESSION['perfil'] = 'Alumno';
          // header("location:pagina_principal.php");
          // $mensaje = '<label>Has iniciado sesión</label>';
        }
        else {
          $mensaje = '<label>Usted no ha ingresado correctamente su contraseña actual</label>';
        }
      }
    }

  }
  catch (PDOException $e) {
    $mensaje = $e->getMessage();
  }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" >
    <title>SIPET - Cambiar contraseña</title>
    <style type="text/css">
      /*.normal {
        width: 1024px;
        border: 1px solid #000;
      }
      .normal th, .normal td {
        border: 1px solid #000;
      }*/
      label {
        margin-bottom: 0;
        margin-top:10px;
      }

      /* input {
        margin-bottom: 10px;
      } */

    	@media (max-width: 768px) {
    	  .container {
    	    width: 100%;
    	    max-width: none;
    	  }
    	}
    </style>
  </head>
  <body style="background-color:#EDECEA;">
    <nav style="background-color:#0D0C0C" class="navbar navbar-dark fixed-top navbar-toggleable-md">
    	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" id="btn-menu" aria-label="Toggle navigation">
      	<span class="navbar-toggler-icon"></span>
      </button>

      <a class="navbar-brand" href="pagina_principal.php">
        <span class="icon-brand35" ></span>
        Profesorado CEFN5
      </a>

  		<div class="collapse navbar-collapse" id="menu">
		    <div class="navbar-nav">
          <a class="nav-item nav-link" href="#">Inscripcion Materias</a>
          <a class="nav-item nav-link" href="#">Inscripcion Final</a>
          <a class="nav-item nav-link" href="#">Ver plan de estudios</a>
          <a class="nav-item nav-link" href="#">Obtener certificados</a>
      	</div>
      </div>
    </nav>
    <br />
    <br>
    <br>
    <br>
    <div class="container" style="width:500px;">
      <?php
      if(isset($mensaje))
      {
           echo '<label class="text-danger">'.$mensaje.'</label>';
      }
      ?>
      <!-- <h3 align="center">¡Bienvenido a Sistema Informático!</h3><br /> -->
      <form method="post">
        <label>Ingrese su contraseña actual</label>
        <input type="password" name="contrasena_actual" class="form-control" />
        <label>Ingrese su nueva contraseña</label>
        <input type="password" name="contrasena_nueva" class="form-control" />
        <label>Ingrese otra vez su nueva contraseña</label>
        <input type="password" name="contrasena_nueva_validacion" class="form-control" />
        <br />
        <input type="submit" name="cambiar_contrasena" class="btn btn-primary" value="Cambiar contraseña" />
      </form>
    </div>
    <br />
  </body>
</html>
