<?php

require '../public/librerias/PHPMailer-master/src/Exception.php';
require '../public/librerias/PHPMailer-master/src/PHPMailer.php';
require '../public/librerias/PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class enviarEmail
{

/**
 * Función que envía correos a los emails deseados con la librería de PHP Mailer
 */
  public static function enviarEmailDestinatario($nombreRemitente, $emailRemitente, $emailDestinatario, $asunto, $message, $attachment, $datos = '')
  {

    try {

      $conf_mail_username = 'adrian.beigveder@dataleanmakers.es';                    // SMTP username     //
      $conf_mail_password = 'yesica213. ';                 // SMTP password     //
      $conf_mail_from_email = 'adrian.beigveder@dataleanmakers.es';                // SMTP email        //
      $conf_mail_from_name = 'MyFP';                        // nombre            //
      $conf_mail_host = "smtp.gmail.com"; // Servidor saliente //
      $conf_mail_security = "ssl";
      $conf_mail_port = 465;


      $mail = new PHPMailer;

      $mail->SMTPDebug = SMTP::DEBUG_OFF;  // Debug
      $mail->isSMTP();
      $mail->Host = $conf_mail_host;
      $mail->SMTPAuth = true;                     // Enable SMTP authentication
      $mail->Username = $conf_mail_username;
      $mail->Password = $conf_mail_password;
      $mail->SMTPSecure = $conf_mail_security ?? 'tls';
      $mail->Port = $conf_mail_port ?? 587;
      $mail->CharSet = 'UTF-8';

      // Envio desde y envio a...
      $mail->setFrom($conf_mail_from_email, $conf_mail_from_name);
      $mail->addAddress($emailDestinatario, "MyFP");

      // Componemos el email
      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body = $message;

      // Enviar email
      $result = $mail->send();
 
    } catch (Exception $exception) {
      return $exception->getMessage();
    }
  }
}
