<?php
session_start();
if(!isset($_SESSION["pk_usuario"])){
  header("location: login.php");
}
	include ('conexion/conexion.php');

	$bd = new Conexion;
	$conn = $bd->conectar();

	$query = $conn -> prepare('SELECT * FROM empresa em INNER JOIN ciudad c ON c.fk_empresa 
  = em.pk_empresa INNER JOIN convenio co ON co.fk_empresa = em.pk_empresa INNER JOIN zona z
   ON z.pk_zona = c.fk_zona INNER JOIN contacto ct ON ct.fk_empresa = em.pk_empresa where em.estatus=1');
	$query->execute();
	$results = $query->fetchAll();
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/styles.css?=1">
    <title>Lista de convenios</title>
</head>

<body>
<?php include('header.php'); ?>
<br>
<h2 class="titulo2" >CONVENIOS POR VENCER (menos de 1 mes)</h2>
<hr style="margin:0px">
<div class="cont_fe_hr">
    Sesión iniciada como: <?php echo $_SESSION["name"];?> 
    <div id="fecha-hora">
    Fecha y hora: 
    </div>
</div>

<br>
<div class="contenedor">
        <?php
      foreach($results as $da){
        $fechaFinalConvenio = new DateTime($da['final_convenio']);
        $hoy = new DateTime();
        $diasRestantes = max(0, $hoy->diff($fechaFinalConvenio)->format('%r%a'));

        if($diasRestantes==0){
            $vencido = $conn->prepare('UPDATE empresa SET estatus = 2 WHERE pk_empresa = :pk_empresa');
            $vencido->bindParam(':pk_empresa', $da['pk_empresa'], PDO::PARAM_INT);
            ($vencido->execute());        
        }else if($diasRestantes>30) {
            continue;
        }
        ?>
            <div class="box">

                <img class="subbox-imag" src="img/<?php $img = $da['foto']; echo $img ?>" >

                <div  class="subbox-info">
                    <h2 class="nom_empresa"><?php $nombre =$da ['nombre_empresa']; echo $nombre ?></h2>
                    <p class="desc_empresa"> <?php $des = $da ['descripcion']; echo $des ?></p>
                    <span class="dia_empresa"><?= $diasRestantes ?> días restantes</span>
                </div>

                <hr>
            
                <div  class="subbox-btns">

                    <a class="btns" href="informacion.php?pk=<?=$da ['pk_empresa']; ?>" >
                        <span>VER DETALLES</span>
                    </a>

                    <a class="btns" href="empresa.php?pk=<?=$da ['pk_empresa']; ?>">
                        <span>EDITAR</span>
                    </a>

                    <a class="btns" href="eliminar_empresa.php?pk=<?=$da ['pk_empresa']; ?>">
                        <span>DAR DE BAJA</span>
                    </a>

                </div>
                <div class="subbox-btns">
                    <a class="btns btn_reporte" href="descargar.php?pk=<?=$da ['pk_empresa'];?>">
                        <span>DESCARGAR CONTRATO</span>
                    </a>
                </div>
            </div>
    <?php
    }
    ?>  
</div>
<script>
    function actualizarFechaYHora() {
      const divFechaHora = document.getElementById("fecha-hora");
      const fechaHoraActual = new Date();
      const fechaHoraTexto = fechaHoraActual.toLocaleString();
      divFechaHora.textContent = "Fecha y hora: " + fechaHoraTexto;
    }

    // Actualiza la fecha y hora cada segundo
    setInterval(actualizarFechaYHora, 1000);

    // Llama a la función inicialmente para mostrar la hora de inmediato
    actualizarFechaYHora();
  </script>
</body>
</html>