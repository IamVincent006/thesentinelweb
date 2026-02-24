<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function

require_once ("db.php");

$sql = "SELECT * from email_details where id = 2";
$result = $conn->query($sql);

$row = mysqli_fetch_array($result);
$conn->close();



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
$myObj = new \stdClass();



if(!isset($_POST['g-recaptcha-response']) || $_POST['g-recaptcha-response'] == ''){
        
        $myObj->message = "Recaptcha Not Verified";
        $myObj->status = 0;

}   
else
{
    try {	

     
        /*$fullname = "bon alicto";
        $mobile = "09273904513";
        $email = "jofel1993@gmail.com";
        $product = "SpeedStile FL's BA 1800";*/
    	

        $product = $_POST['product'];
        $fullname = $_POST['fullname'];
    	$mobile = $_POST['mobile'];
    	$email = $_POST['email'];



        $usermessage = $product . "<br/><br/>";
        $usermessage .= "Mobile Number:" . $mobile . "<br/>";
        


        $adminmessage = "Dear Mam/Sir $fullname,<br/><br/>";
        $adminmessage .= $row['message'];


    	
    	



    	//Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
        $mail->isSMTP();                                            
        $mail->Host       = 'localhost';                     
        $mail->SMTPAuth   = false;                                  
        $mail->Username   = $row['email'];                    
        $mail->Password   = $row['password'];                              
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
        $mail->SMTPAutoTLS = false;
        $mail->SMTPSecure = false;
        $mail->Port       = 25;                                  


        //Recipients
        $mail->setFrom($row['email'], $row['username']);
        $mail->addAddress($row['adminaddress']);     //Add a recipient
        $mail->addReplyTo($email,$fullname);

        foreach(explode(",", $row['cc']) as $ccmail): 

    	   $mail->addCC($ccmail);


        endforeach;    

        //Attachments
       // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
       // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject  = $row['subject'];
        $mail->Body    = $usermessage;
    			
    	$mail->send();		
    //////////////////////////////////////////////////////////////////////////////////////////////////////    
        // Remove previous recipients
        $mail->ClearAllRecipients();
        $mail->clearReplyTos();
        
        //Recipients
        $mail->setFrom($row['email'], $row['username']);
        $mail->addAddress($email);     //Add a recipient
        $mail->addReplyTo($row['replyto'],$row['username']);
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject  = $row['subject'];
        $mail->Body     = $adminmessage;
        $mail->Send();

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    				
    	$myObj->message = "Inquiry Success";
    	$myObj->status = 1;




    	
    } catch (Exception $e) {
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    	$myObj->status = 0;
    	$myObj->message = "email service error : {$mail->ErrorInfo}";
    }
}

$myJSON = json_encode($myObj);
echo $myJSON;

?>