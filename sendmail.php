<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

 
if(isset($_POST['submitContact'])){

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->SMTPAuth   = true;   

    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through                                //Enable SMTP authentication
    $mail->Username   = 'omondianthony02@gmail.com';                     //SMTP username
    $mail->Password   = 'hbblvoqqpizhwkkb';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('omondianthony02@gmail.com', 'Ochieng Anthony');
    $mail->addAddress($_POST['email'], 'Ochieng Anthony');     //Add a recipient
     

    //Attachments
    $mail->addAttachment($_FILES['file']['tmp_name'], $_FILES['file']['name']);         //Add attachments

//sendind multiple files
//for($i=0; $i<count($_FILES['file']['temp_name']), $i++){
   //$mail->addAttachment($_FILES['file']['temp_name'][], $_FILES['file']['name']);         //Add attachments
//}
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Hello? - Ochieng Anthony Contact Form';
    $mail->Body    = '<h3>Hello, you have a new Order</h3>
                <h4>Fullname: '.$fullname.'</h4>
                <h4>Email: '.$email.'</h4>
                 <h4>Subject: '.$subject.'</h4>
                <h4>Message: '.$message.'</h4>

';
    
if( $mail->send())
   {
$_SESSION['status'] = "Thank you for contacting us we'll be in touch in a few.";
header("location: {$_SERVER["HTTP_REFERER"]}");
exit(0);
   }
else{

$_SESSION['status'] = "Message could not be sent. Mail Error: {$mail->ErrorInfo}";
header("location: {$_SERVER["HTTP_REFERER"]}");
exit(0);

}

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

}
else{
header('location: index.php');
exit(0);
}

?>