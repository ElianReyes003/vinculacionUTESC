<?php

	include ('conexion/conexion.php');

	$bd = new Conexion;
	$conn = $bd->conectar();

  $query = $conn -> prepare('SELECT * FROM modal ');
  $query->execute();
  $result = $query->fetchAll();

  $query8 = $conn->prepare('SELECT *, em.estatus AS estatus_empresa 
  FROM empresa em 
  INNER JOIN ciudad c ON c.fk_empresa = em.pk_empresa 
  INNER JOIN convenio co ON co.fk_empresa = em.pk_empresa 
  INNER JOIN zona z ON z.pk_zona = c.fk_zona 
  INNER JOIN contacto ct ON ct.fk_empresa = em.pk_empresa 
  WHERE em.estatus = 0 OR em.estatus = 2');
	$query8->execute();
	$results = $query8->fetchAll();

  $query2 = $conn -> prepare('SELECT * FROM  apoyo ');
  $query2->execute();
  $result2 = $query2->fetchAll();

  $query3= $conn -> prepare('SELECT * FROM  carrera');
  $query3->execute();
  $result3 = $query3->fetchAll();

	$query4= $conn -> prepare('SELECT * FROM zona');
  $query4->execute();
  $result4 = $query4->fetchAll();

  $query5 = $conn -> prepare('SELECT * FROM pais');
  $query5->execute();
  $result5 = $query5->fetchAll();

  $query6 = $conn -> prepare('SELECT * FROM estado');
  $query6->execute();
  $result6 = $query6->fetchAll();
  
  $query7 = $conn -> prepare('SELECT * FROM municipio');
  $query7->execute();
  $result7 = $query7->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="jquery-3.5.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/styles.css?=1">
    <title>Lista de convenios</title>
</head>
<?php include('header.php'); ?>  
<br>
<!--BOTON FILTRO Y NUEVO REGISTRO-->
<div class="btns_lista">
  <div class="dropdown">
    <button class="btn_filtros">Filtrar por:</button>
    <div class="dropdown-content">

        <form id="formulario" class="box_filtro">

              <div class="subbox1_filtro">
              CARRERA:
                <ul class="check_filtros">
                    <?php
                    foreach ($result3 as $opciones3):
                    ?>
                        <li>
                            <input class="filtro" type="checkbox" value="<?php echo $opciones3['pk_carrera']?>" name="fk_carrera">
                            <label><?= $opciones3['nombre_carrera']?></label>
                        </li>
                    <?php endforeach?>
                </ul>
              </div>
              
              <div class="subbox_filtro">
              <div>
              ZONA:
                <ul class="check_filtros">
                <?php foreach ($result4 as $opciones4): ?>
                <li>
                  <input class="filtro" type="checkbox" id="item1" value="<?php echo $opciones4['pk_zona']?>" name="fk_zona">
                  <label><?= $opciones4['influencia']?></label>
                </li>
                <?php endforeach?>
                </ul>
              </div>

              <div>
              APOYO: 
                <ul class="check_filtros">
                <?php foreach ($result2 as $opciones2): ?>
                <li>
                  <input class="filtro" type="checkbox" value="<?php echo $opciones2['pk_apoyo']?>" name="fk_apoyo">
                  <label><?=$opciones2['nombre_apoyo']?></label>
                </li>
                <?php endforeach?>
                </ul>
              </div>

              <div>
              MODALIDAD:   
                <ul class="check_filtros">
                  <?php foreach ($result as $opciones): ?>
                  <li>
                    <input class="filtro" type="checkbox" value="<?php echo $opciones['pk_modal']?>" name="fk_modalidad">
                    <label><?=$opciones['nombre_modal']?></label>
                  </li>
                  <?php endforeach?>
                </ul>
              </div>

              <div>
                PAÍS: <br>
                    <select class="select_tam filtro" onchange="cargarEstados();" id="fk_pais" name="fk_pais">
                        <option disabled="" selected>Seleccionar</option>
                        <?php
                        foreach ($result5 as $opciones5):
                        ?>
                            <option value="<?php echo $opciones5['pk_pais']?>">
                                <?php echo $opciones5['nombre_pais']?>
                            </option>
                        <?php endforeach?>
                    </select>
              </div>

              <div>
                  ESTADO: <br>
                      <select class="select_tam filtro" onchange="cargarMunicipios();" id="fk_estado" name="fk_estado">
                          <option disabled="" selected>Seleccionar</option>
                          <?php
                          foreach ($result6 as $opciones6):
                          ?>
                              <option value="<?php echo $opciones6['pk_estado']?>">
                                  <?php echo $opciones6['nombre_estado']?>
                              </option>
                          <?php endforeach?>
                      </select>
              </div>

              <div>
                  MUNICIPIO: <br>
                      <select class="select_tam filtro" id="fk_municipio" name="fk_municipio">
                          <option disabled="" selected>Seleccionar</option>
                          <?php
                          foreach ($result7 as $opciones7):
                          ?>
                              <option value="<?php echo $opciones7['pk_municipio']?>">
                                  <?php echo $opciones7['nombre_municipio']?>
                              </option>
                          <?php endforeach?>
                      </select>
              </div>
         </div>
        </form>
    </div>
  </div>
  <a href="registro_empresa.php">
    <button class="btn_nuevo_registro">Registrar nuevo convenio</button>
  </a>
</div>
<br>
<hr style="margin:0px">
<br>

<div class="contenedor" id="resultados">
<?php
        foreach($results as $da){
          $fechaFinalConvenio = new DateTime($da['final_convenio']);
          $hoy = new DateTime();
          $diasRestantes = max(0, $hoy->diff($fechaFinalConvenio)->format('%r%a'));
        ?>
            <div class="box">

                <img class="subbox-imag" src="img/<?php $img = $da['foto']; echo $img ?>" >
                <div  class="subbox-info">
                    <h2 class="nom_empresa"><?php $nombre =$da ['nombre_empresa']; echo $nombre ?></h2>
                    <p class="desc_empresa"> <?php $des = $da ['descripcion']; echo $des ?></p>
                    
                    <?php
                    $estatus = $da ['estatus_empresa'];
                    if($estatus==2){
                      echo "<h6>Convenio vencido</h6>";
                    }else{
                      echo "<h6>Dado de baja</h6>";
                    }
                    ?>
                </div>

              <hr>
            
                <div class="subbox-btns">

                    <a class="btns" href="informacion.php?pk=<?=$da ['pk_empresa']; ?>" >
                        <span>VER DETALLES</span>
                    </a>

                    <a class="btns" href="empresa.php?pk=<?=$da ['pk_empresa']; ?>">
                        <span>EDITAR</span>
                    </a>
                    <?php if ($estatus == 2): ?>
                        <a class="btns" onclick="mostrarFormulario('<?=$da ['pk_empresa']; ?>','<?=$da ['final_convenio']; ?>');">
                            <span>DAR DE ALTA</span>
                        </a>
                    <?php elseif ($estatus == 0): ?>
                      <a class="btns" href="dar_de_alta_empresa.php?pk=<?=$da ['pk_empresa']; ?>">
                        <span>DAR DE ALTA</span>
                    </a>
                    <?php endif; ?>

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
<script type="text/javascript">
function mostrarFormulario(pk_empresa, fechaFinActual) {
    Swal.fire({
        title: 'Modificar Fecha',
        html:
            '<label>FECHA FIN DE CONVENIO:</label>' +
            '<input type="date" id="nuevaFecha" class="swal2-input" value="' + fechaFinActual + '">',
        showCancelButton: true,
        confirmButtonText: 'Actualizar y dar de alta',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            const nuevaFecha = document.getElementById('nuevaFecha').value;
            $.ajax({
                url: 'update_fecha_estatus.php',
                type: 'POST',
                data: {
                    pk_empresa: pk_empresa,
                    nuevaFecha: nuevaFecha
                },
                success: function(response) {
                  console.log(response); 
                    if (response === 'success') {
                      Swal.fire({
                          title: "Exito",
                          text: "Convenio dado de alta",
                          icon: "success",
                          confirmButtonText: "Aceptar"
                      }).then(function() {
                          window.location.href = "categorias.php";
                          });
                    }
                }
            });
        }
    });
}

function cargarEstados() {
var paisSeleccionado = document.getElementById("fk_pais").value;
var estadoSelect = document.getElementById("fk_estado");

fetch('obtener_estados.php?pais=' + paisSeleccionado)
    .then(response => response.json())
    .then(data => {
        estadoSelect.innerHTML = '<option value="">Seleccionar</option>';
        data.forEach(estado => {
            estadoSelect.innerHTML += `<option value="${estado.pk_estado}">${estado.nombre_estado}</option>`;
        });
    })
    .catch(error => console.error('Error al obtener los estados: ' + error));
}

function cargarMunicipios() {
var estadoSeleccionado = document.getElementById("fk_estado").value;
var municipioSelect = document.getElementById("fk_municipio");

fetch('obtener_municipios.php?estado=' + estadoSeleccionado)
    .then(response => response.json())
    .then(data => {
        municipioSelect.innerHTML = '<option value="">Seleccionar</option>';
        data.forEach(municipio => {
            municipioSelect.innerHTML += `<option value="${municipio.pk_municipio}">${municipio.nombre_municipio}</option>`;
        });
    })
    .catch(error => console.error('Error al obtener los municipios: ' + error));
}


//FITROOOOOOOOOOOSSSS
$(".filtro").on("change", function(e) {
  e.preventDefault();
  
  $.ajax({
    type: "POST",
    url: "filtros_baja.php",
    data: $("#formulario").serialize(),
    dataType: "html",
    error: function() {
      alert("Error");
    },
    success: function(data) {
      $("#resultados").html(data);
    }
  });
});


</script>
</body>
</html>

    