<?php 
session_start();
require_once 'conexion.php';

$idDeLaPublicacionSolicitada = (int)($_GET['id'] ?? 0);
if ($idDeLaPublicacionSolicitada <= 0) {
    header('Location: comunidad.php');
    exit;
}

$ordenSQLParaBuscarLaPublicacion = "
    SELECT p.id, p.titulo, p.contenido, p.votos, p.creado_en,
           u.nombre AS autor
    FROM publicaciones p
    JOIN usuarios u ON p.usuario_id = u.id
    WHERE p.id = ?
    LIMIT 1
";

$consultaParaObtenerDetallesDelPost = $con->prepare($ordenSQLParaBuscarLaPublicacion);
$consultaParaObtenerDetallesDelPost->bind_param("i", $idDeLaPublicacionSolicitada);
$consultaParaObtenerDetallesDelPost->execute();

$resultadoDeLaBusquedaDelPost = $consultaParaObtenerDetallesDelPost->get_result();
$datosDeLaPublicacion = $resultadoDeLaBusquedaDelPost->fetch_assoc();

$consultaParaObtenerDetallesDelPost->close();

if (!$datosDeLaPublicacion) {
    echo "Publicació no trobada.";
    exit;
}

$ordenSQLParaBuscarComentarios = "
    SELECT c.contenido, c.creado_en, u.nombre AS autor
    FROM comentarios c
    JOIN usuarios u ON c.usuario_id = u.id
    WHERE c.publicacion_id = ?
    ORDER BY c.creado_en ASC
";

$consultaParaObtenerLaListaDeComentarios = $con->prepare($ordenSQLParaBuscarComentarios);
$consultaParaObtenerLaListaDeComentarios->bind_param("i", $idDeLaPublicacionSolicitada);
$consultaParaObtenerLaListaDeComentarios->execute();

$listaDeTodosLosComentarios = $consultaParaObtenerLaListaDeComentarios->get_result();

$consultaParaObtenerLaListaDeComentarios->close();
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($datosDeLaPublicacion['titulo']) ?> - Active360</title>
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
            <article class="post-card post-detalle">
                <div class="post-votes">
                    <form action="votar.php" method="post">
                        <input type="hidden" name="id" value="<?= (int)$datosDeLaPublicacion['id'] ?>">
                        <button type="submit" name="accion" value="up" class="upvote">▲</button>
                        <span class="vote-count"><?= (int)$datosDeLaPublicacion['votos'] ?></span>
                        <button type="submit" name="accion" value="down" class="downvote">▼</button>
                    </form>
                </div>

                <div class="post-content">
                    <div class="post-meta">
                        <span>
                            Publicat per <strong>@<?= htmlspecialchars($datosDeLaPublicacion['autor']) ?></strong>
                        </span>
                    </div>

                    <h1><?= htmlspecialchars($datosDeLaPublicacion['titulo']) ?></h1>
                    <p><?= nl2br(htmlspecialchars($datosDeLaPublicacion['contenido'])) ?></p>
                </div>
            </article>

            <section class="comments-section">
                
                <?php if (isset($_SESSION['id'])): ?>
                    <form action="guardar_comentario.php" method="post" class="comment-form">
                        <input type="hidden" name="publicacion_id" value="<?= (int)$datosDeLaPublicacion['id'] ?>">

                        <label for="comentario">
                            Afegeix un comentari com @<?= htmlspecialchars($_SESSION['nombre']) ?>:
                        </label>
                        <textarea id="comentario" name="comentario" rows="4" required></textarea>

                        <button type="submit" class="btn-create-post">Publicar comentari</button>
                    </form>
                <?php else: ?>
                    <p>Has d'<a href="Login.php">iniciar sessió</a> per comentar.</p>
                <?php endif; ?>

                <h2>Comentaris</h2>

                <?php if ($listaDeTodosLosComentarios->num_rows > 0): ?>
                    <ul class="comments-list">
                        <?php while ($comentarioIndividual = $listaDeTodosLosComentarios->fetch_assoc()): ?>
                            <li class="comment-item">
                                <div class="comment-author">
                                    @<?= htmlspecialchars($comentarioIndividual['autor']) ?>
                                </div>
                                <div class="comment-body">
                                    <?= nl2br(htmlspecialchars($comentarioIndividual['contenido'])) ?>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>Encara no hi ha comentaris. Sigues el primer!</p>
                <?php endif; ?>

            </section>
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