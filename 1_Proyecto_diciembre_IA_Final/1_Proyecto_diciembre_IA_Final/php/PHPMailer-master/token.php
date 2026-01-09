<?php
// Asegúrate de que la carpeta 'src' está en el mismo directorio que este archivo
require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';
require_once('../php/conexion.php'); // Verifica que esta ruta sea correcta

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// ELIMINADO DE AQUÍ: $enlace = ... (Aquí daba error porque $miToken no existía aún)

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mailer = $_POST['correo'];
    
    // 1. Generamos el token
    $miToken = bin2hex(random_bytes(16));
    $temporal = date('Y-m-d H:i:s', time() + 3600); // 1 hora de validez

    // 2. Actualizamos la base de datos
    // Asegúrate de que tu tabla 'usuarios' tiene las columnas: token_recuperacion y token_expiracion
    // NOTA: He cambiado 'token' por 'token_recuperacion' para coincidir con lo que creamos en la base de datos antes.
    // Si en tu base de datos la columna se llama solo 'token', cámbialo aquí.
    $consulta = $con->prepare("UPDATE usuarios SET token_recuperacion=?, token_expiracion=? WHERE correo=?");
    $consulta->bind_param("sss", $miToken, $temporal, $mailer);
    
    if ($consulta->execute()) {
        
        // 3. AQUÍ ES DONDE VA EL ENLACE (Justo cuando ya tenemos token y se ha guardado)
        // He puesto 'restablecer.php' porque es el archivo que creamos en el paso anterior.
        $enlace = "http://localhost/1_PROYECTO_DICIEMBRE_IA_FINAL/php/restablecer.php?token=" . $miToken;
        $mail = new PHPMailer(true);

        try {
            // Configuración del Servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'dcahisabenito@gmail.com'; // Tu correo
            $mail->Password = 'xmko jwyl bisl czst';    // Tu contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Destinatarios
            $mail->setFrom('dcahisabenito@gmail.com', 'Active-360');
            $mail->addAddress($mailer);

            // Contenido
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Recuperación de contraseña';
            
            $mail->Body = "
            <div style='font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f4;'>
                <div style='background-color: white; padding: 20px; border-radius: 5px;'>
                    <h2 style='color: #333;'>Recuperar contraseña</h2>
                    <p>Hemos recibido una solicitud para restablecer tu contraseña.</p>
                    <p>Haz clic en el siguiente botón:</p>
                    <br>
                    <a href='$enlace' style='background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;'>Restablecer contraseña</a>
                    <br><br>
                    <p style='font-size: 12px; color: #666;'>Si el botón no funciona, copia este enlace: $enlace</p>
                </div>
            </div>";
            
            $mail->AltBody = "Visita este enlace para recuperar tu contraseña: $enlace";

            $mail->send();
            echo 'El mensaje ha sido enviado correctamente.';
        } catch (Exception $e) {
            echo "El mensaje no pudo ser enviado. Error del Mailer: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error al conectar con la base de datos o el correo no existe.";
    }
}
?>