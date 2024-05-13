<?php

class Conexion{
  public function conectar(){

  $host='localhost';
  $user='root';
  $password='';
  $dbname='convenio';
  $conexion = new PDO("mysql:host=$host;dbname=$dbname", $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES "UTF8"'));
  $conexion -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
return $conexion;
}
}
?>