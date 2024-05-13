<?php
require 'vendor/autoload.php';
include ('conexion/conexion.php');
// Crear una instancia de la clase Conexion
$conexion = new Conexion();

// Llamar al método conectar en la instancia
$conn = $conexion->conectar();

$pk_empresa = $_GET['pk']; 
$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('convenio-estadía-nuevo.docx');

$sql = $conn->prepare("SELECT 
e.nombre_estado AS 'Nombre del estado', 
p.nombre_pais AS 'Nombre del país', 
emp.nombre_empresa AS 'Nombre de la empresa',
emp.rfc AS 'RFC',
contacto.nombre_contacto AS 'Nombre del contacto',
contacto.cargo AS 'Cargo del contacto',
c.nombre_ciudad AS 'Nombre de la ciudad',
c.calle AS 'Calle'
FROM ciudad c
INNER JOIN estado e ON e.pk_estado = c.fk_estado
INNER JOIN pais p ON p.pk_pais = c.fk_pais 
INNER JOIN empresa emp ON emp.pk_empresa = c.fk_empresa
INNER JOIN contacto ON emp.pk_empresa=contacto.fk_empresa

WHERE emp.pk_empresa=? LIMIT 1;");

$sql->execute([$pk_empresa]);
$filas = $sql->fetch(PDO::FETCH_ASSOC);

$templateProcessor->setValue('nombre_estado', $filas['Nombre del estado']);
$templateProcessor->setValue('nombre_pais', $filas['Nombre del país']);
$templateProcessor->setValue('nombre_ciudad', $filas['Nombre de la ciudad']);
$templateProcessor->setValue('nombre_empresa', $filas['Nombre de la empresa']);
$templateProcessor->setValue('rfc', $filas['RFC']);
$templateProcessor->setValue('nombre_contacto', $filas['Nombre del contacto']);
$templateProcessor->setValue('cargo', $filas['Cargo del contacto']);
$templateProcessor->setValue('calle', $filas['Calle']);

$templateProcessor->saveAs('CONVENIO GENÉRICO ESTADÍA.docx');
header('Content-Disposition: attachment; filename=CONVENIO GENÉRICO ESTADÍA.docx; charset=iso-8859-1; charset=utf-8');
echo file_get_contents('CONVENIO GENÉRICO ESTADÍA.docx');

exit;
?>