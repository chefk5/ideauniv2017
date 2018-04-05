<?php
require_once('PHPMailer/PHPMailerAutoload.php');

class Mail {
        public static function sendMail($subject, $body, $address) {
                $mail = new PHPMailer();
               // $mail->isSMTP();
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'tsl';
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = '25';
                $mail->isHTML();
                $mail->SMTPDebug  = 1;
                $mail->Username = 'idea.universe1@gmail.com';
                $mail->Password = 'khaledisowner';
                $mail->SetFrom('idea.usssniverse1@gmail.com');
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->AddAddress($address);
echo "stringmmmm";
                

                if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
 } else {
    echo "Message has been sent";
 }
        }
}
?>
