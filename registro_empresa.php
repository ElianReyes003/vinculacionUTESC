<?php
session_start();
if(!isset($_SESSION["pk_usuario"])){
  header("location: login.php");
}

    include ('conexion/conexion.php');

    $bd = new Conexion;
    $conn = $bd->conectar();

    $query = $conn -> prepare('SELECT * FROM modal ');
    $query->execute();
    $result = $query->fetchAll();

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
<html lang="es">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/detalle-empresa.css?=1">
    <script src="jquery-3.5.1.min.js"></script>
    <title>Registro de Convenio</title>
</head>

<?php include('header.php'); ?>

<section>
    <form method="POST" action="inser/inser_datos.php" enctype="multipart/form-data" onsubmit="return validarFormulario();">
        <div class="info-box">

            <h2>Registrar nuevo convenio</h2>
            <hr>
            <h3>Detalle De La Empresa</h3>

            <div class="contain">
                <div class="subcontainer">
                    <div>
                        <label>NOMBRE DE LA EMPRESA:
                            <br>
                            <input type="text" name="nombre_empresa" id="nombre_empresa">
                        </label>
                    </div>

                    <div>
                        <label>IMAGEN DE LA EMPRESA:
                            <br>
                            <input type="file" name="foto" id="foto">
                        </label>
                    </div>

                    <div>
                        <label>DESCRIPCIÓN:
                            <br>
                            <input type="text" name="descripcion" id="descripcion">
                        </label>
                    </div>

                    <div>
                        <label>CANTIDAD DE EMPLEADOS:
                            <br>
                            <input type="number" name="cantidad_empleados" type="number" id="cantidad_empleados" >
                        </label>
                    </div>

                    <div>
                        <label>MODALIDAD:
                            <br>
                            <select name="fk_modal" id="fk_modal">
                                <option value="" selected>Seleccionar</option>
                                <?php
                                foreach ($result as $opciones):
                                ?>
                                    <option value="<?php echo $opciones['pk_modal']?>">
                                        <?php echo $opciones['nombre_modal']?>
                                    </option>
                                <?php endforeach?>
                            </select>
                        </label>
                    </div>

                    <div>
                       APOYO:
                            <br>
                            <ul class="checklist" name="fk_apoyo" id="fk_apoyo">
                                <?php
                                foreach ($result2 as $opciones2):
                                ?>
                                    <li>
                                        <input name="nombre_apoyo[]" type="checkbox" value="<?php echo $opciones2['pk_apoyo']?>">
                                        <label><?= $opciones2['nombre_apoyo']?></label>
                                    </li>
                                <?php endforeach?>
                            </ul>
                    </div>

                    <div>
                        <label>RFC:
                            <br>
                            <input type="text" name="rfc" id="rfc">
                        </label>
                    </div>

                    <div class="marg">
                        <label>INICIO DE CONVENIO:
                            <br>
                            <input type="date" name="inicio_convenio" id="inicio_convenio">
                        </label>
                    </div>

                    <div>
                        <label>FIN DE CONVENIO:
                            <br>
                            <input type="date" name="final_convenio" id="final_convenio">
                        </label>
                    </div>
                </div>

                <div class="cont_carrera">
                    CARERRA COMPATIBLE:
                    <ul class="checklist" name="fk_carrera" id="fk_carrera">
                        <?php foreach ($result3 as $opciones3): ?>
                            <li>
                                <input name="nombre_carrera[]" type="checkbox" value="<?php echo $opciones3['pk_carrera']?>">
                                <label><?= $opciones3['nombre_carrera']?></label>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>

            <hr>
            
            <h3>Detalle De La Ubicación</h3>
            
            <div class="contain">
                <div class="subcontainer">

                    <div>
                        <label>PAÍS:
                            <br>
                            <select onchange="zona(); cargarEstados();" name="fk_pais" id="fk_pais">
                                <option value="" selected>Seleccionar</option>
                                <?php
                                foreach ($result5 as $opciones5):
                                ?>
                                    <option value="<?php echo $opciones5['pk_pais']?>">
                                        <?php echo $opciones5['nombre_pais']?>
                                    </option>
                                <?php endforeach?>
                            </select>
                        </label>
                    </div>

                    <div>
                        <label>ESTADO:
                            <br>
                            <select onchange="zona(); cargarMunicipios();" name="fk_estado" id="fk_estado">
                                <option value="" selected>Seleccionar</option>
                                <?php
                                foreach ($result6 as $opciones6):
                                ?>
                                    <option value="<?php echo $opciones6['pk_estado']?>">
                                        <?php echo $opciones6['nombre_estado']?>
                                    </option>
                                <?php endforeach?>
                            </select>
                        </label>
                    </div>

                    <div>
                        <label>MUNICIPIO:
                            <br>
                            <select onchange="zona()" name="fk_municipio" id="fk_municipio">
                                <option value="" selected>Seleccionar</option>
                                <?php
                                foreach ($result7 as $opciones7):
                                ?>
                                    <option value="<?php echo $opciones7['pk_municipio']?>">
                                        <?php echo $opciones7['nombre_municipio']?>
                                    </option>
                                <?php endforeach?>
                            </select>
                        </label>
                    </div>

                    <div>
                        <label>CIUDAD:
                            <br>
                            <input type="text" name="nombre_ciudad" id="ciudad">
                        </label>
                    </div>

                    <div>
                        <label>DIRECCIÓN:
                            <br>
                        <input type="text" name="calle" id="direccion">
                        </label>
                    </div>

                    <div>
                        <label>ZONA:
                          <br>
                        <select name="fk_zona" id="fk_zona">
                        <option value="" selected>Seleccionar</option>
                        <?php 
                            foreach ($result4 as $opciones4):
                        ?>
                        <option value="<?php echo $opciones4['pk_zona']?>">
                        <?php echo $opciones4['influencia']?></option>
                        <?php endforeach?>
                        </select>
                        </label>
                    </div>

                </div>
            </div>

            <hr>
            
            <h3>Detalle Del Contacto</h3>

            <div class="contain">
                <div class="subcontainer">
                    <div>
                        <label>NOMBRE DEL CONTACTO:
                            <br>
                            <input type="text" name="nombre_contacto" id="nombre_contacto">
                        </label>
                    </div>

                    <div>
                        <label>CORREO DEL CONTACTO:
                            <br>
                            <input type="email" name="correo_contacto" id="correo_contacto">
                        </label>
                    </div>

                    <div>
                        <label>TELÉFONO DEL CONTACTO:
                            <br>
                            <input type="tel" name="telefono_contacto" id="telefono_contacto">
                        </label>
                    </div>

                    <div>
                        <label>CARGO O PUESTO:
                          <br>
                        <input type="text" name="cargo" id="cargo">
                    </div>

                </div>
            </div>
            <div class="btns_atr_cont">
                <button class="botones" value="Continuar">
                    <span>GUARDAR</span>
                        <svg class="svg_cont" width="34" height="34" viewBox="0 0 74 74" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="37" cy="37" r="35.5" stroke="black" stroke-width="3"></circle>
                        <path d="M25 35.5C24.1716 35.5 23.5 36.1716 23.5 37C23.5 37.8284 24.1716 38.5 25 38.5V35.5ZM49.0607 38.0607C49.6464 37.4749 49.6464 36.5251 49.0607 35.9393L39.5147 26.3934C38.9289 25.8076 37.9792 25.8076 37.3934 26.3934C36.8076 26.9792 36.8076 27.9289 37.3934 28.5147L45.8787 37L37.3934 45.4853C36.8076 46.0711 36.8076 47.0208 37.3934 47.6066C37.9792 48.1924 38.9289 48.1924 39.5147 47.6066L49.0607 38.0607ZM25 38.5L48 38.5V35.5L25 35.5V38.5Z" fill="black"></path>
                    </svg>
                </button>  
            </div>
        </div>
    </form>
