<?php   
    
    require('PHPMailerAutoload.php');

    function send_mail($to,$assunto,$message){
        $mail = new PHPMailer;

        $mail->isMAIL();
        $mail->Host = 'smtp.zoho.com';  // Specify main and backup SMTP servers
        $mail->Port=587;
	    $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'seu usuario';                // SMTP username
        $mail->Password = 'sua senha senha';                          // SMTP password
        $mail->SMTPSecure = 'tsl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->CharSet = 'UTF-8';

        $mail->From = 'suporte@upfinancas.com.br';
        $mail->FromName = 'Suporte Up Finanças';
        $mail->addAddress($to);     // Add a recipient
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $assunto;
        $mail->Body    = $message;

        if(!$mail->send()) {
          echo 'Message could not be sent.';
          echo 'Mailer Error: ' . $mail->ErrorInfo;
          exit;
        }

    }   


    









