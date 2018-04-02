<?php 


 $server = "localhost";
  $usuario = "root";
  $contra = "";
  $basedato = "profesorado_cef";
  $id_alumno = $_GET['id_alumno'];

  $id_materia = [];
  $id_calendario = [];
  $fecha =[];
  $hora = [];
  $nombre = [];
  //$cadena ="";

  //echo "este es el id que llego: ".$id_alumno;

 try {
    $con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



      $sql = $con->prepare("
      SELECT a_e.id_materia,c.nombre FROM alumnos_examenes AS a_e INNER JOIN catedras AS c ON c.id_materia = a_e.id_materia WHERE id_alumno = :id_alumno
      ");

      $sql->execute(array(

          'id_alumno' => $id_alumno
        ));

      $i =0;
      $cont =0;
      while ($datos = $sql->fetch(PDO::FETCH_ASSOC) ) {
        
        $id_materia[$i] = $datos['id_materia'];
        $nombre[$i] = $datos['nombre'];
        $i++;
        $cont++;
      }




       $sql = $con->prepare("
      SELECT id_calendario FROM calendario_examenes WHERE id_materia = :id_materia AND fecha > NOW() ORDER BY fecha ASC
      ");

       for ($i=0; $i <$cont ; $i++) { 
        

      $sql->execute(array(

          'id_materia' => $id_materia[$i]
        ));

    $datos = $sql->fetch(PDO::FETCH_ASSOC); 
      $id_calendario[$i] = $datos['id_calendario'];
    }



    $sql = $con->prepare('
        SELECT fecha,hora FROM calendario_examenes WHERE id_calendario = :id_calendario 
      ');

    for ($i=0; $i < $cont ; $i++) { 
     
      $sql->execute(
        array(

          'id_calendario' => $id_calendario[$i]

          ));

      $datos = $sql->fetch(PDO::FETCH_ASSOC);

        $fecha[$i] = $datos['fecha'];
        $hora[$i] = $datos['hora'];

}

  $cadena = "";


   for ($i=0; $i < $cont; $i++) { 
     # code...
   // echo "entro aca";
 
     $cadena.='
     <table><tr><td>
     <a  class="list-group-item list-group-item-action "><p style="cursor:pointer;color:blue;"> <button onClick="dar_baja('.$id_materia[$i].','.$id_alumno.');">Baja </button > /'.$fecha[$i].' /'.$hora[$i].' /'.$nombre[$i].'</p></a></tr>';

		
}



 } catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }

echo $cadena;












 ?>