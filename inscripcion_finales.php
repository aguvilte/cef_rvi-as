<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">



 <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" > 
    <link rel="stylesheet" type="text/css" href="image/fonts/style.css">

<!-- Estilos de la tabla los input son hechos con bootstrap -->
 

<style type="text/css">
*{color:black;}
  body{
     background-color:white;
     background-size:100% 100%;
     background-attachment:fixed;
     background-position:center;
     background-repeat:no-repeat;

    
  }
  .active{

  }

  .form-conatiner{
    border:1px solid #aaa;
    padding:30px 30px; margin-top:8vh;
    -webkit-box-shadow: -1px 4px 26px 9px rgba(0,0,0,0.7);
    -moz-box-shadow: -1px 4px 26px 9px rgba(0,0,0,0.7);
    box-shadow: -1px 4px 26px 9px rgba(0,0,0,0.7);

    border-radius: 10px 10px 10px 10px;
    -moz-border-radius: 10px 0px 10px 10px;
    -webkit-border-radius: 10px 10px 10px 10px;
    border: 0px solid #000000;
  }
.white {
    background-color:#FFFFFF;
    color:#000000;
}

.icon-menu{
  color:white;
}

.black {
    background-color:#000000;
    color:#FFFFFF;
}

a{
  color:white;
}


.selected {
  cursor:pointer;
  
} 


.seleccionada {
  background-color:#ED564A;
  color:black;
}







</style>

  <title>Inscripcion final</title>



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


<div class="container-fluid bg">




 <div class="row justify-content-center">
    <div class="col">
    <div class="alert alert-danger " style="display:none;  margin-top:8vh;" id="alert" role="alert">
  <p id="texto_alert">  </p>
</div>
</div>
</div>



  <div class="row justify-content-center ">
   <div id="columna1" class="col-md-4 form-conatiner align-self-center">
         

                
          <!-- esta es la segunda columna de la primera fila -->

          <div class="list-group">
  <a href="#" class="list-group-item list-group-item-action active">
    Seleccionar materia
  </a>
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
      'SELECT id_materia,nombre,ano FROM catedras'
    );

    $sql->execute();

  $cadena = "";


    while( $datos = $sql->fetch(PDO::FETCH_ASSOC)){


      $cadena.='

      

         <a style="color:blue;cursor:pointer;" type="text" id="a'.$datos['id_materia'].'" onClick="trae_items('.$datos['id_materia'].','.$id_alumno.');"  class="list-group-item list-group-item-action  selected ">'.$datos['nombre'].'</a>';
      
     
    }
     
  } catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }

  echo $cadena;

}
else{

header("location:pagina_principal.php");
}

?>


        </div>    
          </div>






    
      

            <div id="columna2" class="col-md-4">
   



        <form class="form-conatiner "  id="formulario"  method="GET" >
       <a href="#" id="afi" class="list-group-item list-group-item-action ">FORMULARIO DE INSCRIPCION </a>
        <div class="row">
  <div class="col" >
    <label for="">NRO MATERIA</label>

    <input type="text" class="form-control"  name="id_materia" readonly="" id="id_materia" aria-describedby="emailHelp" >

  </div>
  <div class="col">
    <label >FECHA DE EXAMEN</label>
    <input type="text" class="form-control" id="fecha_examen" readonly="" name="fecha_examen">
  </div>

</div>


<div class="row">
<div class="col">
    <label >FECHA Y HORA ACTUAL</label>
    <input type="text" class="form-control" id="fecha_y_hora_actual" readonly=""  name="fecha_y_hora_actual" >
  </div>

<div class="col">
    <label >HORA DE EXAMEN</label>
    <input type="text" class="form-control" id="hora_final" readonly=""  name="fecha_y_hora_actual" >
  </div>



  </div>



<div class="row">
  <div class="col-8">
    <label >CONDICION</label>
  <input type="text" class="form-control" id="condicion" readonly=""  name="condicion" >
    </select>
   
  </div>
  </div>
  <br>




  <button type="button"  id="btn-registrar" class="btn btn-outline-primary btn-block  " >Inscribirme </button>
   


</form>


<br>


<a href="#" class="list-group-item bg-success list-group-item-action active">
    MATERIAS INSCRIPTAS
  </a><div id="muestra">
          <div class="list-group" id="muestra_inscripcion">
 
 
  

        
        </div>    
          </div>

    </div>
    
    <!-- Esta es la tercer columna de la primer fila-->
 <div id="columna3" class="col-md-4">
    

    <div id="reporte"></div>

    </div>
    </div>



      <!--Esta es la parte de abajo-->
    <br><br>

     <div class="row justify-content-center ">
       <div class="col  align-self-center">
        <div id="muestra">
          <div class="list-group" id="muestra_inscripcion">
 
 
  

        
        </div>    
          </div>

