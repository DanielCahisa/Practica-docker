<?php
define('SERVIDOR','localhost');
define('USUARIO','root');
define('PASSWORD','');
define('BASEDEDATOS','active360');

$con=new mysqli(SERVIDOR,USUARIO,PASSWORD,BASEDEDATOS);
if($con->connect_error){
    die("Conexión fallida:". $con->connect_error);
}
?>