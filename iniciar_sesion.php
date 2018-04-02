<?php

session_start();
$server = "localhost";
$usuario = "root";
$contra = "MyNewPass";
$basedato = "profesorado_cef";

try {
  $con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $_SESSION['dni'] = '';

  if(isset($_POST['login'])) {
    if(empty($_POST['dni']) || empty($_POST['contrasena'])) {
      $mensaje = '<label>Todos los campos son requeridos</label>';
    }
    else {
      $sql = 'SELECT * FROM alumnos WHERE dni = :dni AND contrasena = :contrasena';
      $estado = $con->prepare($sql);
      $estado->execute(
        array(
          'dni' => $_POST['dni'],
          'contrasena' => $_POST['contrasena']
        )
      );
      $contador = $estado->rowCount();
      if($contador > 0) {
        $_SESSION['dni'] = $_POST['dni'];
        $_SESSION['perfil'] = 'Alumno';
        header("location:pagina_principal.php");
        // $mensaje = '<label>Has iniciado sesión</label>';
      }
      else {
        $sql = 'SELECT * FROM profesores WHERE dni = :dni AND contrasena = :contrasena';
        $estado = $con->prepare($sql);
        $estado->execute(
          array(
            'dni' => $_POST['dni'],
            'contrasena' => $_POST['contrasena']
          )
        );
        $contador = $estado->rowCount();
        if($contador > 0) {
          $_SESSION['dni'] = $_POST['dni'];

          while($resultado = $estado->fetch(PDO::FETCH_ASSOC)) {
            if($resultado['es_bedel'] == 1)
              $_SESSION['perfil'] = 'Docente';
            else
              $_SESSION['perfil'] = 'Bedel';
          }

          // echo $estado;
          header("location:pagina_principal.php");
          // $mensaje = '<label>Has iniciado sesión</label>';
        }
        else {
          $mensaje = '<label>El usuario o la contraseña son incorrectos</label>';
        }
      }
    }
  }

}
catch (PDOException $e) {
  $mensaje = $e->getMessage();
}

?>

<!DOCTYPE html>
 <html>
      <head>
           <title>Sistema Informático</title>
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
      </head>
      <body>
           <br />
           <div class="container" style="width:500px;">
                <?php
                if(isset($mensaje))
                {
                     echo '<label class="text-danger">'.$mensaje.'</label>';
                }
                ?>
                <h3 align="center">¡Bienvenido a SIPET!</h3><br />
                <form method="post">
                     <label>Usuario</label>
                     <input type="text" name="dni" class="form-control" />
                     <br />
                     <label>Contraseña</label>
                     <input type="password" name="contrasena" class="form-control" />
                     <br />
                     <input type="submit" name="login" class="btn btn-info" value="Iniciar sesión" />
                </form>
           </div>
           <br />
      </body>
 </html>
