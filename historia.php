<?php 



    session_start();

    if ($_SESSION['perfil'] == 'Alumno') {





    $server = "localhost";
  $usuario = "root";
  $contra = "";
  $basedato = "profesorado_cef";


 $dni = $_SESSION['dni'];


 	$nombre =  [] ;
    $nota = [];
    $condicion = [];
    $tipo = [];
    $fecha = [];



    $con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = $con->prepare('SELECT id_alumnos,nombre_y_apellido FROM alumnos WHERE dni = :dni');
    $sql->execute(array(
        'dni' => $dni
      ));

      while ($datos = $sql->fetch(PDO::FETCH_ASSOC)) {
      $id_alumno= $datos['id_alumnos'];
      $nombre_alumno = $datos['nombre_y_apellido'];
      }




        try {
    $con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


 


    $sql = $con->prepare(
      'SELECT c.nombre,h.nota,h.condicion,h.tipo,h.fecha FROM catedras AS c INNER JOIN historial_alumnos_catedras AS h ON h.id_materia = c.id_materia WHERE id_alumno = :id_alumno ORDER BY h.fecha DESC'
    );

    $sql->execute(array(
    	'id_alumno' => $id_alumno

    	));

 
$i=0;
$cont=0;
$aprobado = 0;	
    while( $datos = $sql->fetch(PDO::FETCH_ASSOC)){


  
    
   $nombre[$i] = $datos['nombre'];
   $nota[$i] = $datos['nota'];
  $condicion[$i] = $datos['condicion'];
   $tipo[$i] = $datos['tipo'];
   $fecha[$i] = $datos['fecha'];

    $i++;
    $cont++;

  
 
    }

    $acum =0;
    $c =0;

    foreach ($nota as $key => $value) {
    	
    	 $acum = $acum + $value;
    	
      if ($value >= 4) {
    	$aprobado++;
    }
    $c++;
}

	$promedio = $acum / $c;



    $porcentaje = ($aprobado * 100) / 40;




     
  } catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }



}
else{

header("location:pagina_principal.php");
}


 ?>



<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Exportar a PDF - Miguel Angel Caro Rojas</title>
  <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" >

    <link rel="stylesheet" type="text/css" href="image/fonts/style.css">

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
<br>
<br>
  <div class="container">


  <br>
  <br>


<div class="row justify-content-center ">
    <div id="columna1" class="col-md-12 form-conatiner align-self-center">
         
   

  <button type="button" class="list-group-item list-group-item-action active">
    HISTORIAL ACADEMICO DEL ALUMNO: <?php echo $nombre_alumno; ?>
  </button>

  <table class="table">
  <tr>
  <td>MATERIA </td>
  <td> TIPO </td>
  <td> CONDICION</td>
  <td>NOTA </td>
  <td>FECHA </td>
</tr>

  <?php 

for ($i=0; $i <$cont ; $i++) { 
	

   ?>
  <tr><td> <?php echo $nombre[$i];?></td> <td><?php  echo $tipo[$i]; ?></td><td> <?php echo $condicion[$i]; ?></td> <td> <?php echo $nota[$i]; ?> </td> <td><?php echo $fecha[$i];  ?></td> </tr>
  


<?php 
}
 ?>
  
</table>
<br>

<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Titulo</h5>
    <h6 class="card-subtitle mb-2 text-muted">Profesor de Ed. Fisica</h6>
      <p class="card-text">Promedio: <a href="#" class="card-link"><?php echo round($promedio,2); ?></a> </p>
    <p class="card-text">Porcentaje: <a href="#" class="card-link"><?php echo round($porcentaje,2);  ?>%</a> </p>
   
    
    
  </div>
</div>

<br>
<br>

</div>



  </body>


</html>
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

