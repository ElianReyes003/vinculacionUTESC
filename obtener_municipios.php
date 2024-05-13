<?php
include('conexion/conexion.php');

$bd = new Conexion;
$conn = $bd->conectar();

if (isset($_GET['estado'])) {
    $estadoSeleccionado = $_GET['estado'];

    $query = $conn->prepare('SELECT * FROM municipio WHERE fk_estado = :estado');
    $query->bindParam(':estado', $estadoSeleccionado, PDO::PARAM_INT);
    $query->execute();
    $municipios = $query->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($municipios);
} else {
    echo json_encode(array('error' => 'No se especificó un estado.'));
}
?>
