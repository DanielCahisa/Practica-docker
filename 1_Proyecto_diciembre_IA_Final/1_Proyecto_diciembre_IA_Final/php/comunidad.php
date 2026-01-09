<?php
session_start();
require_once 'conexion.php';

function tiempo_relativo($fechaHora)
{
    $timestamp = strtotime($fechaHora);
    if ($timestamp === false) return '';

    $diff = time() - $timestamp;
    if ($diff < 60) return 'Hace ' . $diff . ' s';
    $min = floor($diff / 60);
    if ($min < 60) return 'Hace ' . $min . ' min';
    $horas = floor($min / 60);
    if ($horas < 24) return 'Hace ' . $horas . ' h';
    $dias = floor($horas / 24);
    if ($dias < 30) return 'Hace ' . $dias . ' día' . ($dias > 1 ? 's' : '');
    $meses = floor($dias / 30);
    if ($meses < 12) return 'Hace ' . $meses . ' mes' . ($meses > 1 ? 'es' : '');
    $anios = floor($meses / 12);
    return 'Hace ' . $anios . ' año' . ($anios > 1 ? 's' : '');
}

function inicial_nombre($nombre)
{
    $nombre = trim($nombre);
    if ($nombre === '') return '?';
    return mb_strtoupper(mb_substr($nombre, 0, 1, 'UTF-8'), 'UTF-8');
}

$consultaParaObtenerPublicaciones = "
  SELECT 
    p.id,
    p.titulo,
    p.contenido,
    p.votos,
    p.creado_en,
    u.nombre AS autor,
    (SELECT COUNT(*) 
       FROM comentarios c 
      WHERE c.publicacion_id = p.id) AS num_comentarios
  FROM publicaciones p
  JOIN usuarios u ON p.usuario_id = u.id
  ORDER BY p.votos DESC, p.creado_en DESC
";

$resultadoConTodasLasPublicaciones = $con->query($consultaParaObtenerPublicaciones);
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunitat - Active360</title>
    <link rel="stylesheet" href="../css/comunidad.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>

    <?php require_once 'cabezera.php'; ?>

    <main class="comunidad-main">
        <div class="comunidad-container">
            <section class="post-feed">
                <h1>Fòrum de la Comunitat Active360</h1>
                <p class="comunidad-description">
                    Comparteix els teus entrenaments, pregunta dubtes i connecta amb altres entusiastes del fitness i l'esport.
                </p>
                
                <div class="create-post">
                    <?php if (isset($_SESSION['id'])): ?>
                        <a href="crear_publicacion.php" class="btn-create-post">Crea una Nova Publicació</a>
                    <?php else: ?>
                        <a href="area-client.php" class="btn-create-post">Inicia sessió per publicar</a>
                    <?php endif; ?>
                </div>

                <?php if ($resultadoConTodasLasPublicaciones && $resultadoConTodasLasPublicaciones->num_rows > 0): ?>
                    <?php while ($publicacionIndividual = $resultadoConTodasLasPublicaciones->fetch_assoc()): ?>
                        <article class="post-card">
                            <div class="post-votes">
                                <form action="votar.php" method="post">
                                    <input type="hidden" name="id" value="<?= (int)$publicacionIndividual['id'] ?>">
                                    <button type="submit" name="accion" value="up" class="upvote">▲</button>
                                    <span class="vote-count"><?= (int)$publicacionIndividual['votos'] ?></span>
                                    <button type="submit" name="accion" value="down" class="downvote">▼</button>
                                </form>
                            </div>

                            <div class="post-content">
                                <div class="post-meta">

                                    <div class="post-avatar">
                                        <span class="avatar-inicial">
                                            <?= htmlspecialchars(inicial_nombre($publicacionIndividual['autor'])) ?>
                                        </span>
                                    </div>

                                    <div class="post-meta-text">
                                        <span class="post-author">
                                            Publicat per <strong>@<?= htmlspecialchars($publicacionIndividual['autor']) ?></strong>
                                        </span>
                                        <span class="post-time">
                                            · <?= tiempo_relativo($publicacionIndividual['creado_en']) ?>
                                        </span>
                                    </div>
                                </div>

                                <h2 class="post-title">
                                    <a href="publicacion.php?id=<?= (int)$publicacionIndividual['id'] ?>">
                                        <?= htmlspecialchars($publicacionIndividual['titulo']) ?>
                                    </a>
                                </h2>

                                <p class="post-excerpt">
                                    <?php
                                        $texto = $publicacionIndividual['contenido'] ?? '';
                                        $resumen = mb_substr($texto, 0, 200, 'UTF-8');
                                        echo nl2br(htmlspecialchars($resumen, ENT_QUOTES, 'UTF-8'));
                                        if (mb_strlen($texto, 'UTF-8') > 200) {
                                            echo '…';
                                        }
                                    ?>
                                </p>

                                <div class="post-actions">
                                    <a href="publicacion.php?id=<?= (int)$publicacionIndividual['id'] ?>" class="action-link">
                                        <?= (int)$publicacionIndividual['num_comentarios'] ?> comentaris
                                    </a>
                                    <a href="publicacion.php?id=<?= (int)$publicacionIndividual['id'] ?>" class="action-link">
                                        Obrir publicació
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Encara no hi ha publicacions. Sigues el primer a compartir-ne una!</p>
                <?php endif; ?>
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