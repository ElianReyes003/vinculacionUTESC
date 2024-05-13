<?php
include('conexion/conexion.php');

$bd = new Conexion;
$conn = $bd->conectar();

if (isset($_GET['pais'])) {
    $paisSeleccionado = $_GET['pais'];
    
    $query = $conn->prepare('SELECT * FROM estado WHERE fk_pais = :pais');
    $query->bindParam(':pais', $paisSeleccionado, PDO::PARAM_INT);
    $query->execute();

    $estados = $query->fetchAll(PDO::FETCH_ASSOC);

    // Devuelve los estados en formato JSON
    header('Content-Type: application/json');
    echo json_encode($estados);
} else {
    // Si no se proporcionó un país, devuelve un JSON vacío o un mensaje de error
    echo json_encode(array('error' => 'No se especificó un país.'));
}
?>
