<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['id'])) {
    header('Location: Login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tituloDeLaNuevaPublicacion    = trim($_POST['titulo'] ?? '');
    $contenidoDeLaNuevaPublicacion = trim($_POST['contenido'] ?? '');
    $idDelUsuarioQuePublica        = (int) $_SESSION['id'];

    if ($tituloDeLaNuevaPublicacion !== '' && $contenidoDeLaNuevaPublicacion !== '') {
        $consultaParaInsertarLaPublicacion = $con->prepare("
            INSERT INTO publicaciones (titulo, contenido, usuario_id)
            VALUES (?, ?, ?)
        ");
        $consultaParaInsertarLaPublicacion->bind_param("ssi", $tituloDeLaNuevaPublicacion, $contenidoDeLaNuevaPublicacion, $idDelUsuarioQuePublica);

        if ($consultaParaInsertarLaPublicacion->execute()) {
            $consultaParaInsertarLaPublicacion->close();
            header('Location: comunidad.php');
            exit;
        } else {
            echo "Error al guardar la publicació.";
        }
    } else {
        echo "Cal omplir tots els camps.";
    }
}