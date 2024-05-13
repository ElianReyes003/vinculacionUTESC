<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dar de alta convenio</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php

include('conexion/conexion.php');

if (isset($_GET['pk'])) {
    $pk_empresa = $_GET['pk'];

    $bd = new Conexion;
    $conn = $bd->conectar();
    
    $query = $conn->prepare('UPDATE empresa SET estatus = 1 WHERE pk_empresa = :pk_empresa');
    $query->bindParam(':pk_empresa', $pk_empresa, PDO::PARAM_INT);
    ($query->execute());
    // Redirección
    echo '<script>
            Swal.fire({
                title: "Exito",
                text: "Convenio dado de alta",
                icon: "success",
                confirmButtonText: "Aceptar"
            }).then(function() {
                window.location.href = "categorias.php";
            });
        </script>';
    exit();
}

?>
    
</body>
</html>
