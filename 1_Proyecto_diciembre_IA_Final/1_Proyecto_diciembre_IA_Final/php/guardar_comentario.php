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

$idDeLaPublicacionDondeComenta = (int)$_POST['publicacion_id'];
$textoDelComentarioEscrito = trim($_POST['comentario']);
$idDelComentarioPadre = isset($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;
$idDelUsuarioQueComenta = (int)$_SESSION['id'];

if ($textoDelComentarioEscrito === '' || $idDeLaPublicacionDondeComenta <= 0) {
    header("Location: publicacion.php?id=$idDeLaPublicacionDondeComenta");
    exit;
}

$consultaParaGuardarElComentario = $con->prepare("
    INSERT INTO comentarios (contenido, usuario_id, publicacion_id, parent_id)
    VALUES (?, ?, ?, ?)
");

$consultaParaGuardarElComentario->bind_param("siis", $textoDelComentarioEscrito, $idDelUsuarioQueComenta, $idDeLaPublicacionDondeComenta, $idDelComentarioPadre);
$consultaParaGuardarElComentario->execute();
$consultaParaGuardarElComentario->close();

header("Location: publicacion.php?id=$idDeLaPublicacionDondeComenta");
exit;