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
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.dreamhost.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;
    //$mail->SMTPSecure = 'ssl';
    //$mail->SMTPAutoTLS = false;                              // Enable SMTP authentication
    $mail->Username   = 'pruebas@makrosys.com';                     // SMTP username
    $mail->Password   = 'testcicovisa';                               // SMTP password
    $mail->Port       =465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('pruebas@makrosys.com', 'Ticket #45');
    $mail->addAddress('info@store-cicovisa.com', 'Test');     // Add a recipient 

    // Content
    
    $subjectadm = "¡Información de contacto de Andrea Albán!";
    $mailContentadm ='<div style="background-color: #fff; margin: 0; padding: 70px 0; width: 100%;">
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
            <td align="center" valign="top">
            <table style="background-color: #ffffff; border: 1px solid #dedede; border-radius: 3px;" border="0" width="600" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
            <td align="center" valign="top">
            <table style="background-color:#b26e2f; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: Helvetica Neue,Helvetica,Roboto,Arial,sans-serif; border-radius: 3px 3px 0 0;" border="0" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
            <td style="padding: 36px 48px; display: block;">
            <h1 style="font-family: Helvetica Neue,Helvetica,Roboto,Arial,sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; color: #ffffff;">Información de contacto</h1>
            </td>
            </tr>
            </tbody>
            </table>
            </td>
            </tr>
            <tr>
            <td align="center" valign="top">
            <table border="0" width="600" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
            <td style="background-color: #ffffff;" valign="top">
            <table border="0" width="100%" cellspacing="0" cellpadding="20">
            <tbody>
            <tr>
            <td style="padding: 48px 48px 32px;" valign="top">
            <div style="color: #636363; font-family: Helvetica Neue,Helvetica,Roboto,Arial,sans-serif; font-size: 14px; line-height: 150%; text-align: left;">
            <p style="margin: 0 0 16px;"><strong>De:</strong> Gabriel</p>
            <p style="margin: 0 0 16px;"><strong>Teléfono:</strong> 0969884433</p>
            <p style="margin: 0 0 16px;"><strong>Email:</strong> email</p>
            <p style="margin: 0 0 16px;"><strong>Mensaje:</strong> Prueba de Correo</p>

            <p ><br>
              Este mensaje fue enviado desde <a style="color: #b26e2f; font-weight: normal; text-decoration: underline;" href="http://www.creasolucionesdigitales.com/andreaalban/preproduccion/" target="_blank">http://www.creasolucionesdigitales.com/andreaalban/preproduccion/</a>.</p>
            </div>
            </td>
            </tr>
            </tbody>
            </table>
            </td>
            </tr>
            </tbody>
            </table>
            </td>
            </tr>
            </tbody>
            </table>
            </td>
            </tr>
            <tr>
            <td align="center" valign="top">
            <table border="0" width="600" cellspacing="0" cellpadding="10">
            <tbody>
            <tr>
            <td style="padding: 0; border-radius: 6px;" valign="top">
            <table border="0" width="100%" cellspacing="0" cellpadding="10">
            <tbody>
            <tr>
            <td style="border-radius: 6px; border: 0; color: #8a8a8a; font-family: "Helvetica Neue",Helvetica,Roboto,Arial,sans-serif; font-size: 12px; line-height: 150%; text-align: center; padding: 24px 0;" colspan="2" valign="middle">&nbsp;</td>
            </tr>
            </tbody>
            </table>
            </td>
            </tr>
            </tbody>
            </table>
            </td>
            </tr>
            </tbody>
            </table>
            </div>';
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = "tEST";
    $mail->Body    = "Test";
    $mail->AltBody = 'Este es el mensaje en texto plano para los clientes que no pueden leer HTML';

    $mail->send();
    echo 'El mensaje se envió correctamente';
} catch (Exception $e) {
    echo "El mensaje no pudo ser enviado. Error de correo: {$mail->ErrorInfo}";
}

 


?>
