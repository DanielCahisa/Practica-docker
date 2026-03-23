<?php
// El servidor es el nombre del servicio en docker-compose
define('SERVIDOR', 'mariadb');

// Usuario de la base de datos de la aplicación
define('USUARIO', 'admin_asistencia');

// Contraseña segura de la aplicación
define('PASSWORD', 'SecurePass_Asist_2024!');

// Nombre de la base de datos
define('BASEDEDATOS', 'bd_control_asistencia');

$con = new mysqli(SERVIDOR, USUARIO, PASSWORD, BASEDEDATOS);
if($con->connect_error){
    die("Error crítico de conexión a la base de datos: " . $con->connect_error);
}
?>
