<?php
session_start();
require_once('conexion.php');

$listaDeCorreosAutorizados = ['daniel.cahisa@laginesta.com', 'david@active360.com'];
$elUsuarioEsAdministrador = false;

if (isset($_SESSION['id'])) {
    $consultaParaVerificarPermisos = $con->prepare("SELECT correo FROM usuarios WHERE id = ?");
    $consultaParaVerificarPermisos->bind_param("i", $_SESSION['id']);
    $consultaParaVerificarPermisos->execute();
    
    $resultadoVerificacion = $consultaParaVerificarPermisos->get_result();
    
    if ($datosDelUsuarioActual = $resultadoVerificacion->fetch_assoc()) {
        if (in_array($datosDelUsuarioActual['correo'], $listaDeCorreosAutorizados)) {
            $elUsuarioEsAdministrador = true;
        }
    }
    $consultaParaVerificarPermisos->close();
}

if (!$elUsuarioEsAdministrador) {
    header("Location: index.php");
    exit;
}

if (isset($_GET['id'])) {
    $idDelUsuarioAEliminar = $_GET['id'];
    
    $ordenSQLParaBorrarUsuario = "DELETE FROM usuarios WHERE id = ?";
    
    $consultaParaBorrar = $con->prepare($ordenSQLParaBorrarUsuario);
    $consultaParaBorrar->bind_param("i", $idDelUsuarioAEliminar);
    $consultaParaBorrar->execute();
    $consultaParaBorrar->close();
}

$con->close();
header('Location: admin_usuarios.php');
?>