</section>
<script>
    function validarFormulario() {
        // Validar campos de texto
        var nombreEmpresa = document.getElementById("nombre_empresa").value;
        var descripcion = document.getElementById("descripcion").value;
        var cantidadEmpleados = document.getElementById("cantidad_empleados").value;
        var rfc = document.getElementById("rfc").value;
        var inicioConvenio = document.getElementById("inicio_convenio").value;
        var finalConvenio = document.getElementById("final_convenio").value;
        var nombreCiudad = document.getElementById("ciudad").value;
        var direccion = document.getElementById("direccion").value;
        var nombreContacto = document.getElementById("nombre_contacto").value;
        var correoContacto = document.getElementById("correo_contacto").value;
        var telefonoContacto = document.getElementById("telefono_contacto").value;
        var cargo = document.getElementById("cargo").value;
        // Validar selects
        var modalidad = document.getElementById("fk_modal").value;
        var pais = document.getElementById("fk_pais").value;
        var estado = document.getElementById("fk_estado").value;
        var municipio = document.getElementById("fk_municipio").value;
        var zona = document.getElementById("fk_zona").value;
        // Validar listas
        var apoyo = document.querySelectorAll('input[name="nombre_apoyo[]"]:checked').length;
        var carreras = document.querySelectorAll('input[name="nombre_carrera[]"]:checked').length;
        //Validacion
        if (
            nombreEmpresa === "" || descripcion === "" || cantidadEmpleados === "" ||
            modalidad === "" || pais === "" || estado === "" || rfc === "" || municipio === "" || zona === "" ||
            inicioConvenio === "" || finalConvenio === "" || nombreCiudad === "" || direccion === "" ||
            nombreContacto === "" || correoContacto === "" || telefonoContacto === "" || cargo === "" ||
            apoyo === 0 || carreras === 0
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

   function zona() {
    var pais = $("#fk_pais").val();
    var estado = $("#fk_estado").val();
    var municipio = $("#fk_municipio").val();
    var zonaSelect = $("#fk_zona");

    zonaSelect.find("option:selected").prop("selected", false);

    if (pais == "42") {
        if (estado == "25") {
            zonaSelect.val("2");
        } else {
            zonaSelect.val("3");
        }
    } else {
        zonaSelect.val("4");
    }
    if (municipio == "25009" || municipio == "25014" || municipio == "25012" || municipio == "18001") {
        zonaSelect.val("1");
    }
    }

    //estados y municipios
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
</script>
</body>
</html>
