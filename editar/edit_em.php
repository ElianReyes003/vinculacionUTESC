<?php
session_start();
if(!isset($_SESSION["pk_usuario"])){
  header("location: login.php");
}

include('../conexion/conexion.php');

$bd = new Conexion;
$conn = $bd->conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pk = $_POST['pk'];

    // Me traigo los datos
    $nombre_empresa = $_POST['nombre_empresa'];
    $descripcion = $_POST['descripcion'];
    $cantidad_empleados = $_POST['cantidad_empleados'];
    $fk_modal = $_POST['fk_modal'];
    $rfc = $_POST['rfc'];
    $inicio_convenio = $_POST['inicio_convenio'];
    $final_convenio = $_POST['final_convenio'];

    // Foto
    if (!empty($_FILES['foto']['name'])) {
        $foto_nombre = $_FILES['foto']['name'];
        $foto_temp = $_FILES['foto']['tmp_name'];
        $foto_destino = "../img/" . $foto_nombre;  

        move_uploaded_file($foto_temp, $foto_destino);

        $update_foto_query = $conn->prepare('UPDATE empresa SET foto = :foto WHERE pk_empresa = :pk');
        $update_foto_query->bindParam(':foto', $foto_destino);
        $update_foto_query->bindParam(':pk', $pk);
        $update_foto_query->execute();
    }

    // Tabla - Empresa
    $update_empresa_query = $conn->prepare('UPDATE empresa SET 
        nombre_empresa = :nombre_empresa,
        descripcion = :descripcion,
        cantidad_empleados = :cantidad_empleados,
        fk_modal = :fk_modal,
        rfc = :rfc
        WHERE pk_empresa = :pk'
    );
    $update_empresa_query->bindParam(':nombre_empresa', $nombre_empresa);
    $update_empresa_query->bindParam(':descripcion', $descripcion);
    $update_empresa_query->bindParam(':cantidad_empleados', $cantidad_empleados);
    $update_empresa_query->bindParam(':fk_modal', $fk_modal);
    $update_empresa_query->bindParam(':rfc', $rfc);
    $update_empresa_query->bindParam(':pk', $pk);

    // Tabla - Convenios
    $update_convenio_query = $conn->prepare('UPDATE convenio SET 
        inicio_convenio = :inicio_convenio,
        final_convenio = :final_convenio
        WHERE fk_empresa = :pk'
    );
    $update_convenio_query->bindParam(':inicio_convenio', $inicio_convenio);
    $update_convenio_query->bindParam(':final_convenio', $final_convenio);
    $update_convenio_query->bindParam(':pk', $pk);

    // Tabla - Apoyo
   $delete_apoyo_emp = $conn->prepare('DELETE FROM  apoyo_emp  WHERE fk_empresa = ?');
   $delete_apoyo_emp->bindParam(1,$pk, PDO::PARAM_STR);
   $delete_apoyo_emp->execute();

   foreach($_POST['nombre_apoyo'] as $apoyo){
   $insert_apoyo_emp = $conn->prepare('INSERT INTO apoyo_emp (fk_apoyo, fk_empresa) VALUES (?,?)');
   $insert_apoyo_emp->bindParam(1,$apoyo, PDO::PARAM_STR);
   $insert_apoyo_emp->bindParam(2,$pk, PDO::PARAM_STR);
   $insert_apoyo_emp->execute();
   }

   // Tabla - Carrera
   $delete_empresa_carr = $conn->prepare('DELETE FROM  empresa_carrera  WHERE fk_empresa = ?');
   $delete_empresa_carr->bindParam(1,$pk, PDO::PARAM_STR);
   $delete_empresa_carr->execute();

   foreach($_POST['nombre_carrera'] as $carrera){
   $insert_empresa_carr = $conn->prepare('INSERT INTO  empresa_carrera (fk_empresa,fk_carrera,estatus) VALUE (?,?,1)');
   $insert_empresa_carr->bindParam(1 ,$pk ,PDO::PARAM_STR);
   $insert_empresa_carr->bindParam(2 ,$carrera, PDO::PARAM_STR);
   $insert_empresa_carr->execute();
   }


    if ($update_empresa_query->execute() && $update_convenio_query->execute() && $delete_apoyo_emp->execute() && $insert_apoyo_emp->execute() && $delete_empresa_carr->execute() && $insert_empresa_carr->execute()){
      ?>
       <script>location.href = '../ubicacion.php?pk=<?=$pk?>'</script> 
     <?php
    } else {
        echo "Error al actualizar los datos de la empresa.";
    }
}
?>
