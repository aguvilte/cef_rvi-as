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
	<nav style="background-color:#0D0C0C" class="navbar navbar-dark fixed-top navbar-toggleable-md ">
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
	      <a class="nav-item nav-link" href="#">Obtener crtificados</a>
    	</div>
    </div>
	</nav>

  <div class="container">
    <br>
    <br>
    <br>

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

				if(isset($_POST['form-submit'])) {
					if($_POST['form-submit'] == 'Ir al acta') {
						$id_catedra_elegida = $_POST['select-materia'];
						echo $id_catedra_elegida;
					}
				}

        echo '<div class="form-group" id="form-materias"><form action="" method="post">';
        echo '<label>Seleccione la materia en la que quieres cargar actas de regularidad:</label>';
        echo '<select class="form-control" name="select-materia">';

        while($datos = $sql->fetch(PDO::FETCH_ASSOC)){
          echo '<option value="'.$datos['id_catedra'].'">'.$datos['nombre'].'</option>';
        }

      } catch (PDOException $e) {
        $mensaje = $e->getMessage();
      }

      echo '</select>';
			// echo '<button class="btn btn-outline-primary" id="submit-form-materias" onclick="acta('.$_POST['form-materias'].')"><a href="./acta_regularidad.php">Ir al acta</a></button>';
			echo '<a href="#"><input class="btn btn-outline-primary" type="submit" name="form-submit" value="Ir al acta"></input></a>';
			echo '<button onclick="acta()">hola</button>';
      echo '</form></div>';
    }

		?>

    <!-- <button class="btn btn-outline-primary" id="submit-form-materias"><a href="./acta_regularidad.php">Ir al acta</a></button> -->
  </div>

	<script type="text/javascript">


	// alert(id_catedra)

	// var form = document.getElementById("form-materias");
	//
	// document.getElementById("submit-form-materias").addEventListener("click", acta()

	function acta() {
		// var id_catedra = "<?php echo $id_catedra_elegida?>"
		alert('ta saliendo');

		var parametros = {
			'id_catedra': id_catedra
		}

		var url = 'acta_regularidad.php'

		$.ajax({
			type: 'GET',
			url: url,
			data: parametros,
			success: function(data) {
				alert(data)
			}
		})
	}
	  // function acta(id_catedra) {
	  // function acta() {
	  	// if(confirm("Esta seguro que desea inscribirse?")){
      //
	    //   var parametros = {
	    //     "id_alumno": id_alumno,
	    //     "id_catedra": id_catedra
	    //   };
      //
	    //   var url = "guardar_inscripcion_de_alumno_a_la_catedra.php";
      //
	    //   $.ajax({
	    //     type: "GET",
	    //     url: url,
	    //     data:parametros ,
	    //     success: function(data) {
	    //     alert(data);
	    //     }
	    //   });
      // alert(id_catedra)
      // alert('hey')
	    // }
	  // }
	</script>
	<script type="text/javascript"></script>
</body>
</html>
