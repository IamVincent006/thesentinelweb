<?php
class Parkinfo extends Model {
    
    private $tableName;
    private $model;
    
    public function __construct() {
        $this->model     = new Model();
        $this->tableName = PREFIX.'parkinfo';
    $this->tableNameTerminals = PREFIX.'terminals';
    $this->tableNameProperty = PREFIX.'property';
    }
    
    public function insert_parkinfo($list=array()) {
        $insertParkID = $this->insert($this->tableName,$list);
        return $insertParkID;
    }
    
    public function update_parkinfo($parkID,$exitlogid,$exitdate,$process) {
        $condition = new QueryField("parkID","=",$parkID);

        $list  = array(
            'exitdate' => $exitdate,
            'exitlogid' => $exitlogid,
            'process' => $process
         );

        $this->update($this->tableName,$list, $condition);  
    }

     public function get_parkinfo_entryRecord($entrylogid,$userID,$entryDate,$process,$parkID) {
        $condition = new QueryGroup();    
        $condition->and_query(new QueryField("entrylogid","=",$entrylogid));
        $condition->and_query(new QueryField("userID","=",$userID));
        $condition->and_query(new QueryField("entryDate","=",$entryDate));
        $condition->and_query(new QueryField("process","=",$process));  
        $condition->and_query(new QueryField("parkID","=",$parkID));

        $responseDetails = $this->model->show_records(array("parkID"),$this->tableName, $condition);

        if(empty($responseDetails)) {

             $responseValue =   "";     

        } else {
            foreach($responseDetails as $response) {
                $responseValue =   $response['parkID'];
          }

          return $responseValue;
        }
    }  

    public function get_parkinfo_exitRecord($parkID,$userID,$exitlogid,$exitdate,$process) {
        $condition = new QueryGroup();    
        $condition->and_query(new QueryField("parkID","=",$parkID));
        $condition->and_query(new QueryField("userID","=",$userID));
        $condition->and_query(new QueryField("exitlogid","=",$exitlogid));
        $condition->and_query(new QueryField("exitdate","=",$exitdate));
        $condition->and_query(new QueryField("process","=",$process));    

        $responseDetails = $this->model->show_records(array("parkID"),$this->tableName, $condition);

        if(empty($responseDetails)) {

             $responseValue =   "";     

        } else {
            foreach($responseDetails as $response) {
                $responseValue =   $response['parkID'];
          }

          return $responseValue;
        }
    }  

    public function get_parkinfo_details($parkinfoID) {
        
        $condition = new QueryGroup();
        $condition->and_query(new QueryField("parkID","=",$parkinfoID));   
        $condition->and_query(new QueryField("process","=",0));     

            $parkinfoDetails = $this->model->show_records(array("parkID","userID","plateNum","rateType","entryDate","entryLogid","userID"),$this->tableName, $condition);
        return $parkinfoDetails;        
    }


    public function check_parkinfo_details($parkinfoID) {
        
        $condition = new QueryGroup();
        $condition->and_query(new QueryField("parkID","=",$parkinfoID));
        $condition->and_query(new QueryField("process",'=',0));     

            $parkinfoDetails = $this->model->show_records(array("parkID","userID","plateNum","rateType","entryDate","entryLogid"),$this->tableName, $condition);
        return $parkinfoDetails;        
    }


    public function is_parkinfo_entry($parkinfoID) {
        
        $condition = new QueryGroup();
        $condition->and_query(new QueryField("parkID","=",$parkinfoID));      

            $parkinfoDetails = $this->model->show_records(array("process"),$this->tableName, $condition);


        $status = "notEntered";

        if($parkinfoDetails[0]['process'] == 0){
            $status = "entered";
        }else if($parkinfoDetails[0]['process'] == 2){
            $status = "exited";
        }

        return $status;     
    }

    public function update_parkinfo_payment($parkID, $list=array()) {
        $condition = new QueryGroup();
        $condition->and_query(new QueryField("parkID","=",$parkID));
        
        $this->update($this->tableName, $list, $condition);   
    }

    public function get_parkinfo_process($parkinfoID) {
        
        $condition = new QueryGroup();
        $condition->and_query(new QueryField("parkID","=",$parkinfoID));

            $parkinfoDetails = $this->model->show_records(array("parkID","process"),$this->tableName, $condition);
        return $parkinfoDetails;        
    }


