<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
include ('conexion/conexion.php');

$fkcarrera = isset($_POST["fk_carrera"]) ? $_POST["fk_carrera"] : null;
$fkzona = isset($_POST["fk_zona"]) ? $_POST["fk_zona"] : null;
$fkapoyo = isset($_POST["fk_apoyo"]) ? $_POST["fk_apoyo"] : null;
$fkmodalidad = isset($_POST["fk_modalidad"]) ? $_POST["fk_modalidad"] : null;
$fkpais = isset($_POST["fk_pais"]) ? $_POST["fk_pais"] : null;
$fkestado = isset($_POST["fk_estado"]) ? $_POST["fk_estado"] : null;
$fkmunicipio = isset($_POST["fk_municipio"]) ? $_POST["fk_municipio"] : null;

$bd = new Conexion;
$conn = $bd->conectar();

//Todos los convenios
$consulta ="SELECT DISTINCT pk_empresa, nombre_empresa, foto, descripcion FROM empresa em
/*Carrera*/
INNER JOIN empresa_carrera ec ON ec.fk_empresa = em.pk_empresa 
INNER JOIN carrera ca ON ec.fk_carrera = ca.pk_carrera
/*Ciudad*/
INNER JOIN ciudad ci ON ci.fk_empresa = em.pk_empresa
/*Zona*/
INNER JOIN zona zo ON ci.fk_zona = zo.pk_zona
/*Apoyo*/
INNER JOIN apoyo_emp ae ON ae.fk_empresa = em.pk_empresa
INNER JOIN apoyo ap ON ae.fk_apoyo = ap.pk_apoyo
/*Modalidad*/
INNER JOIN modal mo ON em.fk_modal = mo.pk_modal
/*Pais*/
INNER JOIN pais pa ON ci.fk_pais = pa.pk_pais
/*Estado*/
INNER JOIN estado es ON ci.fk_estado = es.pk_estado
/*Municipio*/
INNER JOIN municipio mu ON ci.fk_municipio = mu.pk_municipio
WHERE em.estatus = '0'";

if(!empty($fkcarrera)){
    $consulta .= "AND ca.pk_carrera = '$fkcarrera'";
}
if(!empty($fkzona)){
    $consulta .="AND zo.pk_zona='$fkzona'";
}
if(!empty($fkapoyo)){
    $consulta .="AND ap.pk_apoyo='$fkapoyo'";
}
if(!empty($fkmodalidad)){
    $consulta .="AND mo.pk_modal='$fkmodalidad'";
}
if(!empty($fkpais)){
    $consulta .="AND pa.pk_pais='$fkpais'";
}
if(!empty($fkestado)){
    $consulta .="AND es.pk_estado='$fkestado'";
}
if(!empty($fkmunicipio)){
    $consulta .="AND mu.pk_municipio='$fkmunicipio'";
}

$s = $conn -> prepare($consulta);
$s->execute();
$results = $s->fetchAll();

if (count($results) > 0) {
    // Mostrar resultados
    foreach ($results as $da) {
        echo '<div class="box">';
        echo '<img class="subbox-imag" src="img/' . $da['foto'] . '">';
        echo '<div class="subbox-info">';
        echo '<h2 class="nom_empresa">' . $da['nombre_empresa'] . '</h2>';
        echo '<p class="desc_empresa">' . $da['descripcion'] . '</p>';
        echo '</div>';
        echo '<hr>';
        echo '<div class="subbox-btns">';
        echo '<a class="btns" href="informacion.php?pk=' . $da['pk_empresa'] . '">';
        echo '<span>VER DETALLES</span>';
        echo '</a>';
        echo '<a class="btns" href="empresa.php?pk=' . $da['pk_empresa'] . '">';
        echo '<span>EDITAR</span>';
        echo '</a>';
        echo '<a class="btns" href="dar_de_alta_empresa.php?pk=' . $da['pk_empresa'] . '">';
        echo '<span>DAR DE ALTA</span>';
        echo '</a>';
        echo '</div>';
        echo '<div class="subbox-btns">';
        echo '<a class="btns btn_reporte" href="descargar.php?pk='.$da['pk_empresa'] . '">';
        echo '<span>DESCARGAR CONTRATO</span>';
        echo '</a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<script>
            Swal.fire({
                title: "Intenta de nuevo",
                text: "No se encontro ningun resultado para esta busqueda",
                icon: "warning",
                confirmButtonText: "Aceptar",
                timer: 1500
            });
        </script>';
}
?>
</body>
</html>