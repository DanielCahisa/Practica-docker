<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: area-client.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: comunidad.php");
    exit;
}

$idDeLaPublicacionAVotar = (int)($_POST['id'] ?? 0);
$accionSolicitada = $_POST['accion'] ?? '';

if ($idDeLaPublicacionAVotar <= 0 || !in_array($accionSolicitada, ['up', 'down'])) {
    header("Location: comunidad.php");
    exit;
}

$idDelUsuarioQueVota = (int)$_SESSION['id'];
$valorDelNuevoVoto = ($accionSolicitada === 'up') ? 1 : -1;

$con->begin_transaction();

$ordenSQLParaVerificarSiYaVoto = "SELECT voto FROM votos_publicaciones WHERE publicacion_id = ? AND usuario_id = ?";
$consultaParaVerificarVotoExistente = $con->prepare($ordenSQLParaVerificarSiYaVoto);
$consultaParaVerificarVotoExistente->bind_param("ii", $idDeLaPublicacionAVotar, $idDelUsuarioQueVota);
$consultaParaVerificarVotoExistente->execute();
$consultaParaVerificarVotoExistente->bind_result($valorDelVotoAnterior);

$existeVotoPrevio = $consultaParaVerificarVotoExistente->fetch();
$consultaParaVerificarVotoExistente->close();

if ($existeVotoPrevio) {
    if ($valorDelVotoAnterior == $valorDelNuevoVoto) {
        $ordenSQLParaBorrarVoto = "DELETE FROM votos_publicaciones WHERE publicacion_id = ? AND usuario_id = ?";
        $consultaParaBorrarVoto = $con->prepare($ordenSQLParaBorrarVoto);
        $consultaParaBorrarVoto->bind_param("ii", $idDeLaPublicacionAVotar, $idDelUsuarioQueVota);
        $consultaParaBorrarVoto->execute();
        $consultaParaBorrarVoto->close();
        
        $cantidadASumarOrestarAlTotal = -$valorDelVotoAnterior;
    } else {
        $ordenSQLParaActualizarVoto = "UPDATE votos_publicaciones SET voto = ? WHERE publicacion_id = ? AND usuario_id = ?";
        $consultaParaActualizarVoto = $con->prepare($ordenSQLParaActualizarVoto);
        $consultaParaActualizarVoto->bind_param("iii", $valorDelNuevoVoto, $idDeLaPublicacionAVotar, $idDelUsuarioQueVota);
        $consultaParaActualizarVoto->execute();
        $consultaParaActualizarVoto->close();
        
        $cantidadASumarOrestarAlTotal = $valorDelNuevoVoto - $valorDelVotoAnterior;
    }
} else {
    $ordenSQLParaInsertarVoto = "INSERT INTO votos_publicaciones (publicacion_id, usuario_id, voto) VALUES (?, ?, ?)";
    $consultaParaInsertarVoto = $con->prepare($ordenSQLParaInsertarVoto);
    $consultaParaInsertarVoto->bind_param("iii", $idDeLaPublicacionAVotar, $idDelUsuarioQueVota, $valorDelNuevoVoto);
    $consultaParaInsertarVoto->execute();
    $consultaParaInsertarVoto->close();
    
    $cantidadASumarOrestarAlTotal = $valorDelNuevoVoto;
}

$ordenSQLParaActualizarContadorTotal = "UPDATE publicaciones SET votos = votos + ? WHERE id = ?";
$consultaParaActualizarContadorTotal = $con->prepare($ordenSQLParaActualizarContadorTotal);
$consultaParaActualizarContadorTotal->bind_param("ii", $cantidadASumarOrestarAlTotal, $idDeLaPublicacionAVotar);
$consultaParaActualizarContadorTotal->execute();
$consultaParaActualizarContadorTotal->close();

$con->commit();

header("Location: ".$_SERVER["HTTP_REFERER"]);
exit;
?>