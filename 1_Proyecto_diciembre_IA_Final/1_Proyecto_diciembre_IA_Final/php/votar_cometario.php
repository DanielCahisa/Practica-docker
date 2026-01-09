<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['id'])) {
    header('Location: area-client.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: comunidad.php');
    exit;
}

$idDelComentarioAVotar = (int)($_POST['id'] ?? 0);
$accionSolicitada      = $_POST['accion'] ?? '';

if ($idDelComentarioAVotar <= 0 || !in_array($accionSolicitada, ['up', 'down'], true)) {
    header('Location: comunidad.php');
    exit;
}

$idDelUsuarioQueVota = (int)$_SESSION['id'];
$valorDelNuevoVoto = ($accionSolicitada === 'up') ? 1 : -1;

$con->begin_transaction();

try {
    $ordenSQLParaVerificarSiYaVoto = "
        SELECT voto
        FROM votos_comentarios
        WHERE comentario_id = ? AND usuario_id = ?
        LIMIT 1
    ";
    
    $consultaParaVerificarVotoExistente = $con->prepare($ordenSQLParaVerificarSiYaVoto);
    $consultaParaVerificarVotoExistente->bind_param('ii', $idDelComentarioAVotar, $idDelUsuarioQueVota);
    $consultaParaVerificarVotoExistente->execute();
    $consultaParaVerificarVotoExistente->bind_result($valorDelVotoAnterior);
    
    $existeVotoPrevio = $consultaParaVerificarVotoExistente->fetch();
    $consultaParaVerificarVotoExistente->close();

    if ($existeVotoPrevio) {
        if ((int)$valorDelVotoAnterior === $valorDelNuevoVoto) {
            $ordenSQLParaBorrarVoto = "
                DELETE FROM votos_comentarios
                WHERE comentario_id = ? AND usuario_id = ?
            ";
            
            $consultaParaBorrarVoto = $con->prepare($ordenSQLParaBorrarVoto);
            $consultaParaBorrarVoto->bind_param('ii', $idDelComentarioAVotar, $idDelUsuarioQueVota);
            $consultaParaBorrarVoto->execute();
            $consultaParaBorrarVoto->close();

            $cantidadASumarOrestarAlTotal = -$valorDelVotoAnterior;
        } else {
            $ordenSQLParaActualizarVoto = "
                UPDATE votos_comentarios
                SET voto = ?
                WHERE comentario_id = ? AND usuario_id = ?
            ";
            
            $consultaParaActualizarVoto = $con->prepare($ordenSQLParaActualizarVoto);
            $consultaParaActualizarVoto->bind_param('iii', $valorDelNuevoVoto, $idDelComentarioAVotar, $idDelUsuarioQueVota);
            $consultaParaActualizarVoto->execute();
            $consultaParaActualizarVoto->close();

            $cantidadASumarOrestarAlTotal = $valorDelNuevoVoto - $valorDelVotoAnterior; 
        }
    } else {
        $ordenSQLParaInsertarVoto = "
            INSERT INTO votos_comentarios (comentario_id, usuario_id, voto)
            VALUES (?, ?, ?)
        ";
        
        $consultaParaInsertarVoto = $con->prepare($ordenSQLParaInsertarVoto);
        $consultaParaInsertarVoto->bind_param('iii', $idDelComentarioAVotar, $idDelUsuarioQueVota, $valorDelNuevoVoto);
        $consultaParaInsertarVoto->execute();
        $consultaParaInsertarVoto->close();

        $cantidadASumarOrestarAlTotal = $valorDelNuevoVoto;
    }

    $ordenSQLParaActualizarContadorTotal = "
        UPDATE comentarios
        SET votos = votos + ?
        WHERE id = ?
    ";
    
    $consultaParaActualizarContadorTotal = $con->prepare($ordenSQLParaActualizarContadorTotal);
    $consultaParaActualizarContadorTotal->bind_param('ii', $cantidadASumarOrestarAlTotal, $idDelComentarioAVotar);
    $consultaParaActualizarContadorTotal->execute();
    $consultaParaActualizarContadorTotal->close();

    $con->commit();
} catch (Exception $e) {
    $con->rollback();
}

$destinoDeRedireccion = $_SERVER['HTTP_REFERER'] ?? 'comunidad.php';
header("Location: $destinoDeRedireccion");
exit;