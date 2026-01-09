<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['id'])) {
    header('Location: Login.php');
    exit;
}

$errores = [];
$titulo = '';
$contenido = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo    = trim($_POST['titulo'] ?? '');
    $contenido = trim($_POST['contenido'] ?? '');
    $usuarioId = (int)$_SESSION['id'];

    if ($titulo === '') {
        $errores[] = "El títol és obligatori.";
    }
    if ($contenido === '') {
        $errores[] = "El contingut és obligatori.";
    }

    if (empty($errores)) {
        $insertarNuevaPublicacion = $con->prepare("
            INSERT INTO publicaciones (titulo, contenido, usuario_id)
            VALUES (?, ?, ?)
        ");
        $insertarNuevaPublicacion->bind_param("ssi", $titulo, $contenido, $usuarioId);

        if ($insertarNuevaPublicacion->execute()) {
            $idDeLaPublicacionRecienCreada = $insertarNuevaPublicacion->insert_id;
            
            $insertarNuevaPublicacion->close();
            
            header('Location: publicacion.php?id=' . $idDeLaPublicacionRecienCreada);
            exit;
        } else {
            $errores[] = "Error en desar la publicació.";
            $insertarNuevaPublicacion->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Crea una nova publicació - Active360</title>
    <link rel="stylesheet" href="../css/comunidad.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
    
    <header>
       <?php require_once 'cabezera.php'; ?>
    </header>

<main class="comunidad-main">
    <div class="comunidad-container">
        <section class="post-feed">
            <h1>Crea una nova publicació</h1>

            <?php if (!empty($errores)): ?>
                <div class="alerta">
                    <?php foreach ($errores as $e): ?>
                        <div><?= htmlspecialchars($e) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="crear_publicacion.php" method="post" class="create-post-form">
                <div class="form-group">
                    <label for="titulo">Títol</label>
                    <input type="text" id="titulo" name="titulo" required
                           value="<?= htmlspecialchars($titulo) ?>">
                </div>

                <div class="form-group">
                    <label for="contenido">Contingut</label>
                    <textarea id="contenido" name="contenido" rows="6" required><?= htmlspecialchars($contenido) ?></textarea>
                </div>

                <button type="submit" class="btn-create-post">Publicar</button>
            </form>
        </section>

        <aside class="sidebar-comunidad">
            <div class="rules-box">
                <h3>Normes de la Comunitat</h3>
                <p>1. Sigues respectuós amb els altres.</p>
                <p>2. No spam ni autopromoció excessiva.</p>
                <p>3. Publica a la subcomunitat correcta.</p>
            </div>
        </aside>
    </div>
</main>
</body>
</html>