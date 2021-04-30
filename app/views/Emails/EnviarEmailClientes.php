 
      <?php
      
      require '../public/librerias/PHPMailer-master/src/Exception.php';
      require '../public/librerias/PHPMailer-master/src/PHPMailer.php';
      require '../public/librerias/PHPMailer-master/src/SMTP.php'; 
            
      use PHPMailer\PHPMailer\PHPMailer;
      use PHPMailer\PHPMailer\SMTP;
      use PHPMailer\PHPMailer\Exception;
      $mensaje  = "<html><body>";  
      $mensaje .= "<header style='height:auto; border: 1px solid #f1f1f1 '>
      <div style='padding: 15px 5px 15px 5px; background-color:lightgrey;'>
      <img src='https://myfp.com/wp-content/uploads/2013/10/LogoNormal.png'  alt='logo' style='height:50%'>
    
      <a href = 'https://www.facebook.com/myfp'><img src = 'http://icons.iconarchive.com/icons/limav/flat-gradient-social/512/Facebook-icon.png' style='float:right; width:25px; height:25px; margin-right:8px; padding-top:13px'></a>
      <a href= 'https://www.youtube.com/channel/UCYdUMN9I3HN3lFFbAhp9I-Q'><img src = 'https://www.shareicon.net/data/2016/07/06/110742_youtube_512x512.png' style='float:right; width:25px; height:25px; margin-right:8px; padding-top:13px'></a>
      <a href = 'https://twitter.com/informaconsulto'><img src = 'https://cdn.icon-icons.com/icons2/1183/PNG/512/1490133460-social-icons01_82210.png' style='float:right; width:25px; height:25px; margin-right:8px; padding-top:13px'></a>
      <a href= 'https://www.linkedin.com/company/informa-consultores'><img  src = 'http://upload.wikimedia.org/wikipedia/commons/thumb/c/c9/Linkedin.svg/200px-Linkedin.svg.png' style='float:right; width:25px; height:25px; margin-right:8px; padding-top:13px'></a>
      </div>  
      <div>". $_POST['contenido']."
      </div>   
      </header>
      <div style='background-color:#f1f1f1;padding-top:5px; height:auto'>
      <p style='float:left'> 
      <h3>myfp</h3>    
      C/ Esteban Salazar Chapela, 28
      Edificio Comoli - 2ª planta, Izquierda
      Poligono Guadalhorce
      29004 Malaga<br>
      Telefono: +34 952 224 064<br>
      Mail: info@myfp.com<br><br> 
      </p>
      </div>";    
      $mensaje .= "</body></html>";
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
            $mail->SetFrom("info@dataleanmakers.es",$_POST['remitente']); 
            $mail->Subject = utf8_decode( $_POST['subject']);
            $mail->Body = $mensaje ;           
            // $mail->AddAddress($datos['email']);
            $mail->AddAddress("armine.manukyan@dataleanmakers.es");
            $mail->AddAttachment($target);
            if(!$mail->Send()) {
              echo "Mailer Error: ". $mail->ErrorInfo;
            } else {
              echo " ";
            }    
          } catch(PDOException $exception){  
            return $exception->getMessage();                                 
           }        
?>