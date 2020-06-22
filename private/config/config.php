<?php 
/**
 * Importamos la clase principal de conexion, donce se hace la configuracion de base de datos con 
 * proyecto
 */
include('../../Conexion/DB.php');
$conexion = new DB('localhost','root','','db_app_biblioteca');
?>