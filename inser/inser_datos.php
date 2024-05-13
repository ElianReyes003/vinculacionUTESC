<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Registro de convenio exitoso!</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    
<?php
include('../conexion/conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_empresa = $_POST['nombre_empresa'];
    $descripcion = $_POST['descripcion'];

    $imagen =$_FILES['foto'];
    $enviar = '../img/';
    $archivo = $enviar.$nombre_empresa.'.png';

    if (empty($imagen['name']) || !file_exists($imagen['tmp_name'])) {
        $archivo_defecto = $enviar . 'img_ndp.png';
        $kakaroto = @copy($archivo_defecto, $archivo);
    } else {
        if (!file_exists($enviar)) {
            mkdir($enviar);
        }
        if (!file_exists($archivo)) {
            $kakaroto = @move_uploaded_file($imagen['tmp_name'], $archivo);
        }
    }

    $cantidad_empleados = $_POST['cantidad_empleados'];
    $fk_modal = $_POST['fk_modal'];
    $fk_apoyo = isset($_POST['nombre_apoyo']) ? $_POST['nombre_apoyo'] : array();
    $rfc = $_POST['rfc'];
    $inicio_convenio = $_POST['inicio_convenio'];
    $final_convenio = $_POST['final_convenio'];
    $fk_carrera = isset($_POST['nombre_carrera']) ? $_POST['nombre_carrera'] : array();
    $fk_pais = $_POST['fk_pais'];
    $fk_estado = $_POST['fk_estado'];
    $fk_municipio = $_POST['fk_municipio'];
    $nombre_ciudad = $_POST['nombre_ciudad'];
    $calle = $_POST['calle'];
    $fk_zona = $_POST['fk_zona'];
    $nombre_contacto = $_POST['nombre_contacto'];
    $correo_contacto = $_POST['correo_contacto'];
    $telefono_contacto = $_POST['telefono_contacto'];
    $cargo = $_POST['cargo'];

    $bd = new Conexion;
    $conn = $bd->conectar();

    $check_empresa = $conn->prepare('SELECT COUNT(*) FROM empresa WHERE nombre_empresa = ?');
    $check_empresa->execute([$nombre_empresa]);
    $row = $check_empresa->fetchColumn();

    if ($row > 0) {
        echo '<script>
            Swal.fire({
                title: "Error",
                text: "Este convenio ya se encuentra registrado",
                icon: "error",
                confirmButtonText: "Aceptar"
            }).then(function() {
                window.location.href = "../registro_empresa.php";
            });
        </script>';
    } else {
        // Continuar con la inserción de la empresa
        $insert_empresa = $conn->prepare('INSERT INTO empresa (nombre_empresa,foto, descripcion, cantidad_empleados, fk_modal, rfc) VALUES (?, ?, ?, ?, ?,?)');
        $insert_empresa->execute([$nombre_empresa, $archivo, $descripcion, $cantidad_empleados, $fk_modal,$rfc]);

        $last_empresa_id = $conn->lastInsertId();

        foreach ($fk_apoyo as $apoyo_id) {
            $insert_apoyo_emp = $conn->prepare('INSERT INTO apoyo_emp (fk_apoyo, fk_empresa) VALUES (?, ?)');
            $insert_apoyo_emp->execute([$apoyo_id, $last_empresa_id]);
        }

        $insert_convenio = $conn->prepare('INSERT INTO convenio (inicio_convenio, final_convenio, fk_empresa) VALUES (?, ?, ?)');
        $insert_convenio->execute([$inicio_convenio, $final_convenio, $last_empresa_id]);

        foreach ($fk_carrera as $carrera_id) {
            $insert_empresa_carrera = $conn->prepare('INSERT INTO empresa_carrera (fk_empresa, fk_carrera) VALUES (?, ?)');
            $insert_empresa_carrera->execute([$last_empresa_id, $carrera_id]);
        }

        $insert_ciudad = $conn->prepare('INSERT INTO ciudad (nombre_ciudad, calle, fk_pais, fk_estado, fk_empresa, fk_municipio, fk_zona) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $insert_ciudad->execute([$nombre_ciudad, $calle, $fk_pais, $fk_estado, $last_empresa_id, $fk_municipio, $fk_zona]);

        $insert_contacto = $conn->prepare('INSERT INTO contacto (nombre_contacto, correo, telefono, cargo, fk_empresa) VALUES (?, ?, ?, ?, ?)');
        $insert_contacto->execute([$nombre_contacto, $correo_contacto, $telefono_contacto, $cargo, $last_empresa_id]);

        echo '<script>
            Swal.fire({
                title: "Exito",
                text: "¡Registro de convenio exitoso!",
                icon: "success",
                confirmButtonText: "Aceptar"
            }).then(function() {
                window.location.href = "../categorias.php";
            });
        </script>';
    }
} else {
    echo '<script>
        Swal.fire({
            title: "Error",
            text: "¡Registro de convenio no exitoso!",
            icon: "error",
            confirmButtonText: "Aceptar"
        }).then(function() {
            window.location.href = "../registro_empresa.php";
        });
    </script>';
}
?>
    
</body>
</html>
