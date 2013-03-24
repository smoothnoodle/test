<?php
echo "email testing";
echo "</br>";
$to="kevin.heaven@eyepoppy.com";
$subject="Confirmation for wuuker.com";
$message='<html><head><title>HTML email</title></head><body><p>This email contains HTML Tags!</p></body></html>';
$email="confirmation@wuuker.com";
$headers='From:'.$email;

mail($to,$subject,$message,$headers);
echo $sent ? "Mail Sent" : "mail Failed";

?>