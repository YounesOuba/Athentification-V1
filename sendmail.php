<?php
 require 'config.php';
 $receiver = "receiver_email_address_here";

 $subject = "Email Test via PHP using Localhost";

 $body = "Hi, there... This is a test email send from Localhost.";

 $sender = "From: younes123ouba@gmail.com";



//php function to send mail

 if(mail($receiver, $subject, $body, $sender)) {

 echo "Email sent successfully to $receiver";

 }else{

 echo "Sorry, failed while sending mail!";

 }

?>