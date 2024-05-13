 <!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/menu.css?=1">
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <meta name="google-signin-client_id" content="195230904845-41ka1uqvf8a5bgl02ai0sigcbasephcj.apps.googleusercontent.com">
</head>
<body>
  <header>
    <div class="opcns">
      <a href="convenio.php" id="link-inicio"><img src="imag/utesc.png" alt="Logo de la UTESC"></a>
      <a href="convenio.php" id="link-convenio">Inicio</a>
      <a href="categorias.php" id="link-categorias">Lista de convenios</a>
      <a href="registro_empresa.php" id="link-registro">Registrar convenio</a>
      <a href="conveniosbaja.php" id="link-bajas">Convenios dados de baja</a>
    </div>
    <a href="cerrar_sesion.php">
    <button class="Btn_cerrar">
    <div class="sign"><svg viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg></div>
    <div class="text_btn">Cerrar&nbspsesión</div>
    </button>
    </a>
  </header>

  <script>
document.addEventListener("DOMContentLoaded", function() {
  var currentPage = window.location.pathname;

  if (currentPage.includes("convenio.php")) {
    document.getElementById("link-convenio").classList.add("active");
  } else if (currentPage.includes("categorias.php")) {
    document.getElementById("link-categorias").classList.add("active");
  } else if (currentPage.includes("registro_empresa.php")) {
    document.getElementById("link-registro").classList.add("active");
  } else if (currentPage.includes("conveniosbaja.php")) {
    document.getElementById("link-bajas").classList.add("active");
  }
});
</script>

</body>
</html>