</div>

    </div>
    
  

  
   
    </body>







  

<br>
<br>







<script type="text/javascript"> 



       var ultimaFila = null;
        var color ;
       $(Inicializar);
        function Inicializar() {
            $('.selected').click(function () {
                if (ultimaFila != null) {
                    ultimaFila.css('background-color', color)
                }
                color = $(this).css('background-color');
                $(this).css('background-color', '#7375F9');
                ultimaFila = $(this);
            });
        }

//FUNCION QUE TRAE TODAS LAS MATERIAS INSCRIPAS


  function trae_materias(){
  var id_alumno = <?php echo $id_alumno; ?>   ;
      var url = "trae_materias_inscriptas.php";
       var parametros = {
          
          "id_alumno":id_alumno

        };

 $.ajax({                        
           type: "GET",                 
           url: url,                    
           data: parametros,

            success: function(data)            
           {
            $("#muestra").html(data);
             
           }

  });
}
 






 function dar_baja(id_materia,id_alumno){

 if(confirm('ESTA SEGURO QUE DESEA DARSE DE BAJA DE LA MATERIA '+id_materia+' ?'))
  {
        var parametros = {
          
          "id_materia":id_materia,
          "id_alumno":id_alumno
        };
        var url = "dar_bajar_examen_final.php";

        $.ajax({                        
           type: "GET",                 
           url: url,                    
           data: parametros,
           
           success: function(data)            
           {   
        
              alert(data);
            }



 });
      }}
   
 
  

 

//FUNCION QUE TRAE LOS PARAMETROS DE ID ALUMNO Y MATERIA, MOSTRANDO UN ALERT 
//INDICANDO  QUE MATERIA HEMOS SELECCIONADO 

   function trae_items(id_materia,id_alumno){


          $('#hora_final').val("");
        $('#fecha_examen').val("");
        $('#id_materia').val("") ;
        $('#condicion').val("");
        $('#fecha_y_hora_actual').val("");



      $("html, body").animate({scrollTop:"0px"});

      var nombre = $("#a"+id_materia).text();
      var id = id_materia ;
        var id_alumno = id_alumno ;
         $("#texto_alert").text("Usted selecciono la matria: "+nombre);

                 $("#alert").each(function() {
              displaying = $(this).css("display");
                  if(displaying == "none") {

                       $(this).fadeOut('slow',function() {
            $("#texto_alert").text("Usted selecciono la matria: "+nombre)
           $(this).css("display","block");
          
          });}

      });
        



  



         //ENVIA ID DE MATERIA AL SERVIDOR
         //Y OBTIENE LOS DATOS DE EXAMEN DE ESE ID_MATERIA

    
        var parametros = {
          
          "id_materia":id,
          'id_alumno':id_alumno
        };
        var url = "trae_datos_del_final.php";

        $.ajax({                        
           type: "GET",                 
           url: url,                    
           data: parametros,
           dataType: "json",
           success: function(data)            
           {   


          //alert(data)    ;
        $('#hora_final').val(data.hora_final);
        $('#fecha_examen').val(data.fecha_final);
        $('#id_materia').val(id);
        $('#condicion').val(data.condicion);

        

          var f = new Date();

            $('#fecha_y_hora_actual').val(f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate() + " " + f.getHours() + ":" + f.getMinutes() + ":" + f.getSeconds());
            
          
           }
         });



      
}

//FUNCION QUE REGISTRA INSCRIPCION 

$(document).ready(function(){

  setInterval(trae_materias, 1000);

  $(document).click(function(){
    $( "#comprobante" ).remove();
  });

  $("#btn-registrar").click(function(){


    if( $('#hora_final').val() != "" && $('#fecha_examen').val()!="" && $('#id_materia').val()!="" && $('#condicion').val()!="" && $('#fecha_y_hora_actual').val()!=""){ 
    if(confirm('Realmente desea inscribirse?'))
  {

var id_alumno =1;
var url = "guardas_inscripcion_examen_final.php?id_alumno="+id_alumno;

 $.ajax({                        
           type: "GET",                 
           url: url,                    
           data: $("#formulario").serialize(),

            success: function(data)            
           {

            $("#reporte").html(data);
                $('#hora_final').val("");
        $('#fecha_examen').val("");
        $('#id_materia').val("") ;
        $('#condicion').val("");
        $('#fecha_y_hora_actual').val("");
           }


  });
}}
else{
  alert("AUN NO HAY FECHAS DEFINIDAS DE ESTA MATERIA, O NO HAN SIDO CARGADAS LAS REGULARIDADES ")
}});
});




//FUNCION PARA EL MENU


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



</body>
</html>