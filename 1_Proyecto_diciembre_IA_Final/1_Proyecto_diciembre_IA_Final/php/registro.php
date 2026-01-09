<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('conexion.php');

$errores = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre      = trim($_POST['nombre'] ?? '');
    $apellidos   = trim($_POST['apellidos'] ?? '');
    $correo      = strtolower(trim($_POST['correo'] ?? ''));
    $contrasenya = $_POST['contrasenya'] ?? '';
    $terminos    = $_POST['terminos'] ?? '';
    $genero      = $_POST['genero'] ?? '';

    if (strlen($nombre) < 3) {
        $errores[] = "El usuario tiene que tener mínimo 3 caracteres";
    }
    if (strlen($apellidos) < 2) {
        $errores[] = "Los apellidos deben tener mínimo 2 caracteres";
    }
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El mail es incorrecto";
    }
    if (strlen($contrasenya) < 6 || strlen($contrasenya) > 12) {
        $errores[] = "El password tiene que tener entre 6 y 12 caracteres";
    }
    if (!preg_match('/[A-Z]/', $contrasenya) || !preg_match('/[0-9]/', $contrasenya) || !preg_match('/[a-z]/', $contrasenya)) {
        $errores[] = "La contraseña debe tener: 1 Mayúscula, 1 Minúscula y 1 Número.";
    }
    if (!in_array($genero, ['masculino','femenino','NS'], true)) {
        $errores[] = "Debes seleccionar un género";
    }
    if ($terminos !== 'Si') {
        $errores[] = "Debes aceptar los términos y condiciones";
    }

    if (empty($errores)) {
        $contrasenyaEncriptada = password_hash($contrasenya, PASSWORD_DEFAULT);

        $consultaParaVerificarSiExisteElCorreo = $con->prepare("SELECT id FROM usuarios WHERE correo = ? LIMIT 1");
        
        if (!$consultaParaVerificarSiExisteElCorreo) {
            $errores[] = "Error preparando consulta correo: " . $con->error;
        } else {
            $consultaParaVerificarSiExisteElCorreo->bind_param("s", $correo);
            $consultaParaVerificarSiExisteElCorreo->execute();
            $consultaParaVerificarSiExisteElCorreo->store_result();
            
            if ($consultaParaVerificarSiExisteElCorreo->num_rows > 0) {
                $errores[] = "Este correo ya está registrado.";
            }
            $consultaParaVerificarSiExisteElCorreo->close();
        }

        if (empty($errores)) {
            $consultaParaInsertarNuevoUsuario = $con->prepare("
                INSERT INTO usuarios (nombre, apellidos, contrasenya, correo, genero, terminos)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            
            if (!$consultaParaInsertarNuevoUsuario) {
                $errores[] = "Error SQL (Prepare): " . $con->error;
            } else {
                $consultaParaInsertarNuevoUsuario->bind_param("ssssss", $nombre, $apellidos, $contrasenyaEncriptada, $correo, $genero, $terminos);

                if ($consultaParaInsertarNuevoUsuario->execute()) {
                    $_SESSION['nombre'] = $nombre;
                    $_SESSION['id'] = $consultaParaInsertarNuevoUsuario->insert_id;
                    
                    $consultaParaInsertarNuevoUsuario->close();
                    $con->close();

                    header("Location: index.php");
                    exit; 
                } else {
                    $errores[] = "Error SQL (Execute): " . $consultaParaInsertarNuevoUsuario->error;
                    $consultaParaInsertarNuevoUsuario->close();
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registro</title>
  <link rel="stylesheet" href="../css/register.css"/>
</head>

<body>

  <?php require_once 'cabezera.php'; ?>

  <div class="box1">
    <div class="box2">
      <form action="registro.php" method="post" novalidate>
        <div class="box3">
          <fieldset class="lege">
            <legend class="lege1">Datos privados</legend>

            <div class="box4">
              <label class="box5" for="nombre">Usuario:</label>
              <input id="nombre" name="nombre" type="text" placeholder="Escribe tu usuario" required
                     value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
              <span class="icon"></span>
            </div>

            <div class="box4">
              <label class="box5" for="apellidos">Apellidos:</label>
              <input id="apellidos" name="apellidos" type="text" placeholder="Escribe tus apellidos" required
                     value="<?= htmlspecialchars($_POST['apellidos'] ?? '') ?>">
              <span class="icon"></span>
            </div>

            <div class="box4">
              <label class="box5" for="correo">Email:</label>
              <input id="correo" name="correo" type="email" placeholder="Escribe tu correo" required
                     value="<?= htmlspecialchars($_POST['correo'] ?? '') ?>">
              <span class="icon"></span>
            </div>

            <div class="box4">
              <label class="box5" for="contrasenya">Crear Contraseña:</label>
              <div class="input-container">
                <input id="contrasenya" name="contrasenya" placeholder="Escribe tu contrasenya" type="password" required>
                <img src="../img/ojo.png" alt="Mostrar contrasenya" class="icon ojo">
              </div>
            </div>

          </fieldset>
        </div>

        <div class="box6">
          <label class="box14">Sexo:</label>

          <div class="lege22">
            <input id="sexo1" type="radio" name="genero" value="masculino" <?= (($_POST['genero'] ?? '') === 'masculino') ? 'checked' : '' ?>>
            <label for="sexo1"><span class="hombre"></span> Hombre</label>
          </div>

          <div class="lege22">
            <input id="sexo2" type="radio" name="genero" value="femenino" <?= (($_POST['genero'] ?? '') === 'femenino') ? 'checked' : '' ?>>
            <label for="sexo2"><span class="mujer"></span> Mujer</label>
          </div>

          <div class="lege22">
            <input id="sexo3" type="radio" name="genero" value="NS" <?= (($_POST['genero'] ?? '') === 'NS') ? 'checked' : '' ?>>
            <label for="sexo3"><span class="ns"></span> NS</label>
          </div>
        </div>

        <div class="box14">
          <div class="lege3">
            <input id="acepto" type="checkbox" name="terminos" value="Si"
                   <?= (($_POST['terminos'] ?? '') === 'Si') ? 'checked' : '' ?>>
            <label for="acepto"><span class="term"></span> Acepto los términos y condiciones</label>
          </div>
        </div>

        <div class="Send">
            <input class="Enviar" type="submit" value="Enviar">
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

  <script src="../js/registro.js"></script>
</body>
</html>