    public function get_payment_list($userID){

        $condition = new QueryGroup();
        
        $condition->and_query(new QueryField($this->tableName.".userID","=",$userID));
        //$condition->and_query(new QueryField($this->tableName.".transRemarks","=","Check In"));
        //$condition->and_query(new QueryField($this->tableName.".transStatus","=",0));     
            
        $select = new Select();
        $select->add_fields(array("
                 $this->tableName.parkID,
                 $this->tableNameTerminals.terminalName,
                 $this->tableNameProperty.propertyName,
                 $this->tableName.userID,
                 $this->tableName.plateNum,
                 $this->tableName.entryLogid,
                 $this->tableName.paymentDate,
                 $this->tableName.amount,
                 $this->tableName.duration,
                 $this->tableName.remarks,
                 $this->tableName.process   
                 "
                 ));
        $select->set_table_name($this->tableName);
        $select->add_join(new Join($this->tableNameTerminals, new QueryField($this->tableName.".entryLogid", "=", $this->tableNameTerminals.".terminalID"),"LEFT"));
        $select->add_join(new Join($this->tableNameProperty, new QueryField($this->tableNameTerminals.".propertyID", "=", $this->tableNameProperty.".propertyID"),"LEFT"));
        $select->add_sort("parkID DESC");
        $select->set_condition($condition);

        $checkTransList =   $this->select($select);

        return $checkTransList;

    }


    public function get_parkinfo_payment_details($parkinfoID) {
        
        $condition = new QueryGroup();
        $condition->and_query(new QueryField("parkID","=",$parkinfoID));

            $parkinfoDetails = $this->model->show_records(array("paymentDate","process"),$this->tableName, $condition);
        return $parkinfoDetails;        
    }

