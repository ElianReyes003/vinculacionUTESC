<?php
session_start();
if(!isset($_SESSION["pk_usuario"])){
  header("location: login.php");
}

   include('../conexion/conexion.php');
   $bd = new conexion();
   $conn = $bd -> conectar();

   $pk_empresa =  $_POST['pk'];
   
   // return;

   $query = $conn-> prepare("UPDATE ciudad  SET  nombre_ciudad =?, calle =?, fk_pais =?, 
   fk_estado =?,  fk_empresa = ?, fk_zona=?, estatus = ? WHERE fk_empresa = ".$pk_empresa);


   $nombre =$_POST['nombre_ciudad'];
   $calle  = $_POST['calle'];
   $pais = $_POST['fk_pais'];
   $estado =$_POST['fk_estado'];
   $empresa = $pk_empresa;
   $zona = $_POST['fk_zona'];
   $estatus = 1;



   $query -> bindParam(1, $nombre);
   $query -> bindParam(2, $calle);
   $query -> bindParam(3, $pais);
   $query -> bindParam(4, $estado);
   $query -> bindParam(5, $pk_empresa);
   $query -> bindParam(6, $zona);
   $query -> bindParam(7, $estatus);

   



   if ( $query -> execute() ){
      ?>
      <script>location.href = '../concto.php?pk=<?=$pk_empresa?>'</script>
      <?php
      }else{
      echo "ERROR";
   }


?>