<?php

include('conexion/conexion.php');
$bd = new Conexion;
$conn = $bd->conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener valores
    $pk = $_POST['pk_empresa'];
    $nuevaFecha = $_POST['nuevaFecha'];

    // Update fecha
    $updateFecha = $conn->prepare('UPDATE convenio SET 
        final_convenio = :nuevaFecha
        WHERE fk_empresa = :pk'
    );
    $updateFecha->bindParam(':nuevaFecha', $nuevaFecha, PDO::PARAM_STR);
    $updateFecha->bindParam(':pk', $pk, PDO::PARAM_INT);

    // Update estatus
    $updateEstatus = $conn->prepare('UPDATE empresa SET 
        estatus = 1
        WHERE pk_empresa = :pk'
    );
    $updateEstatus->bindParam(':pk', $pk, PDO::PARAM_INT);

    if ($updateFecha->execute() && $updateEstatus->execute()){
       echo "success"; 
      } else {
          echo "Error al actualizar los datos.";
      }
}
?>
