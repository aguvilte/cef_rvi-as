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
		@media (max-width: 768px) {
		  .container {
		    width: 100%;
		    max-width: none;
		  }
		}
	</style>
</head>
<body style="background-color:#EDECEA;">
	<nav style="background-color:#0D0C0C" class="navbar navbar-dark fixed-top navbar-toggleable-md bg-dark">
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" id="btn-menu" aria-label="Toggle navigation">
	  	<span class="navbar-toggler-icon"></span>
    </button>

	  <a class="navbar-brand text-white" href="pagina_principal.php">
	    <span class="icon-brand35"></span>
	   	SIPET
	  </a>

 		<div class="collapse navbar-collapse" id="menu">
  		<div class="navbar-nav">
	      <a class="nav-item nav-link text-white" href="#">Inscripcion Materias</a>
	      <a class="nav-item nav-link text-white" href="#">Inscripcion Final</a>
	      <a class="nav-item nav-link text-white" href="#">Ver plan de estudios</a>
	      <a class="nav-item nav-link text-white" href="#">Obtener crtificados</a>
    	</div>
    </div>
	</nav>

	<div class="container">
		<br>
		<br>
		<br>
		<br>

		<table class="table" style="background-color:white;">
	  	<thead class="bg-primary" style="color:white">
				<tr>
 					<th scope="col">#NRO</th>
		      <th scope="col">NOMBRE MATERIA</th>
		      <th scope="col">AÑO</th>
		      <th scope="col">FORMATO</th>
		      <th scope="col">REGIMEN</th>
		      <th scope="col">INSCRIBIR</th>
				</tr>
	   	</thead>
 			<tbody>

  		<?php
    	$id_alumno = 1;

	    $server = "localhost";
	    $usuario = "root";
	    $contra = "MyNewPass";
	    $basedato = "profesorado_cef";

	    try {
	      $con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
	      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	      $sql = $con->prepare(
	        'SELECT c.id_catedra,c.id_profesor,c.nombre,c.ano,c.formato,c.regimen_c, p.nombre_y_apellido FROM catedras AS c INNER JOIN profesores AS p ON c.id_profesor = p.id_profesor'
	      );
	      $sql->execute();

	      $cadena = "";
	      $cadena.="<tr>";

	      while($datos = $sql->fetch(PDO::FETCH_ASSOC)){
	      	$cadena.="<td>".$datos['id_catedra']."</td>
	      	 <td>".$datos['nombre']."</td>
	      	 <td>".$datos['ano']."</td>
	      	 <td>".$datos['formato']."</td>
	      	 <td>".$datos['regimen_c']."</td>
	      	 <td><button class='btn btn-outline-primary' onclick='inscribir(".$id_alumno.",".$datos['id_catedra'].")'>Aquí</button></td>";

	        $cadena.="</tr>";
	      }
	    }
	    catch(PDOException $e) {
	      echo 'Error: ' . $e->getMessage();
	    }

	    $cadena.="</tr>";
	    echo $cadena;
	    ?>

			</tbody>
		</table>
	</div>

	<script type="text/javascript">
	  function inscribir(id_alumno,id_catedra) {
	  	if(confirm("Esta seguro que desea inscribirse?")){

	      var parametros = {
	        "id_alumno": id_alumno,
	        "id_catedra": id_catedra
	      };

	      var url = "guardar_inscripcion_de_alumno_a_la_catedra.php";

	      $.ajax({
	        type: "GET",
	        url: url,
	        data: parametros,
	        success: function(data) {
	        	alert(data);
	        }
	      });
	    }
	  }
	</script>
	<script type="text/javascript"></script>
</body>
</html>
