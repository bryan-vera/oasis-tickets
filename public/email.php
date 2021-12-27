<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'assets/PHPMailer/PHPMailer-master/src/Exception.php';
require 'assets/PHPMailer/PHPMailer-master/src/PHPMailer.php';
require 'assets/PHPMailer/PHPMailer-master/src/SMTP.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'mail.grupolabovida.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;      
    $mail->SMTPAutoTLS = false;                              // Enable SMTP authentication
    $mail->Username   = 'oasis@grupolabovida.com';                     // SMTP username
    $mail->Password   = '2d{uC(_v4jr=';                               // SMTP password
    $mail->Port       =587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('oasis@grupolabovida.com', 'Ticket #45');
    $mail->addAddress('bvera@grupolabovida.com', 'Bryan Vera');     // Add a recipient
    $mail->addAddress('bvera@grupolabovida.com');               // Name is optional
    $mail->addReplyTo('bryanvera93@hotmail.com', 'Copia');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Este es el asunto';
    $mail->Body    = 'Este es el mensaje en html <b>in bold!</b>';
    $mail->AltBody = 'Este es el mensaje en texto plano para los clientes que no pueden leer HTML';

    $mail->send();
    echo 'El mensaje se envió correctamente';
} catch (Exception $e) {
    echo "El mensaje no pudo ser enviado. Error de correo: {$mail->ErrorInfo}";
}


?>