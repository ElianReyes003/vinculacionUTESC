<?php
session_start();
require 'conexion/conexion.php';
include('vendor/autoload.php');
$correogmail = "195230904845-41ka1uqvf8a5bgl02ai0sigcbasephcj.apps.googleusercontent.com";
$bd = new Conexion();
$conn = $bd->conectar();
$client = new Google_Client(["client_id" => $correogmail]);

$payload = $client->verifyIdToken($_POST["credential"]);

if ($payload && $payload["aud"] == $correogmail) {
    $correo = $payload["email"];
    $name = $payload['name']; 

    $_SESSION["name"] = $name;

    if (strpos($correo, "@gmail.com") === false) {
        header('location: login.php');

    } else {
        $sql = 'CALL ObtenerUsuarioPorCorreo(?)';
        $insert = $conn->prepare($sql);+
        $insert->bindParam(1, $correo);
        $insert->execute();

        $datos = $insert->fetchAll();

        if (empty($datos)) {
            header('location: login.php');
        } else {
            $_SESSION['pk_usuario'] = $datos[0]['pk_usuario'];
            header('location: convenio.php');
        }
    }
} else {
    echo "Token is invalid";
}


    ?>
