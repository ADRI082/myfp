 
      <?php
      
      require '../public/librerias/PHPMailer-master/src/Exception.php';
      require '../public/librerias/PHPMailer-master/src/PHPMailer.php';
      require '../public/librerias/PHPMailer-master/src/SMTP.php'; 
            
      use PHPMailer\PHPMailer\PHPMailer;
      use PHPMailer\PHPMailer\SMTP;
      use PHPMailer\PHPMailer\Exception;
     
      try {
            $mail = new PHPMailer;          
            $mail->IsSMTP(); // enable SMTP
            //  $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
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
            $mail->Username = "info@dataleanmakers.es";
            $mail->Password = "Bobedano2019$";
            $mail->SetFrom("info@dataleanmakers.es","myfp"); 
            $mail->Subject = utf8_decode(" Factura myfp");
            $mail->Body = "Buenos días,<br><br>Por favor confirmar el recibido de este correo, se adjunta factura de servicios.<br><br>Atentamente,<br>myfp" ;           
            $mail->AddAddress($datosFactura->mailcontacto);

            // $mail->AddAddress("armine.manukyan@dataleanmakers.es");
            $mail->AddStringAttachment($attachment, 'pdf_generated.pdf');
            if(!$mail->Send()) {
              echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
              //echo "Se ha enviado la factura";
              $datos = [
                "id" => $datosFactura->idPresupuesto,
                "idAccionPres" => $datosFactura->idACCION,
                "fechaInicio" => $datosFactura->fechaInicio
              ];
              $id = $datos['id']."_".$datos['idAccionPres']."_".$datos['fechaInicio'];
              $variable = '<script type="text/javascript">window.location.href="'.RUTA_URL.'/Proyecto/fichaProyecto/'.$id.'/1"</script>';
              echo $variable;
              //header('location: ../app/Controllers/Proyecto/fichaProyecto/'.$id);        
              //redireccionar(RUTA_URL.'/Proyecto/fichaProyecto/'.$id);
            }    
      } catch(PDOException $exception){  
            redireccionar('/proyecto/listaProyectos');
            return $exception->getMessage();                                 
      } 

        //redireccionar('/proyecto/listaProyectos');
?>