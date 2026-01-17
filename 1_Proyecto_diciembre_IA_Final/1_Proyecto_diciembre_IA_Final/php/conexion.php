<?php
// El servidor es el nombre del servicio en docker-compose
define('SERVIDOR', 'mariadb');

// El usuario que definiste en MYSQL_USER
define('USUARIO', 'my_user');

// La contraseña que definiste en MYSQL_PASSWORD
define('PASSWORD', 'my_password');

// La base de datos que definiste en MYSQL_DATABASE
define('BASEDEDATOS', 'simple_attendance_db');

$con = new mysqli(SERVIDOR, USUARIO, PASSWORD, BASEDEDATOS);
if($con->connect_error){
    die("Conexión fallida: " . $con->connect_error);
}
?>
