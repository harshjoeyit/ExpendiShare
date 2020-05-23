<?php
    // require './credential.php';
    require 'phpmailer/PHPMailerAutoload.php';
    

    function sendmail($email, $msg) {
        $result = [];
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';

        $mail->Username = '';
        $mail->Password = '';

        $mail->setFrom('amantibrewal310@gmail.com', 'ExpendiShare');
        $mail->addAddress($email);
        $mail->addReplyTo('amantibrewal310@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = 'Confirm your email';
        $mail->Body = $msg;
        if($mail->send()) {
            $result['status'] = 1;
            $result['msg'] = "Congratulation!, You are know memeber of ExpensiShare.Please verify your email";
        }
        else {
            $result['status'] = 0;
            $result['msg'] = "Message is not sent";
            $result['error-msg'] = 'Mailer Error:' . $mail->ErrorInfo;
        }
        return $result;
    }

    
?>