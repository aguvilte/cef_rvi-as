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
	  /*.normal {
	    width: 1024px;
	    border: 1px solid #000;
	  }
	  .normal th, .normal td {
	    border: 1px solid #000;
	  }*/
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
	      <a class="nav-item nav-link" href="#">Obtener crtificados</a>
    	</div>
    </div>
	</nav>

  <div class="container">
    <br>
    <br>
    <br>

		<div class="col-md-2" style="margin-bottom: 20px; padding: 0;">
			<a href="./materias_profesor.php"><button type="button" class="btn btn-outline-primary">Elegir otra materia</button></a>
		</div>

		<form id="tabla-alumnos" action="guardar_nota_condicion_alumno_a_catedra.php" method="get">
			<table class="table" style="background-color:white;">
				<thead class="thead-dark">
					<tr>
						<th scope="col">N°</th>
						<th scope="col">APELLIDO Y NOMBRE</th>
						<th scope="col">DNI</th>
						<th scope="col">NOTA</th>
						<th scope="col">CONDICIÓN</th>
					</tr>
				</thead>
				<tbody>

					<?php
					session_start();
					$server = "localhost";
					$usuario = "root";
					$contra = "MyNewPass";
					$basedato = "profesorado_cef";

					$id_materia_elegida = $_SESSION['id_materia_elegida'];

					if(isset($_SESSION['dni'])) {
						try {
							$con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
							$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

							$sql = $con->prepare('SELECT nombre_y_apellido, dni FROM alumnos INNER JOIN alumnos_catedras ON alumnos.id_alumnos = alumnos_catedras.id_alumno WHERE alumnos_catedras.id_materia = '.$id_materia_elegida.' ORDER BY nombre_y_apellido');
							$sql->execute();

							$cadena = "";
							$cadena.="<tr>";
							// $cadena.="</tr>";
							// $cadena.="<td>holis</td></tr>";

							// echo 'lpm';

							$i = 0;

							while($datos = $sql->fetch(PDO::FETCH_ASSOC)){
								$nombre_alumno = $datos['nombre_y_apellido'];
								$dni = $datos['dni'];
								$i = $i+1;

								$cadena.="<td>$i</td>
								<td>".$nombre_alumno."</td>
								<td class='dni'><input type='text' name='dni[]' value='$dni'></input></td>
								<td><input name='nota[]' class='form-control input-nota' type='text' size='1'></input></td>
								<td>
									<select name='condicion[]' class='form-control select-condicion'>
										<option value=''></option>
										<option value='R'>REGULAR</option>
										<option value='PI'>P. INDIRECTA</option>
										<option value='P'>P. DIRECTA</option>
										<option value='L'>LIBRE</option>
									</select>
								</td>";

								$cadena.="</tr>";
							}
						}

						catch (PDOException $e) {
							$mensaje = $e->getMessage();
						}

						$cadena.="</tr>";
						echo $cadena;
					}

					?>
				</tbody>
			</table>

	    <div class="row">
				<div class="col-md-5 col-sm-4"></div>
				<div class="col-md-2 col-sm-4" style="margin-top: 15px;">
					<button class="btn btn-primary" onclick="guardarNotas(<?php echo $i ?>)">Cargar notas</button>
				</div>
			</div>
	  </div>
	</form>

	<script type="text/javascript">
	  $.ajax({
			type: 'GET',
			url: 'guardar_nota_condicion_alumno_a_catedra.php',
			data: $('#tabla-alumnos').serialize(),
		});
	</script>
	<script type="text/javascript"></script>
</body>
</html>
