<?php
   $to = "jofel1993@gmail.com"; // <– replace with your address here
   $subject = "test mail";
   $message = "this is a body message";
   $from = "sales@thesentinelautomation.com";
   $headers = "From: " . $from;
   mail($to,$subject,$message,$headers);
   echo "Mail Sent.";
?>