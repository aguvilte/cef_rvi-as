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
                <h3 align="center">¡Bienvenido a Sistema Informático!</h3><br />
                <form method="post">
                     <label>Ingrese su contraseña actual</label>
                     <input type="password" name="contrasena_actual" class="form-control" />
                     <br />
                     <label>Ingrese su nueva contraseña</label>
                     <input type="password" name="contrasena_nueva" class="form-control" />
                     <br />
                     <label>Ingrese otra vez su nueva contraseña</label>
                     <input type="password" name="contrasena_nueva_validacion" class="form-control" />
                     <br />
                     <input type="submit" name="cambiar_contrasena" class="btn btn-info" value="Iniciar sesión" />
                </form>
           </div>
           <br />
      </body>
 </html>
