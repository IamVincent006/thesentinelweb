<?php
require 'phpmailer/class.phpmailer.php';

  		
         
    
            $mail = new PHPMailer(true); 

        	$mail->IsSMTP();                           
        	$mail->SMTPAuth   = false;                 
        	$mail->Port       = 25;                    
        	$mail->Host       = "localhost"; 
        	$mail->Username   = "sales@thesentinelautomation.com";   
        	$mail->Password   = "Sentinel@2020";            
        
        	$mail->IsSendmail();  
        

        
        	//$mail->From       = "sales@thesentinelautomation.com";
        	//$mail->FromName   = "thesentinelautomation.com";
            $mail->setFrom('sales@thesentinelautomation.com', 'Mailer');
        	$mail->AddAddress("jedrosolano.sentinel@outlook.ph");
            $mail->Subject  = "RFQ Proposal2";
            $mail->addReplyTo('sales@thesentinelautomation.com', 'Information');
        	$mail->WordWrap   = 80; 
        	

 
        
            $mail->MsgHTML("PLEASE SEE ATTACH");
        	$mail->IsHTML(true); 
                 
            if(!$mail->Send())
            {
                   echo "Mail Not Sent";
            }
            else
            {
               	echo '<script language="javascript">';
    	        echo 'alert("Thank You Contacting Us We Will Response You As Early Possible")';
    	        echo '</script>';
         
            } 

?>