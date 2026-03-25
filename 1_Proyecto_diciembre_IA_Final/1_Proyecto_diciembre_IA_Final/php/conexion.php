<?php
define('SERVIDOR', 'mariadb');
define('USUARIO', 'admin_asistencia');
define('PASSWORD', 'SecurePass_Asist_2024!');
define('BASEDEDATOS', 'active360');

$con = new mysqli(SERVIDOR, USUARIO, PASSWORD, BASEDEDATOS);
if($con->connect_error){
    die("Error crítico de conexión a la base de datos: " . $con->connect_error);
}
?>
