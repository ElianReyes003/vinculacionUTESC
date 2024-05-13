<?php
session_start();
if(!isset($_SESSION["pk_usuario"])){
  header("location: login.php");
}

    include ('conexion/conexion.php');

    $bd = new Conexion;
    $conn = $bd->conectar();
    $pk = $_GET['pk'];

    $query = $conn->prepare('SELECT * FROM contacto WHERE fk_empresa = :pk_empresa');
    $query->bindParam(':pk_empresa', $pk, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch();    

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
    <link rel="stylesheet" href="css/detalle-empresa.css?=1">
    <title>Editar convenio - Contacto</title>
</head>
<?php include('header.php'); ?>  

<section>
        <form method="POST"  action="editar/editar_con.php" onsubmit="return validarFormulario();">
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
                <h6 class="text_secciones">Detalle De La Ubicación</h6>

                <form id="formulario-contacto">
                <div>
                <div href="detalle_contacto.php" id="circulo-contacto"></div>
                <img class="img_flechas" src="imag/Flecha.png" alt="">
                </div>
                </form>
                <h6 style="color: #008080; font-weight:bold;" class="text_secciones">Detalle Del Contacto</h6>
                </div>
                <hr>

                <h3>Detalle Del Contacto</h3>
                <br>

                <div class="contain">
                  <div class="subcontainer">
                  <div>
                  <label class="frm-label">NOMBRE DEL CONTACTO:
                    <br>
                  <input class="frm-input" type="text" id="nombre_contacto" name="nombre_contacto" value="<?= $result['nombre_contacto'];?>">
                  </label>
                </div>

                <div>
                  <label class="frm-label1">CORREO ELECTRÓNICO:
                    <br>
                  <input type="text" name="correo" id="correo_contacto" class="frm-input1" value="<?= $result['correo'];?>">
                  </label>
                </div>

                <div>
                  <label class="frm-label2">NUMERO DE TELÉFONO:
                    <br>
                  <input class="frm-input2" type="text" id="telefono_contacto" name="telefono" value="<?= $result['telefono'];?>">
                  </label>
                </div>
                <div>
                  <label class="frm-label3">CARGO O PUESTO:
                    <br>
                  <input class="frm-input3" type="text" id="cargo" name="cargo" value="<?= $result['cargo']?>">
                </div>
                  </div>
                  </div>

                <div class="btns_atr_cont">
                <a href="ubicacion.php?pk=<?php echo $_GET['pk']?>" class="botones" value="Atras">
                <svg class="svg_atrs" width="34" height="34" viewBox="0 0 74 74" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="37" cy="37" r="35.5" stroke="black" stroke-width="3"></circle>
                <path d="M25 35.5C24.1716 35.5 23.5 36.1716 23.5 37C23.5 37.8284 24.1716 38.5 25 38.5V35.5ZM49.0607 38.0607C49.6464 37.4749 49.6464 36.5251 49.0607 35.9393L39.5147 26.3934C38.9289 25.8076 37.9792 25.8076 37.3934 26.3934C36.8076 26.9792 36.8076 27.9289 37.3934 28.5147L45.8787 37L37.3934 45.4853C36.8076 46.0711 36.8076 47.0208 37.3934 47.6066C37.9792 48.1924 38.9289 48.1924 39.5147 47.6066L49.0607 38.0607ZM25 38.5L48 38.5V35.5L25 35.5V38.5Z" fill="black"></path>
                </svg>
                <span>ATRÁS</span>
                </a>   

                <button class="botones" value="Continuar">
                <span>GUARDAR CAMBIOS</span>
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
        var nombreContacto = document.getElementById("nombre_contacto").value;
        var correoContacto = document.getElementById("correo_contacto").value;
        var telefonoContacto = document.getElementById("telefono_contacto").value;
        var cargo = document.getElementById("cargo").value;

        //Validacion
        if (
            nombreContacto === "" || correoContacto === "" || telefonoContacto === "" || cargo === "" 
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