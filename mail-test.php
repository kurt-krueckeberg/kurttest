<?php
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "kkruecke@gmail.com";
$headers = "From:" . $from;
$rc = mail("kurt.krueckeberg@verizon.net",$subject,$message,$headers);
echo "Mail rc was = ". $rc ."\n";
?> 
