<?php
session_start();

if(isset($_SESSION['dni'])) {
  session_destroy();
  header('location:iniciar_sesion.php');
}
?>
