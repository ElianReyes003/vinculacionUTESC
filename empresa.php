<?php

include ('conexion/conexion.php');

$bd = new Conexion;
$conn = $bd->conectar();
$pk = $_GET['pk'];


$query = $conn -> prepare('SELECT * FROM modal ');
$query->execute();
$result = $query->fetchALl();

$query4 = $conn -> prepare('SELECT * FROM empresa em INNER JOIN ciudad ci ON em.pk_empresa = ci.fk_empresa
INNER JOIN estado et ON et.pk_estado = ci.fk_estado INNER JOIN convenio c ON em.pk_empresa = c.fk_empresa 
INNER JOIN zona z ON z.pk_zona = ci.fk_zona INNER JOIN contacto con ON em.pk_empresa = con.fk_empresa 
INNER JOIN pais p ON p.pk_pais = ci.fk_pais INNER JOIN modal md ON md.pk_modal = em.fk_modal
WHERE em.pk_empresa = '.$pk);
$query4->execute();
$result4 = $query4->fetch();

$query2 = $conn -> prepare('SELECT * FROM carrera ');
$query2 ->execute();
$result2 = $query2->fetchALl();


$query3 = $conn -> prepare('SELECT * FROM apoyo ');
$query3 ->execute();
$result3 = $query3->fetchALl();

$query5 = $conn -> prepare('SELECT * FROM empresa_carrera amc 
INNER JOIN carrera ca ON ca.pk_carrera = amc.fk_carrera
WHERE amc.fk_empresa ='.$pk);
$query5->execute();
$result5= $query5->fetchAll();
// print_r( $result5 );
$bbb = array_column($result5, 'pk_carrera');
// print_r( $bbb );

$query6 = $conn -> prepare(' SELECT * FROM apoyo_emp ap INNER JOIN apoyo p ON
p.pk_apoyo = ap.fk_apoyo WHERE fk_empresa = '.$pk);
    $query6->execute();
    $result6 = $query6->fetchAll();

    
    $aaa = array_column($result6, 'pk_apoyo');

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
    <title>Editar convenio - Empresa</title>
</head>
<?php include('header.php'); ?>  

<section>
        <form method="POST"  action="editar/edit_em.php" enctype="multipart/form-data" onsubmit="return validarFormulario();">
            <div class="info-box">

                <h2>Editar convenio - <?= $result4['nombre_empresa']?></h2>
                <input type="hidden" value="<?= $pk?>" name="pk">
                <hr>
                
                <div class="secciones">
                <form id="formulario-empresa">
                <div>
                <div href="registro_empresa.php"></div>
                <img class="img_flechas" src="imag/Flecha.png" alt="">
                </div>
                </form>
                <h6 style="color: #008080; font-weight:bold;" class="text_secciones">Detalle De La Empresa</h6>

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
                <h6 class="text_secciones">Detalle Del Contacto</h6>
                </div>
                <hr>

                <h3>Detalle De La Empresa</h3>
                <br>

                <div class="contain">
                  <div class="subcontainer">
                  <div>
                    <label>NOMBRE DE LA EMPRESA:
                      <br>
                      <input type="text" name="nombre_empresa" id="nombre_empresa" value="<?= $result4['nombre_empresa']?>">
                    </label>
                  </div>

                  <div>
                    <label>IMAGEN DE LA EMPRESA:
                      <br>
                      <input type="file" name="foto" class="form_input1" value="<?= $result4['foto']?>">
                    </label>
                  </div>

                  <div>
                    <label>DESCRIPCIÓN:
                      <br>
                      <input type="text" name="descripcion" id="descripcion" value="<?= $result4['descripcion']?>">
                    </label>
                  </div>

                  <div>
                    <label>CANTIDAD DE EMPLEADOS:
                      <br>
                      <input class="frm-input3" type="text" name="cantidad_empleados" type="number" id="cantidad_empleados" value="<?= $result4['cantidad_empleados']?>">
                  </div> 

                  <div>
                    MODALIDAD:
                      <br>
                      <select name="fk_modal" id="fk_modal">
                        <option value="<?= $result4['fk_modal']?>"><?= $result4['nombre_modal']?></option>
                        <?php 
                        foreach ($result as $opciones):
                        ?>
                        <option value="<?php echo $opciones['pk_modal']?>">
                        <?php echo $opciones['nombre_modal']?></option>
                        <?php endforeach?>
                    </select>
                  </div>

                  <div>
                    APOYO:
                      <br>
                      <ul class="checklist" name="fk_apoyo" id="fk_apoyo">
                        <?php 
                        foreach ($result3 as $opciones2):
                        ?>
                        <li>
                          <input name="nombre_apoyo[]" type="checkbox" id="item1" value="<?= $opciones2['pk_apoyo']?>" <?php if( in_array( $opciones2['pk_apoyo'], $aaa) ){ echo "checked";} ?> >
                          <label><?= $opciones2['nombre_apoyo']?></label>
                        </li>
                        <?php endforeach?>
                      </ul>
                  </div>

                  <div>
                    <label>RFC:
                      <br>
                      <input type="text" name="rfc" id="rfc" value="<?= $result4['rfc']?>">
                    </label>
                  </div>

                  <div>
                    <label>INICIO DE CONVENIO:
                      <br>
                      <input type="date" name="inicio_convenio" id="inicio_convenio" value="<?= $result4['inicio_convenio'];?>">
                    </label>
                  </div>

                  <div>
                    <label>FIN DE CONVENIO:
                      <br>
                      <input type="date" name="final_convenio" id="final_convenio" value="<?= $result4['final_convenio'];?>">
                    </label>
                  </div>

              </div>        
                      <div class="cont_carrera">
                        CARERRA COMPATIBLE:
                          <br>
                          <ul class="checklist" name="fk_carrera" id="fk_carrera">
                            <?php 
                            foreach ($result2 as $opciones3):
                            ?>
                            <li>
                              <input name="nombre_carrera[]" type="checkbox" id="item3" value="<?= $opciones3['pk_carrera']?>"  <?php if( in_array( $opciones3['pk_carrera'], $bbb) ){ echo "checked";} ?>>
                              <label for=""><?= $opciones3['nombre_carrera']?></label>
                            </li>
                            <?php endforeach?>
                          </ul>
                      </div>
                      
                </div>

                <div class="btns_atr_cont">
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
        var nombreEmpresa = document.getElementById("nombre_empresa").value;
        var descripcion = document.getElementById("descripcion").value;
        var cantidadEmpleados = document.getElementById("cantidad_empleados").value;
        var rfc = document.getElementById("rfc").value;
        var inicioConvenio = document.getElementById("inicio_convenio").value;
        var finalConvenio = document.getElementById("final_convenio").value;
        // Validar listas
        var apoyo = document.querySelectorAll('input[name="nombre_apoyo[]"]:checked').length;
        var carreras = document.querySelectorAll('input[name="nombre_carrera[]"]:checked').length;
        //Validacion
        if (
            nombreEmpresa === "" || descripcion === "" || cantidadEmpleados === "" || rfc === "" ||
            inicioConvenio === "" || finalConvenio === "" || apoyo === 0 || carreras === 0
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
    </script>
</section>

</body>

</html>