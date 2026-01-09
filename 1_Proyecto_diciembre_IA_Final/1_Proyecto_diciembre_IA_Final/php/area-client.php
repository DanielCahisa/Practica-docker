<?php
session_start();

if (isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}

require_once 'conexion.php';

$errorMsg = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $correoIngresado      = strtolower(trim($_POST['correo'] ?? ''));
    $contrasenyaIngresada = $_POST['password'] ?? '';

    if (empty($correoIngresado) || empty($contrasenyaIngresada)) {
        $errorMsg = "Siusplau, omple tots els camps.";
    } else {
        
        $consultaBusquedaUsuario = $con->prepare("SELECT id, nombre, contrasenya FROM usuarios WHERE correo = ? LIMIT 1");
        
        $consultaBusquedaUsuario->bind_param("s", $correoIngresado);
        $consultaBusquedaUsuario->execute();
        
        $resultadoDeLaBusqueda = $consultaBusquedaUsuario->get_result();
        
        $datosDelUsuarioEncontrado = $resultadoDeLaBusqueda->fetch_assoc();
        
        $consultaBusquedaUsuario->close();

        if ($datosDelUsuarioEncontrado && password_verify($contrasenyaIngresada, $datosDelUsuarioEncontrado['contrasenya'])) {
            
            $_SESSION['id'] = $datosDelUsuarioEncontrado['id'];
            $_SESSION['nombre'] = $datosDelUsuarioEncontrado['nombre'];
            
            header("Location: index.php");
            exit;
        } else {
            $errorMsg = "El correu o la contrasenya són incorrectes.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Àrea de Client - Active360</title>
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

            <?php if (!empty($errorMsg)): ?>
                <div class="alerta-error">
                    <?= htmlspecialchars($errorMsg) ?>
                </div>
            <?php endif; ?>

            <h1>Àrea de client</h1>
           
            <form class="login-form" action="" method="POST">
                <div class="user-icon-large">
                    <img src="../img/client-hover.png" alt="Icono de Usuario Grande">
                </div>
               
                <div class="form-group">
                    <label for="correo">Email</label>
                    <input type="email" id="correo" name="correo" placeholder="Escriu el teu email" required value="<?= htmlspecialchars($_POST['correo'] ?? '') ?>">
                </div>
               
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Escriu el teu password" required>
                </div>

                <div class="form-options-minimal">
                    <div class="form-links">
                        <a href="registro.php" class="form-link">Crear usuari</a> i
                        <a href="recuperar.php" class="form-link">Recuperar la contrasenya.</a>
                    </div>
                </div>

                <button type="submit" class="btn-login">LOGIN</button>
            </form>
        </section>
    </div>
</main>

</body>
</html>