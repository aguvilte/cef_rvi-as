<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" >
	<title>Inscripcion a Materias</title>
	<style type="text/css">
	  a {
      text-decoration: none;
    }

    a:hover {
      text-decoration: none;
    }
	</style>
</head>
<body style="background-color:#EDECEA;">
	<nav style="background-color:#0D0C0C" class="navbar navbar-dark fixed-top navbar-toggleable-md">
		<button class="navbar-toggler navbar-toggler-right " type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" id="btn-menu" aria-label="Toggle navigation">
	  	<span class="navbar-toggler-icon"></span>
    </button>

	  <a class="navbar-brand" href="pagina_principal.php">
	    <span class="icon-brand35" ></span>
	    Profesorado CEFN5
	  </a>

 		<div class="collapse  navbar-collapse" id="menu">
  		<div class="navbar-nav">
	      <a class="nav-item nav-link" href="#">Inscripcion Materias</a>
	      <a class="nav-item nav-link" href="#">Inscripcion Final</a>
	      <a class="nav-item nav-link" href="#">Ver plan de estudios</a>
	      <a class="nav-item nav-link" href="#">Obtener certificados</a>
    	</div>
    </div>
	</nav>

  <div class="container">
    <br>
    <br>
    <br>
		<div class="row justify-content-center">

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

        $sql = $con->prepare('SELECT id_profesor FROM profesores WHERE dni = '.$_SESSION['dni'].'');
        $sql->execute();

        if($datos = $sql->fetch(PDO::FETCH_ASSOC)){
          $id_profesor = $datos['id_profesor'];
        }
        else {
          echo 'no es un profe';
        }

        $sql = $con->prepare('SELECT id_catedra, nombre FROM catedras WHERE id_profesor = :id_profesor');
        $sql->execute(array(':id_profesor' => $id_profesor));

        echo '<div class="form-group col-md-8 col-sd-12" id="form-materias"><form action="" method="get"><div class="row">';
        echo '<label>Seleccione la materia en la que quieres cargar actas de regularidad:</label>';
        echo '<select class="form-control" id="materias-select" name="select-materia">';

        while($datos = $sql->fetch(PDO::FETCH_ASSOC)){
          echo '<option value="'.$datos['id_catedra'].'">'.$datos['nombre'].'</option>';
        }

      } catch (PDOException $e) {
        $mensaje = $e->getMessage();
      }

      echo '</select><br>';
			// echo '<button class="btn btn-outline-primary" onclick="getValorIdMateria()"><a href="./acta_regularidad.php">Ir al acta</a></button>';
			echo '<div class="col-md-5 col-sm-4 col-xs-4"></div>';
			echo '<div class="col-md-2 col-sm-4 col-xs-4" style="margin-top: 15px;"><input type="submit" name="submit" value="Ir al acta" class="btn btn-outline-primary form-control" onclick="redirigir()"></input></div>';
      echo '</div></form></div>';

			if(isset($_GET['submit'])) {
				$_SESSION['id_materia_elegida'] = $_GET['select-materia'];
				header('Location: ./acta_regularidad.php');
			}
    }
		else {
			header('Location: http://localhost/profesorado/iniciar_sesion.php');
		}

		?>

    <!-- <button class="btn btn-outline-primary" id="submit-form-materias"><a href="./acta_regularidad.php">Ir al acta</a></button> -->
		</div>
	</div>

	<script type="text/javascript">

	function redirigir() {
		var id_materia = document.getElementById('materias-select').value;
		// alert(id_materia);
	}

	</script>
	<script type="text/javascript"></script>
</body>
</html>
