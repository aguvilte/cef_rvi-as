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

	<div class="container">


	<br>
	<br>
	<br>

<div class="row justify-content-center ">
    

	 
	<table  class="table table-hover table-responsive-sm"  border="4" cellpadding="5" >
       <tr>

    
    <th   rowspan="2">NRO</th>
    <th    rowspan="2">MATERIA</th>
    <th   colspan="3">CONDICIONES PARA</th>





  </tr>

  <tr>

  
    <th  colspan="2" >CURSAR</th>
    <th>ACREDITAR</th>
  
     

  </tr>
<tr>
  <th ></th>
  <td></td>
  <th>REGULARIZADO</th>
  <th>APROBADO</th>
  <th>APROBADO </th>
</tr>
	   <tbody>
		<?php 

 session_start();

    if ($_SESSION['perfil'] == 'Alumno') {




	$server = "localhost";
	$usuario = "root";
	$contra = "";
	$basedato = "profesorado_cef";


	$nombre = [];
	$nro = [];
	$c_regularizado = [];
	$c_aprobado = [];
	$a_aprobado = [];
	$cont =0;

	try {
    $con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = $con->prepare('SELECT co.id_materia,co.c_regularizado,co.c_aprobado,co.a_aprobado,ca.nombre FROM correlatividades AS co INNER JOIN catedras AS ca ON co.id_materia = ca.id_materia ORDER BY id_materia ASC');
    $sql->execute();

    $i=0;
      while ($datos = $sql->fetch(PDO::FETCH_ASSOC)) {
     	
     	$nombre[$i] = $datos['nombre'];
	$nro[$i] = $datos['id_materia'];
	$c_regularizado[$i] = $datos['c_regularizado'];
	$c_aprobado[$i] = $datos['c_aprobado'];
	$a_aprobado[$i] = $datos['a_aprobado'];

	$i++;
	$cont++;

     }

			for ($i=0; $i <$cont ; $i++) { 
			 	
			    ?>
           		<tr>
        
            <td><?php echo $nro[$i]; ?></td>
            <td> <?php echo $nombre[$i]; ?> </td>
            <td><?php echo $c_regularizado[$i] ?></td>
            <td><?php echo $c_aprobado[$i]; ?></td>
             <td><?php echo $a_aprobado[$i]; ?></td>
           
   
        
          </tr>
         <?php } ?>


<?php  
	  }
	   
	 catch(PDOException $e) {
	  echo 'Error: ' . $e->getMessage();
	}


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