    public function send_email($parkinfo_details){

        $park_data = $parkinfo_details;
        $fullname = $park_data['fullname'];
        $txn_code = $park_data['txn_code'];
        $property = $park_data['property'];
        $terminal = $park_data['terminal'];
        $entryDate = $park_data['entryDate'];
        $paymentTime = $park_data['paymentTime'];
        $initialCharge = $park_data['initialCharge'];
        $succCharge = $park_data['succCharge'];
        $total = $park_data['total'];
        $email = $park_data['email'];


        $message = '<!DOCTYPE html>
<html>
<head>
    <title>Your iPark Receipt</title>
</head>

<style type="text/css">
    
    *{
        font-family: Helvetica,"Arial",sans-serif;
    }


</style>

<body style="
        border: 1px solid #cecfe0;
        width: 50%;
        height: 100%;">

    <div class="head" style="padding-left: 50px;
        padding-right: 50px;
        padding: top: 30px;
        padding-bottom: 10px;
        background-color: white;
        "
        >
        <img src="cid:logo_2u" style="height: 40px; width: 110px; padding-left: 10px; padding-top: 10px;">
        <div class="row" style="display: flex;">
            <div class="column" style="float: left;
        width: 50%;
        padding:5px;
        min-height: 5px;">
                <label style="font-weight: bold;">TOTAL:</label><br>
                <label class="green-font font-head-total" style="
                color: #14b9e6;
                font-size: 30px;
                line-height: 24px;
                font-weight: bold;
                line-height: 26px;
                text-align: left;   ">P '.$total.'</label>
            </div>
            <div class="column" style="float: left;
        width: 50%;
        padding:5px;
        min-height: 5px;">
                <label style="font-weight: bold;">DATE | TIME</label><br>
                <label>Payment Time:</label><label class="green-font" style="color: #14b9e6;font-weight: bold;">'.date('F d, Y H:i:s',strtotime($paymentTime)).'</label>
            </div>
            
        </div>
    </div>

    <div class="container row" style="display: flex; padding-top: 10px; background-color: #f3f4f5;
        width: 100%;
        height: 100%;">
            <div class="column" style="padding-left: 50px; float: left;
        width: 50%;
        padding:5px;
        min-height: 5px;">
                <label class=" green-font font-body" style="
                color: #14b9e6;
                font-size: 20px;
                line-height: 24px;
                font-weight: bold;
                line-height: 26px;
                text-align: left;">Parking Details</label>
                <div>
                    
                    <div class="detail-font" style="padding: 5px;">
                    <label class="gray-font" style="color: #cecfe0;">Vehicle Type:</label><br>
                    <label>Car</label><br>
                    </div>
                    
                    <div class="detail-font" style="padding: 5px;">
                    <label class="gray-font" style="color: #cecfe0;">Issued By:</label><br>
                    <label>'.$property.'</label><br>
                    </div>
                    
                    <div class="detail-font" style="padding: 5px;">
                    <label class="gray-font" style="color: #cecfe0;">Issued To:</label><br>
                    <label>'.$fullname.'</label><br>
                    </div>

                    <div class="detail-font" style="padding: 5px;">
                    <label class="gray-font" style="color: #cecfe0;">Transaction Code:</label><br>
                    <label>'.$txn_code.'</label><br>
                    </div>

                    <div class="detail-font" style="padding: 5px;">
                    <label class="gray-font" style="color: #cecfe0;">Entry Terminal</label><br>
                    <label>'.$terminal.'</label><br>
                    </div>

                    <div class="detail-font" style="padding: 5px;">
                    <label class="gray-font" style="color: #cecfe0;">Entry Date|Time</label><br>
                    <label>'.$entryDate.'</label><br>
                    </div>

                </div>
            </div>
            <div class="column" style="float: left;
        width: 50%;
        padding:5px;
        min-height: 5px;">
                <label class=" green-font font-body" style="color: #14b9e6;
        font-size: 20px;
        line-height: 24px;
        font-weight: bold;
        line-height: 26px;
        text-align: left;">Receipt Summary</label><br><br>
                <div class="small-box" style="padding: 20px 20px 20px 20px;
                    border: 1px solid #cecfe0;
                    background-color: white;
                    width: 85%;
                    min-height: 50px;">
                    <label>Payment Method:</label><br>
                    <label style="font-weight: bold;">iPark Credits</label><br><br>
                    <div class="row" style="display: flex; border-style: dashed none none none; border-color: #cecfe0;">
                        <div class="column" style="float: left;
                        width: 50%;
                        padding:5px;
                        min-height: 5px;">
                            <label class="gray-font" style="color: #cecfe0;">Description</label>
                        </div>
                        <div class="column" style="
                        float: left;
                        width: 50%;
                        padding:5px;
                        min-height: 5px;
                                        ">
                            <label class="gray-font" style="color: #cecfe0;">Amount</label>
                        </div>
                    </div>
                    <div class="row" style="display: flex; border-style: dashed none dashed none;  border-color: #cecfe0;">
                        <div class="column"
                        style="
                        float: left;
                        width: 50%;
                        padding:5px;
                        min-height: 5px;">
                            <label class="small-font" style="font-size: 12px;">Initial Charge:</label><br>
                            <label class="small-font" style="font-size: 12px;">Succeeding Charge:</label><br>
                            <label class="small-font" style="font-size: 12px;">Overnight Charge:</label><br>
                        </div>
                        <div class="column" style="align-content: right;
                        float: left;
        width: 50%;
        padding:5px;
        min-height: 5px;">
                            <label class="small-font" style="font-size: 12px;">P '.$initialCharge.'</label><br>
                            <label class="small-font" style="font-size: 12px;">P '.number_format($succCharge,2).'</label><br>
                            <label class="small-font" style="font-size: 12px;">P 0.00</label><br>
                        </div>
                    </div>
                    <div class="row" style="display: flex;">
                        <div class="column" style="float: left;
        width: 50%;
        padding:5px;
        min-height: 5px;">
                        </div>
                        <div class="column" style="align-content: right;float: left;
        width: 50%;
        padding:5px;
        min-height: 5px;">
                            <label class="small-font" style="font-weight: bold; font-size: 12px;">TOTAL</label>
                            <label class="small-font" style="font-weight: bold; font-size: 12px;">P '.$total.'</label>
                            
                        </div>
                    </div>
                </div>
            </div>
    </div>

</body>
</html>';

    // echo $message;
    $mail = new PHPMailer();
    //Enable SMTP debugging. 
    // $mail->SMTPDebug = 3; 
    $mail->IsSMTP();
    $mail->Mailer = "smtp";
    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = "ssl";
    $mail->Port       = 465;
    $mail->Host       = "smtp.gmail.com";
    $mail->Username   = "znotsukaima@gmail.com";
    $mail->Password   = "mineskiwar1";
    $mail->IsHTML(true);
    $mail->AddAddress($email, $fullname);
    $mail->SetFrom("ipark.devs@gmail.com", "IPARK");
    $mail->AddEmbeddedImage('iparkname.png', 'logo_2u');
    $mail->Subject = "Your Parking Receipt"; 
    $mail->Body = $message; 

    if(!$mail->Send()) {
      // echo "Error while sending Email.";
      // var_dump($mail);
    } else {
      // echo "Email sent successfully";
    }

}

}
?>
