<?php 

$name = $_POST["name"];
$email = $_POST["email"];
$subject = $_POST["subject"];
$message = $_POST["message"];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor\phpmailer\phpmailer\src/Exception.php';
require 'vendor\phpmailer\phpmailer\src/PHPMailer.php';
require 'vendor\phpmailer\phpmailer\src/SMTP.php';
require 'vendor\phpmailer\phpmailer\src/OAuth.php';
require 'vendor\phpmailer\phpmailer\src/POP3.php';

require 'vendor/autoload.php';

// require_once('class.phpmailer.php');

$mail = new PHPMailer();
$mail->SMTPDebug = 6;
$mail->IsSMTP();
$mail->CharSet="UTF-8";
$mail->SMTPSecure = 'tls';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->Username = 'SOME@MAIL.com';
$mail->Password = 'PASSWORD';
$mail->SMTPAuth = true;
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);

$mail->From = $email;
$mail->FromName = $name;
$mail->AddAddress("SOME@MAIL.com");
$mail->AddReplyTo($email, $subject);

$body = file_get_contents("inc/email_template.html");
$body = str_replace("{content}", file_get_contents("inc/content.html"), $body);
$body = str_replace("{name}", $name , $body);
$body = str_replace("{email}", $email , $body);
$body = str_replace("{subject}", $subject , $body);//this should insert email content into mail template

$mail->IsHTML(true);
$mail->Subject    = $subject;
$mail->AltBody    = "";
$mail->Body    = $body; //str_replace & file_get_contents da dodas i modifikujes
$mail->addEmbeddedImage("inc/img/mazo.jpg", "logo");
$mail->addEmbeddedImage("inc/img/fb.jpg", "fb");
$mail->addEmbeddedImage("inc/img/tw.jpg", "tw");
$mail->addEmbeddedImage("inc/img/goo.jpg", "goo");
$mail->Body = str_replace("{message}", $message , $body);

if(!$mail->Send())
{
  echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
  echo "Message sent!"; ?>
   <script type="text/javascript">
       window.location.replace("index.php"); </script>
   
   <?php  
}

?>