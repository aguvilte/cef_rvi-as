
        
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
  <div class="container">

<h1>INGRESE EL NUMERO QUE DESEA CORROBORAR</h1>
 			 <form method="post" id="formulario">
                	<input type="text" name="numero">
                	<input type="button" id="boton" name="create_pdf" class="btn btn-danger pull-right" value="Generar PDF">
                </form>

                <div class="res"></div>
</div>


  </div>

  </body>
<script type="text/javascript">
	




$(document).ready(function(){

  $("#boton").click(function(){



var id_alumno =1;
var url = "comprobar.php";

 $.ajax({                        
           type: "GET",                 
           url: url,                    
           data: $("#formulario").serialize(),

            success: function(data)            
           {

            $(".res").html(data);

           }

  });
});
});









</script>

</html>














