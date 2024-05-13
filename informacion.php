<?php
session_start();
if(!isset($_SESSION["pk_usuario"])){
  header("location: login.php");
}
	include ('conexion/conexion.php');
    $pk=$_GET["pk"];
	$bd = new Conexion;
	$conn = $bd->conectar();

	$query = $conn -> prepare('SELECT * FROM empresa em 
     INNER JOIN ciudad ci ON em.pk_empresa = ci.fk_empresa
     INNER JOIN estado et ON et.pk_estado = ci.fk_estado 
     INNER JOIN convenio c ON em.pk_empresa = c.fk_empresa 
     INNER JOIN zona z ON z.pk_zona = ci.fk_zona 
     INNER JOIN municipio mu ON mu.pk_municipio = ci.fk_municipio
     INNER JOIN contacto con ON em.pk_empresa = con.fk_empresa 
     INNER JOIN pais p ON p.pk_pais = ci.fk_pais 
     WHERE em.pk_empresa ='.$pk);
	$query->execute();
	$result = $query->fetch();


    $query2 = $conn -> prepare('SELECT * FROM empresa_carrera amc INNER JOIN
     carrera ca ON ca.pk_carrera = amc.fk_carrera
     WHERE amc.fk_empresa ='.$pk);
     $query2->execute();
     $result2 = $query2->fetchAll();

     $query3 = $conn -> prepare(' SELECT * FROM apoyo_emp ap INNER JOIN apoyo p ON
     p.pk_apoyo = ap.fk_apoyo WHERE fk_empresa ='.$pk);
      $query3->execute();
      $result3 = $query3->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de <?php echo $result['nombre_empresa'];?> </title>
    <link rel="stylesheet" href="css/styles.css?=1">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>
<body>
<?php include('header.php'); ?>  

<div class="cont_dtlls">
    <div class="cont_img">
        <img class="img_dtlls" src="img/<?php echo $result['foto']; ?>" alt="Logo de la empresa">
    </div>
    <div class="cont_text">
        <div class="text_princ">
            <h1><?php echo $result['nombre_empresa'];?></h1>
            <p><?php echo $result['descripcion'];?></p>
        </div>
        <br>
        <div class="subcont_text">
            <div class="box_text">
                <h3>Detalles</h3>
                <p><?php echo $result['rfc'];?></p>
                <?php $tamaño = $result['cantidad_empleados'];
                if($tamaño<=10){
                echo 'Empresa chica';
                }
                elseif($tamaño>=11 AND $tamaño<=250){
                    echo 'Empresa mediana';
                }
                else{
                    echo 'Empresa grande';
                }
                 ?>

            </div>
            <div class="box_text">
                <h3>Fecha</h3>
                <h4>Inicio de convenio</h4>
                <p>
                    <?php echo $result['inicio_convenio'];?>
                </p>
                <h4>Fin de convenio</h4>
                <p>
                    <?php echo $result['final_convenio'];?>
                </p>        
            </div>
            <div class="box_text">
                <h3>Ubicacion</h3>
                <p><?php echo $result['nombre_pais'];?></p>
                <p><?php echo $result['nombre_estado'];?></p>
                <p><?php echo $result['nombre_municipio'];?></p>
                <p><?php echo $result['nombre_ciudad'];?></p>
                <a class="btn_ubi" href="https://www.google.com/maps/place/<?php echo $result['calle'];?>"><b>Ir al mapa</b></a>
            </div>
            <div class="box_text">
                <h3>Carreras</h3>
                <p>
                    <?php foreach ($result2 as $opciones2):?>
                    <?php  echo $opciones2['nombre_carrera'];?>
                </p>
                <?php endforeach?>
                <a href="detalle_empresa.php?pk=<?=$da['pk_empresa'];?>" style="color:blue;"></a>
            </div>
            <div class="box_text">
                <h3>Apoyo</h3>
                <p> 
                    <?php foreach ($result3 as $opciones3):?>
                    <?php echo $opciones3['nombre_apoyo'];?>
                </p>
                <?php endforeach?>
            </div>
            <div class="box_text cont_correo">
                <h3>Contacto</h3>
                <p><?php echo $result['nombre_contacto'];?></p>
                <p><?php echo $result['telefono'];?></p>
                <p><?php echo $result['correo'];?></p>
                <p><?php echo $result['cargo'];?></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>