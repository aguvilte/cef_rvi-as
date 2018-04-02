	<!DOCTYPE html>
	<html>
	<head>
	<meta charset="utf-8">


	    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
 		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" >

		<link rel="stylesheet" type="text/css" href="image/fonts/style.css">

<style type="text/css">
	
	a{
  color:white;
}
</style>




		<title>Inscripcion a Materias</title>



	</head>
	<body>

	<nav style="background-color:#0D0C0C" class="navbar navbar-dark  fixed-top    navbar-toggleable-md ">

  <button class="navbar-toggler navbar-toggler-right " type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01"  id="btn-menu" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>


  <a class="navbar-brand" href="login_exitoso.php">
    <span class="icon-brand35" ></span>
    rofesorado CEFN5
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

	<div class="container-fluid">


	<br>
	<br>
	<br>

<div class="row justify-content-center ">
    

	 
	<table class="table">
	  <thead class="thead-dark">
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

 session_start();

    if ($_SESSION['perfil'] == 'Alumno') {




	$server = "localhost";
	$usuario = "root";
	$contra = "";
	$basedato = "profesorado_cef";


 $dni = $_SESSION['dni'];


    $con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = $con->prepare('SELECT id_alumnos FROM alumnos WHERE dni = :dni');
    $sql->execute(array(
        'dni' => $dni
      ));

      while ($datos = $sql->fetch(PDO::FETCH_ASSOC)) {
      $id_alumno= $datos['id_alumnos'];
      }

	

	try {
	  $con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
	  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	  $sql = $con->prepare(
	    'SELECT c.id_materia,c.id_profesor,c.nombre,c.ano,c.formato,c.regimen_c, p.nombre_y_apellido FROM catedras AS c INNER JOIN profesores AS p ON c.id_profesor = p.id_profesor'
	  );

	  $sql->execute();

	$cadena = "";
	$cadena.="<tr>";
	  while( $datos = $sql->fetch(PDO::FETCH_ASSOC)){


	  	$cadena.="<th scope='row'>".$datos['id_materia']."</th> 
	  	 
	  	 <td>".$datos['nombre']."</td>
	  	 <td>".$datos['ano']."</td>
	  	 <td>".$datos['formato']."</td>	
	  	 <td>".$datos['regimen_c']."</td>
	  	 <td><button class='btn btn-outline-primary' onclick='inscribir(".$id_alumno.",".$datos['id_materia'].")'>Aqui</button></td>";
	  	

	$cadena.="</tr>";
	  }
	   
	} catch(PDOException $e) {
	  echo 'Error: ' . $e->getMessage();
	}


	$cadena.="</tr>";
	echo $cadena;

}
else{

header("location:pagina_principal.php");

}
	 ?>

	</tbody>

	</table>
</div>



	</div>

	</body>


	<script type="text/javascript">
		

	function inscribir(id_alumno,id_catedra)
	{
		if(confirm("Esta seguro que desea inscribirse?")){

	var parametros = {
	  "id_alumno": id_alumno,
	  "id_catedra": id_catedra
	};

	var url = "guardar_inscripcion_de_alumno_a_la_catedra.php";

	 $.ajax({                        
	           type: "GET",                 
	           url: url,                    
	           data:parametros ,

	            success: function(data)            
	           {
	            alert(data);
	             
	           }
	  });



	
		}

		}


		$(document).ready(function(){



   $("#btn-menu").click(function () {
      $("#menu").each(function() {
        displaying = $(this).css("display");
        if(displaying == "block") {
          $(this).fadeOut('slow',function() {
           $(this).css("display","none");
          });
        } else {
          $(this).fadeIn('slow',function() {
            $(this).css("display","block");
          });
        }
      });
    });
  });



	</script>


	<script type="text/javascript"></script>
	</html>