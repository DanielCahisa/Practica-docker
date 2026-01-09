<?php
session_start();
require_once 'conexion.php';

$listaDeCorreosAutorizados = ['daniel.cahisa@laginesta.com', 'david@active360.com'];
$es_admin = false;

if (isset($_SESSION['id'])) {
    $consultaParaVerificarPermisosDeAdmin = $con->prepare("SELECT correo FROM usuarios WHERE id = ?");
    $consultaParaVerificarPermisosDeAdmin->bind_param("i", $_SESSION['id']);
    $consultaParaVerificarPermisosDeAdmin->execute();
    
    $resultadoDeLaConsultaAdmin = $consultaParaVerificarPermisosDeAdmin->get_result();
    if ($datosDelUsuarioParaAdmin = $resultadoDeLaConsultaAdmin->fetch_assoc()) {
        if (in_array($datosDelUsuarioParaAdmin['correo'], $listaDeCorreosAutorizados)) {
            $es_admin = true;
        }
    }
    $consultaParaVerificarPermisosDeAdmin->close();
}

if (!$es_admin) {
    header("Location: index.php");
    exit;
}

$idDelUsuarioAEditar = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
$errores = [];
$datosDelUsuario = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre    = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $correo    = trim($_POST['correo']);
    $genero    = $_POST['genero'];
    $password  = $_POST['password'];

    if (strlen($nombre) < 3) $errores[] = "El nom és massa curt.";
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) $errores[] = "Correu invàlid.";

    if (empty($errores)) {
        if (!empty($password)) {
            $contrasenyaEncriptada = password_hash($password, PASSWORD_DEFAULT);
            $ordenSQLParaActualizar = "UPDATE usuarios SET nombre=?, apellidos=?, correo=?, genero=?, contrasenya=? WHERE id=?";
            $consultaParaActualizarUsuario = $con->prepare($ordenSQLParaActualizar);
            $consultaParaActualizarUsuario->bind_param("sssssi", $nombre, $apellidos, $correo, $genero, $contrasenyaEncriptada, $idDelUsuarioAEditar);
        } else {
            $ordenSQLParaActualizar = "UPDATE usuarios SET nombre=?, apellidos=?, correo=?, genero=? WHERE id=?";
            $consultaParaActualizarUsuario = $con->prepare($ordenSQLParaActualizar);
            $consultaParaActualizarUsuario->bind_param("ssssi", $nombre, $apellidos, $correo, $genero, $idDelUsuarioAEditar);
        }

        if ($consultaParaActualizarUsuario->execute()) {
            echo "<script>alert('Usuari actualitzat correctament.'); window.location.href='admin_usuarios.php';</script>";
            exit;
        } else {
            $errores[] = "Error SQL: " . $con->error;
        }
        $consultaParaActualizarUsuario->close();
    }
    $datosDelUsuario = ['id' => $idDelUsuarioAEditar, 'nombre' => $nombre, 'apellidos' => $apellidos, 'correo' => $correo, 'genero' => $genero];

} else {
    if ($idDelUsuarioAEditar > 0) {
        $consultaParaObtenerDatosDelUsuario = $con->prepare("SELECT * FROM usuarios WHERE id = ?");
        $consultaParaObtenerDatosDelUsuario->bind_param("i", $idDelUsuarioAEditar);
        $consultaParaObtenerDatosDelUsuario->execute();
        
        $resultadoDeLaConsultaDatos = $consultaParaObtenerDatosDelUsuario->get_result();
        $datosDelUsuario = $resultadoDeLaConsultaDatos->fetch_assoc();
        
        $consultaParaObtenerDatosDelUsuario->close();
    }
    if (empty($datosDelUsuario)) {
        echo "<script>alert('Usuari no trobat.'); window.location.href='admin_usuarios.php';</script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Usuari - Admin</title>
  <link rel="stylesheet" href="../css/register.css"> 
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>

  <div class="box1 edit-main-container">
    <div class="box2">
      
      <h1 class="reg title-spacing">Editar Usuari #<?= $datosDelUsuario['id'] ?></h1>
      
      <form action="editar_usuario.php" method="post">
        <input type="hidden" name="id" value="<?= $datosDelUsuario['id'] ?>">

        <div class="box3">
          <fieldset class="lege">
            <legend class="lege1">Dades personals</legend>

            <div class="box4">
              <label class="box5" for="nombre">Nom:</label>
              <input id="nombre" name="nombre" type="text" required value="<?= htmlspecialchars($datosDelUsuario['nombre']) ?>">
            </div>

            <div class="box4">
              <label class="box5" for="apellidos">Cognoms:</label>
              <input id="apellidos" name="apellidos" type="text" required value="<?= htmlspecialchars($datosDelUsuario['apellidos']) ?>">
            </div>

            <div class="box4">
              <label class="box5" for="correo">Email:</label>
              <input id="correo" name="correo" type="email" required value="<?= htmlspecialchars($datosDelUsuario['correo']) ?>">
            </div>

            <div class="box4">
              <label class="box5" for="password">Nova Contrasenya:</label>
              <input id="password" name="password" type="password" placeholder="(Deixar en blanc per no canviar)">
              <small class="password-hint">Només emplenar si es vol canviar.</small>
            </div>
          </fieldset>
        </div>

        <div class="box6">
          <label class="box14">Gènere:</label>
          
          <div class="lege22">
            <input id="sexo1" type="radio" name="genero" value="masculino" <?= ($datosDelUsuario['genero'] == 'masculino') ? 'checked' : '' ?>>
            <label for="sexo1">
                <span class="hombre"></span> Home
            </label>
          </div>
          
          <div class="lege22">
            <input id="sexo2" type="radio" name="genero" value="femenino" <?= ($datosDelUsuario['genero'] == 'femenino') ? 'checked' : '' ?>>
            <label for="sexo2">
                <span class="mujer"></span> Dona
            </label>
          </div>
          
          <div class="lege22">
            <input id="sexo3" type="radio" name="genero" value="NS" <?= ($datosDelUsuario['genero'] == 'NS') ? 'checked' : '' ?>>
            <label for="sexo3">
                <span class="ns"></span> NS/NC
            </label>
          </div>
        </div>

        <div class="Send send-column">
            <input class="Enviar" type="submit" value="Guardar Canvis">
            <a href="admin_usuarios.php" class="cancel-link">Cancel·lar i tornar</a>
        </div>

        <?php if (!empty($errores)): ?>
        <div class="alerta">
            <?php foreach ($errores as $error): ?>
                <div><?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

      </form>
    </div>
  </div>

</body>
</html>