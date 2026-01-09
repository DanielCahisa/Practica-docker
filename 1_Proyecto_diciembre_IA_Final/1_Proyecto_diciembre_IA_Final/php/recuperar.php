<?php
require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

require_once('conexion.php'); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
$mensaje = '';
$clase_mensaje = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correoIngresadoPorUsuario = strtolower(trim($_POST['correo']));

    $consultaParaVerificarSiExisteElCorreo = $con->prepare("SELECT id, nombre FROM usuarios WHERE correo = ?");
    $consultaParaVerificarSiExisteElCorreo->bind_param("s", $correoIngresadoPorUsuario);
    $consultaParaVerificarSiExisteElCorreo->execute();
    $consultaParaVerificarSiExisteElCorreo->store_result();

    if ($consultaParaVerificarSiExisteElCorreo->num_rows > 0) {
        $tokenUnicoGenerado = bin2hex(random_bytes(16));
        $horaDeCaducidadDelToken = date('Y-m-d H:i:s', time() + 3600); 

        $consultaParaGuardarElToken = $con->prepare("UPDATE usuarios SET token_recuperacion = ?, token_expiracion = ? WHERE correo = ?");
        $consultaParaGuardarElToken->bind_param("sss", $tokenUnicoGenerado, $horaDeCaducidadDelToken, $correoIngresadoPorUsuario);
        
        if ($consultaParaGuardarElToken->execute()) {
            
            $enlaceParaRestablecerContrasenya = "http://localhost/1_PROYECTO_DICIEMBRE_IA_FINAL/php/restablecer.php?token=" . $tokenUnicoGenerado;

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'dcahisabenito@gmail.com'; 
                $mail->Password = 'xmko jwyl bisl czst';    
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                $mail->setFrom('dcahisabenito@gmail.com', 'Active360 Soporte');
                $mail->addAddress($correoIngresadoPorUsuario);

                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Recuperació de contrasenya - Active360';
                
                $mail->Body = "
                <div style='font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f4;'>
                    <div style='background-color: white; padding: 20px; border-radius: 5px; max-width: 600px; margin: auto;'>
                        <h2 style='color: #e5007d;'>Recuperació de contrasenya</h2>
                        <p>Hola,</p>
                        <p>Hem rebut una sol·licitud per restablir la teva contrasenya a Active360.</p>
                        <p>Fes clic al botó de sota per crear una nova contrasenya:</p>
                        <br>
                        <div style='text-align: center;'>
                            <a href='$enlaceParaRestablecerContrasenya' style='background-color: #e5007d; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;'>Restablir contrasenya</a>
                        </div>
                        <br><br>
                        <p style='font-size: 12px; color: #666;'>Si el botó no funciona, copia aquest enllaç al teu navegador:<br> $enlaceParaRestablecerContrasenya</p>
                        <hr style='border: 0; border-top: 1px solid #eee;'>
                        <p style='color: #999; font-size: 12px;'>Aquest enllaç caduca en 1 hora.</p>
                    </div>
                </div>";
                
                $mail->AltBody = "Copia aquest enllaç per recuperar la teva contrasenya: $enlaceParaRestablecerContrasenya";

                $mail->send();
                
                $mensaje = "S'ha enviat un correu electrònic amb les instruccions. Revisa la teva safata d'entrada (i correu brossa).";
                $clase_mensaje = "alerta-exito";

            } catch (Exception $e) {
                $mensaje = "No s'ha pogut enviar el correu. Error: {$mail->ErrorInfo}";
                $clase_mensaje = "alerta-error";
            }

        } else {
            $mensaje = "Error al connectar amb la base de dades.";
            $clase_mensaje = "alerta-error";
        }
        $consultaParaGuardarElToken->close();
    } else {
        $mensaje = "Aquest correu no està registrat al nostre sistema.";
        $clase_mensaje = "alerta-error";
    }
    $consultaParaVerificarSiExisteElCorreo->close();
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contrasenya - Active360</title>
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
                <h1>Recuperar contrasenya</h1>
                
                <?php if ($mensaje): ?>
                    <div class="<?= $clase_mensaje ?>">
                        <?= $mensaje ?>
                    </div>
                <?php endif; ?>

                <p class="recover-description">
                    Introdueix el teu correu electrònic i t'enviarem un enllaç per restablir la teva contrasenya.
                </p>
            
                <form class="login-form" action="recuperar.php" method="post">
                    <div class="form-group">
                        <label for="correo">Correu electrònic</label>
                        <input type="email" id="correo" name="correo" placeholder="exemple@correu.com" required>
                    </div>

                    <button type="submit" class="btn-login">ENVIAR ENLLAÇ</button>
                    
                    <div class="form-options-minimal mt-small">
                        <a href="area-client.php" class="form-link">Tornar a l'inici de sessió</a>
                    </div>
                </form>
            </section>
        </div>
    </main>

</body>
</html>