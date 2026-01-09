<?php
session_start();
require_once 'conexion.php';

$mensaje = '';
$tokenRecibidoPorURL = $_GET['token'] ?? '';
$mostrarFormularioDeCambio = false;

if ($tokenRecibidoPorURL) {
    $horaActual = date("Y-m-d H:i:s");
    
    $consultaParaVerificarToken = $con->prepare("SELECT id FROM usuarios WHERE token_recuperacion = ? AND token_expiracion > ?");
    $consultaParaVerificarToken->bind_param("ss", $tokenRecibidoPorURL, $horaActual);
    $consultaParaVerificarToken->execute();
    $consultaParaVerificarToken->store_result();

    if ($consultaParaVerificarToken->num_rows > 0) {
        $mostrarFormularioDeCambio = true;
    } else {
        $mensaje = "L'enllaç no és vàlid o ha caducat.";
    }
    $consultaParaVerificarToken->close();
} else {
    header("Location: area-client.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && $mostrarFormularioDeCambio) {
    $nuevaContrasenya1 = $_POST['pass1'];
    $nuevaContrasenya2 = $_POST['pass2'];

    if (strlen($nuevaContrasenya1) < 6) {
        $mensaje = "La contrasenya ha de tenir almenys 6 caràcters.";
    } elseif ($nuevaContrasenya1 !== $nuevaContrasenya2) {
        $mensaje = "Les contrasenyes no coincideixen.";
    } else {
        $contrasenyaEncriptada = password_hash($nuevaContrasenya1, PASSWORD_DEFAULT);

        $consultaParaActualizarContrasenya = $con->prepare("UPDATE usuarios SET contrasenya = ?, token_recuperacion = NULL, token_expiracion = NULL WHERE token_recuperacion = ?");
        $consultaParaActualizarContrasenya->bind_param("ss", $contrasenyaEncriptada, $tokenRecibidoPorURL);
        
        if ($consultaParaActualizarContrasenya->execute()) {
            header("Location: area-client.php?mensaje=password_updated");
            exit;
        } else {
            $mensaje = "Error al guardar la contrasenya.";
        }
        $consultaParaActualizarContrasenya->close();
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova contrasenya - Active360</title>
    <link rel="stylesheet" href="../css/videos-login.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>

    <header>
       <?php require_once 'cabezera.php'; ?>
    </header>

    <main class="login-main">
        <div class="login-container">
            <section class="login-form-section">
                <h1>Restablir contrasenya</h1>

                <?php if ($mensaje): ?>
                    <div class="error-message-box">
                        <?= htmlspecialchars($mensaje) ?>
                    </div>
                <?php endif; ?>

                <?php if ($mostrarFormularioDeCambio): ?>
                    <form class="login-form" action="restablecer.php?token=<?= htmlspecialchars($tokenRecibidoPorURL) ?>" method="post">
                        <div class="form-group">
                            <label for="pass1">Nova contrasenya</label>
                            <input type="password" id="pass1" name="pass1" placeholder="Mínim 6 caràcters" required>
                        </div>

                        <div class="form-group">
                            <label for="pass2">Repeteix la contrasenya</label>
                            <input type="password" id="pass2" name="pass2" placeholder="Repeteix la contrasenya" required>
                        </div>

                        <button type="submit" class="btn-login">CANVIAR CONTRASENYA</button>
                    </form>
                <?php else: ?>
                    <p>L'enllaç no és vàlid. <a href="recuperar.php" class="retry-link">Torna a sol·licitar-ho aquí.</a></p>
                <?php endif; ?>
            </section>
        </div>
    </main>

</body>
</html>