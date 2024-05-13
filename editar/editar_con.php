<?php 
session_start();
if(!isset($_SESSION["pk_usuario"])){
  header("location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>¡Actualización de convenio exitosa!</title>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
   
<?php
   include('../conexion/conexion.php');
   $bd = new conexion();
   $conn = $bd -> conectar();

   $pk_empresa =  $_POST['pk'];   
   // return;

   $query = $conn-> prepare("UPDATE contacto SET  nombre_contacto =?, telefono =?, correo =?, 
   cargo=?,  fk_empresa = ?, estatus=? WHERE fk_empresa = ".$pk_empresa);



   $nombre =$_POST['nombre_contacto'];
   $telefono  = $_POST['telefono'];
   $correo  = $_POST['correo'];
   $cargo =$_POST['cargo'];
   $empresa = $pk_empresa;
   $estatus = 1;


   $query -> bindParam(1, $nombre);
   $query -> bindParam(2, $telefono);
   $query -> bindParam(3, $correo);
   $query -> bindParam(4, $cargo);
   $query -> bindParam(5, $pk_empresa);
   $query -> bindParam(6, $estatus);


   if ( $query -> execute() ){
      echo '<script>
      Swal.fire({
          title: "Exito",
          text: "¡Actualización de convenio exitosa!",
          icon: "success",
          confirmButtonText: "Aceptar"
      }).then(function() {
          window.location.href = "../categorias.php";
      });
  </script>';
   }else{
      echo '<script>
      Swal.fire({
          title: "Cambios no guardados",
          text: "¡Actualización de convenio no exitosa!",
          icon: "error",
          confirmButtonText: "Aceptar"
      }).then(function() {
          window.location.href = "../categorias.php";
      });
  </script>';
   }

?>
</body>
</html>
