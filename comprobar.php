<?php 



    $server = "localhost";
  $usuario = "root";
  $contra = "";
  $basedato = "profesorado_cef";
  $numero = $_GET['numero'];

  try {
    $con = new PDO('mysql:host='.$server.';dbname='.$basedato.'', "$usuario", "$contra");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    $sql = $con->prepare(
      'SELECT numero FROM comprobante_certificado WHERE numero = :numero'
    );

    $sql->execute(
      array(
      	'numero' => $numero
        ));

    if($datos = $sql->fetch(PDO::FETCH_ASSOC)) {
    	
    	echo "El numero de comprobante: ".$numero." Si se encuentra dentro de nuestros registros.";;  
    
    }
    else{
    	echo "El numero de comprobante: ".$numero." No se encuentra dentro de nuestros registros";
    }


  } catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }







 ?>