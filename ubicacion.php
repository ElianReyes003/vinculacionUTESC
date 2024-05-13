<?php  
session_start();
if(!isset($_SESSION["pk_usuario"])){
  header("location: login.php");
}

    include ('conexion/conexion.php');

	$bd = new Conexion;
	$conn = $bd->conectar();
    $pk = $_GET['pk'];

    $query = $conn -> prepare('SELECT * FROM pais');
    $query->execute();
	  $result = $query->fetchAll();

    $query2 = $conn -> prepare('SELECT * FROM  estado');
    $query2->execute();
	  $result2 = $query2->fetchAll();

    $query7 = $conn -> prepare('SELECT * FROM  municipio');
    $query7->execute();
	  $result7 = $query7->fetchAll();

    $query3 = $conn->prepare('SELECT ci.*, p.nombre_pais, es.nombre_estado, z.influencia, mu.nombre_municipio 
                        FROM ciudad ci
                        INNER JOIN pais p ON ci.fk_pais = p.pk_pais
                        INNER JOIN estado es ON ci.fk_estado = es.pk_estado
                        INNER JOIN zona z ON ci.fk_zona = z.pk_zona
                        INNER JOIN empresa em ON ci.fk_empresa = em.pk_empresa
                        INNER JOIN municipio mu ON ci.fk_municipio = mu.pk_municipio
                        WHERE em.pk_empresa = :pk_empresa');
$query3->bindParam(':pk_empresa', $pk, PDO::PARAM_INT);
$query3->execute();
$result3 = $query3->fetch();

    $query4= $conn -> prepare('SELECT * FROM  zona');
    $query4->execute();
	  $result4 = $query4->fetchAll();

    $query5 = $conn -> prepare('SELECT * FROM empresa WHERE pk_empresa = '.$pk);
    $query5->execute();
    $result5 = $query5->fetch();
?>

<!DOCTYPE html>
<html lang="es">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/detalle-empresa.css?=1">
    <title>Editar convenio - Ubicación</title>
</head>
<?php include('header.php'); ?>  

<section>
        <form method="POST"  action="editar/edita_ub.php" onsubmit="return validarFormulario();">
            <div class="info-box">

                <h2>Editar convenio - <?= $result5['nombre_empresa']?></h2>
                <input type="hidden" VALUE="<?php echo $_GET['pk']?>" name="pk">
                <hr>
                
                <div class="secciones">
                <form id="formulario-empresa">
                <div>
                <div href="registro_empresa.php" id="circulo-empresa"></div>
                <img class="img_flechas" src="imag/Flecha.png" alt="">
                </div>
                </form>
                <h6 class="text_secciones">Detalle De La Empresa</h6>

                <form id="formulario-ubicacion">
                <div>
                <div href="detalle_ubicacion.php" id="circulo-ubicacion"></div>
                <img class="img_flechas" src="imag/Flecha.png" alt="">
                </div>
                </form>
                <h6 style="color: #008080; font-weight:bold;" class="text_secciones">Detalle De La Ubicación</h6>

                <form id="formulario-contacto">
                <div>
                <div href="detalle_contacto.php" id="circulo-contacto"></div>
                <img class="img_flechas" src="imag/Flecha.png" alt="">
                </div>
                </form>
                <h6 class="text_secciones">Detalle Del Contacto</h6>
                </div>
                <hr>

                <h3>Detalle De La Ubicación</h3>
                <br>

                <div class="contain">
                  <div class="subcontainer">
                  <div>
                  <label class="frm-label">PAÍS:
                    <br>
                  <select class="frm-input" onchange="zona(); cargarEstados();" name="fk_pais" id="fk_pais">
                  <option value="<?= $result3['fk_pais']?>" selected><?= $result3['nombre_pais'];?></option>
                  <?php 
                    foreach ($result as $opciones):
                      ?>
                  <option value="<?php echo $opciones['pk_pais']?>">
                  <?php echo $opciones['nombre_pais']?></option>
                  <?php endforeach?>
              </select>
                  </label>
                </div>

                <div>
                  <label class="frm-label3">ESTADO:
                    <br>
                  <select class="frm-input3" onchange="zona(); cargarMunicipios();" name="fk_estado" id="fk_estado">
                  <option value="<?= $result3['fk_estado']?>"selected><?= $result3['nombre_estado'];?></option>
                <?php 
                    foreach ($result2 as $opciones2):
                ?>
                <option value="<?php echo $opciones2['pk_estado']?>">
                <?php echo $opciones2['nombre_estado']?></option>
                <?php endforeach?>
                </select>
                </div>

                <div>
                  <label class="frm-label3">MUNICIPIO:
                    <br>
                  <select class="frm-input3" onchange="zona()" name="fk_municipio" id="fk_municipio">
                <option value="<?= $result3['fk_municipio']?>"selected><?= $result3['nombre_municipio'];?></option>
                <?php 
                    foreach ($result7 as $opciones3):
                ?>
                <option value="<?php echo $opciones3['pk_municipio']?>">
                <?php echo $opciones3['nombre_municipio']?></option>
                <?php endforeach?>
                </select>
                </div>

                <div>
                  <label class="frm-label1">CIUDAD:
                    <br>
                  <input type="text" name="nombre_ciudad" class="frm-input1" value="<?= $result3['nombre_ciudad']?>"  id="ciudad">
                  </label>
                </div>

                <div>
                  <label class="frm-label2">ZONA:
                    <br>
                  <select class="frm-input2"name="fk_zona" id="fk_zona">
                  <option value="<?= $result3['fk_zona']?>" selected><?= $result3['influencia'];?></option>
                  <?php 
                      foreach ($result4 as $opciones4):
                  ?>
                  <option value="<?php echo $opciones4['pk_zona']?>">
                  <?php echo $opciones4['influencia']?></option>
                  <?php endforeach?>
                  </select>
                  </label>
                </div>
                
                <div>
                  <label class="frm-label4">DIRECCIÓN:
                    <br>
                  <input class="frm-input4" type="text" name="calle" value="<?= $result3['calle']?>" id="direccion">
                  </label>
                </div>
                  </div>
                  </div>

                <div class="btns_atr_cont">
                
                <a href="empresa.php?pk=<?php echo $_GET['pk']?>" class="botones" value="Atras">
                <svg class="svg_atrs" width="34" height="34" viewBox="0 0 74 74" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="37" cy="37" r="35.5" stroke="black" stroke-width="3"></circle>
                <path d="M25 35.5C24.1716 35.5 23.5 36.1716 23.5 37C23.5 37.8284 24.1716 38.5 25 38.5V35.5ZM49.0607 38.0607C49.6464 37.4749 49.6464 36.5251 49.0607 35.9393L39.5147 26.3934C38.9289 25.8076 37.9792 25.8076 37.3934 26.3934C36.8076 26.9792 36.8076 27.9289 37.3934 28.5147L45.8787 37L37.3934 45.4853C36.8076 46.0711 36.8076 47.0208 37.3934 47.6066C37.9792 48.1924 38.9289 48.1924 39.5147 47.6066L49.0607 38.0607ZM25 38.5L48 38.5V35.5L25 35.5V38.5Z" fill="black"></path>
                </svg>
                <span>ATRÁS</span>
                </a>  

                <button class="botones" value="Continuar">
                <span>SIGUIENTE</span>
                <svg class="svg_cont" width="34" height="34" viewBox="0 0 74 74" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="37" cy="37" r="35.5" stroke="black" stroke-width="3"></circle>
                <path d="M25 35.5C24.1716 35.5 23.5 36.1716 23.5 37C23.5 37.8284 24.1716 38.5 25 38.5V35.5ZM49.0607 38.0607C49.6464 37.4749 49.6464 36.5251 49.0607 35.9393L39.5147 26.3934C38.9289 25.8076 37.9792 25.8076 37.3934 26.3934C36.8076 26.9792 36.8076 27.9289 37.3934 28.5147L45.8787 37L37.3934 45.4853C36.8076 46.0711 36.8076 47.0208 37.3934 47.6066C37.9792 48.1924 38.9289 48.1924 39.5147 47.6066L49.0607 38.0607ZM25 38.5L48 38.5V35.5L25 35.5V38.5Z" fill="black"></path>
                </svg>
                </button>  
                </div>
            </div>
        </form> 

    <script>
      function validarFormulario() {
        // Validar campos de texto
        var nombreCiudad = document.getElementById("ciudad").value;
        var direccion = document.getElementById("direccion").value;
        // Validar selects
        var pais = document.getElementById("fk_pais").value;
        var estado = document.getElementById("fk_estado").value;
        var municipio = document.getElementById("fk_municipio").value;
        //Validacion
        if (
            municipio === "" || nombreCiudad === "" || direccion === "" || 
            pais === "" || estado === ""
        ) {
            Swal.fire({
                position: 'top',
                icon: 'warning',
                text: 'Por favor, completa todos los campos.',
                timer: '2500'
            });
            return false;
        }
        return true;
    }

    document.getElementById('formulario-empresa').addEventListener('submit', function(event) {
      event.preventDefault(); // Evita el comportamiento por defecto del formulario
      document.getElementById('circulo-empresa').classList.add('circulo.llenado');
    });

    document.getElementById('formulario-ubicacion').addEventListener('submit', function(event) {
      event.preventDefault();
      document.getElementById('circulo-ubicacion').classList.add('circulo.llenado');
    });
    </script>
</section>
</body>

</html>