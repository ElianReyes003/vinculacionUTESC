<?php
session_start();
if(!isset($_SESSION["pk_usuario"])){
  header("location: login.php");
}
?>