<?php

require '../public/librerias/PHPMailer-master/src/Exception.php';
require '../public/librerias/PHPMailer-master/src/PHPMailer.php';
require '../public/librerias/PHPMailer-master/src/SMTP.php'; 
      
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class enviarEmail {

                          
    public static function enviarEmailDestinatario($nombreRemitente, $emailRemitente, $emailDestinatario,$asunto,$message,$attachment,$datos='') 
    {
    
      try {
        

        $mail = new PHPMailer;  
        //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only       
        $mail->IsSMTP(); // enable SMTP        
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
          )
        );          
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = $emailRemitente;
        $mail->Password = "Bobedano2019$";
        $mail->Sender = $emailRemitente;
        
        $mail->SetFrom($emailRemitente,$nombreRemitente);
        $mail->Subject = utf8_decode($asunto);
        $mail->Body = utf8_decode($message);
        
        $emails = $emailDestinatario;
        $nombreDestinatario = 'Jenny Ruiz';
        $mail->AddStringAttachment($attachment, 'factura.pdf');
        foreach ($emails as $row) {
         
          $mail->addAddress($row, $nombreDestinatario);
                     
        }

        // Activo condificacción utf-8
        $mail->CharSet = 'UTF-8';
        if (!$mail->Send()) {
          return 0;      
        } else {         
          return 1;
        }
                 


      } catch (Exception $exception) {
        return $exception->getMessage();
      }
      
    }

  }