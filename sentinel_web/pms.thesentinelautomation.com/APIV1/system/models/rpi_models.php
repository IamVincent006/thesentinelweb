<?php
class Rpi_models extends Model {

 	private $tableName;
	private $model;

	public function __construct() {
	    $this->model     	    = new Model();	
	    $this->tableName 	    = PREFIX.'terminals';
	    $this->tableNameKeyword = PREFIX.'keywords';	
	}
	
	public function get_terminal_map_geojson() {
		$terminals = $this->model->show_records(array("terminalID","rateID","geometryType","terminalName","pointLongitude","pointLatitude","polygonName","lotType", "terminalIN","terminalOUT","terminalAdjust","availableVehicles","terminalOpenHr","terminalCloseHr","terminalAvailable","terminalTotal"),$this->tableName, new QueryField("terminalStatus","=",0),array("terminalName ASC"));
		return $terminals;
	}

	public function get_terminal_inout($propertyID) {

	    $condition = new QueryGroup();	
	    $condition->and_query(new QueryField("terminalStatus","=",0));
	    $condition->and_query(new QueryField("propertyID","=",$propertyID));
        

		$terminals = $this->model->show_records(array("sum(terminalIN) as TotalIN","sum(terminalOUT) as TotalOUT","sum(terminalTotal) as availTOTAL","sum(terminalAdjust) as TotalAdjust","sum(terminalINMC) as TotalINMC","sum(terminalOUTMC) as TotalOUTMC","sum(terminalAdjustMC) as TotalAdjustMC"),$this->tableName,$condition );

		return $terminals;
	}

    

	public function UpdateTermCnt($terminalID,$list=array()) {
	
		$this->update($this->tableName,$list, new QueryField("terminalID","=",$terminalID));
	}

	public function edit_terminals($terminalCode,$list=array()) {
	
		$this->update($this->tableName,$list, new QueryField("terminalCode","=",$terminalCode));
	
	}


	public function get_terminal_details($terminalID) {
	    $condition = new QueryGroup();	
	    $condition->and_query(new QueryField("terminalStatus","=",0));
	    $condition->and_query(new QueryField("terminalID","=",$terminalID));		

         $terminalDetails = $this->model->show_records(array("terminalID","rateID","operatorID","propertyID","terminalName","terminalCode","terminalAvailable","terminalTotal","terminalDescription","terminalIN","terminalOUT","terminalINMC","terminalOUTMC","terminalAdjust","availableVehicles","terminalOpenHr","terminalCloseHr","terminalType"),$this->tableName, $condition);
	    return $terminalDetails;		
	}

	public function update_terminal_entry($terminalID,$transactionCount,$terminalINCount) {
		
		$condition = new QueryGroup();	
		$condition->and_query(new QueryField("terminalID","=",$terminalID));		
		$condition->and_query(new QueryField("terminalStatus","=",0));			

    $transactionCount = $transactionCount +1;
    $terminalINCount = $terminalINCount +1;

		$list  = array(
			'transactionCount' => $transactionCount,
			'terminalIN' => $terminalINCount
	);

		$this->update($this->tableName,$list, $condition);	

	}

	public function update_terminal_exit($terminalID,$terminalOutCount) {
		
		$condition = new QueryGroup();	
		$condition->and_query(new QueryField("terminalID","=",$terminalID));		
		$condition->and_query(new QueryField("terminalStatus","=",0));			

    $terminalOutCount = $terminalOutCount +1;

		$list  = array(
			'terminalOUT' => $terminalOutCount
	);

		$this->update($this->tableName,$list, $condition);	

	}


	public function sms_result($number,$command) {
	    	
	    if($number == "63") {

	    $messageArr      =  explode(",",$command);
	    $firstKey        =  trim(strtoupper($messageArr[0]));
	    $secondKey       =  trim($messageArr[1]);
	    $thirdKey        =  trim($messageArr[2]); 
	    $fourthKey       =  trim($messageArr[3]); 
		
	    $ptn 			 =  "/^63/"; 
	    $str 			 =  $number; 
	    $rpltxt 		         =  "0"; 
	    $phone 			 =  preg_replace ( $ptn, $rpltxt, $str );

	    $this->update_slots_sms($firstKey,$secondKey,$thirdKey,$fourthKey);
		
	    } else {

	    $messageArr      =  explode(" ",$command, 2);
	    $firstKey        =  trim(strtoupper($messageArr[0]));
	    $secondKey       =  trim(strtoupper($messageArr[1]));

	    $ptn 			 =  "/^63/"; 
	    $str 			 =  $number; 
	    $rpltxt 		         =  "0"; 
	    $phone 			 =  preg_replace ( $ptn, $rpltxt, $str );

		    if($this->check_keyword($firstKey) == 1 && $secondKey != '') {

			$messageString  =  $this->compose_message($secondKey); 

			$resultMessage  =  array(
						'status'   => 0,
						'phone'    => $number,
						'message'  => $messageString
						);

		    } else {

			$resultMessage  =  array(
						'status'   => 1,
						'phone'    => $number,
						'message'  => "Invalid format or not existing keyword."
						);

		    }

	    }

	    return $resultMessage;

	}

	private function check_keyword($keyword) {
	$condition = new QueryGroup();	
	$condition->and_query(new QueryField("keywordStatus","=",0));

	$keywordDetails = $this->model->show_records(array("keywordID","keyword"),$this->tableNameKeyword, $condition);

	if(count($keywordDetails) > 0) {
	$exists    =   1;	
	} else {
	$exists    =   0;
	}

	return $exists;
	}

	private function compose_message($property) {	
	$condition = new QueryGroup();	
	$condition->and_query(new QueryField("keyCode","=",$property));
	$condition->and_query(new QueryField("terminalStatus","=",0));	

	$terminalDetails = $this->model->show_records(array("terminalID","areaCode","keyCode","lotType","terminalName","terminalAvailable","terminalTotal","terminalDescription","terminalIN","terminalOUT","terminalAdjust","availableVehicles","terminalOpenHr","terminalCloseHr"),$this->tableName, $condition);

	if(empty($terminalDetails)) {

	     $messageString =   "There is no available slots on this area ".$property; 	

	} else {

		$terminalList = array();
		foreach($terminalDetails as $details) {
		
			$totalAvailable = $details['terminalTotal'] - (($details['terminalIN'] - $details['terminalOUT']) + $details['terminalAdjust']);
			
			if($totalAvailable > 0) {
				$totalAvailable = $totalAvailable;
			} else {
				$totalAvailable = 0;
			}	

			$terminalList[] = $details['terminalName']." => ".$totalAvailable."";
		    }

		    $messageString =   "The available slots for ".$property." are ".implode(",",$terminalList);
	  }  
	  return $messageString;
	}

	private function update_slots_sms($areaCode,$terminalCode,$type,$slotCount=0) {
		
		$condition = new QueryGroup();	
		$condition->and_query(new QueryField("terminalCode","=",$terminalCode));		
		$condition->and_query(new QueryField("areaCode","=",$areaCode));
		$condition->and_query(new QueryField("terminalStatus","=",0));			

		$list  = array('terminalTotal' => $slotCount);

		if($type == 'SLOT') {
		 
                    $this->update($this->tableName,$list, $condition);	
                      		
		} elseif($type == 'USLOT') {
		
		    $this->update($this->tableName,$list, $condition);	

		} else {
		
		}		

	}




	public function get_terminal_rateID($terminalID) {
	    $condition = new QueryGroup();	
	    $condition->and_query(new QueryField("terminalStatus","=",0));
	    $condition->and_query(new QueryField("terminalID","=",$terminalID));		

     $responseDetails = $this->model->show_records(array("rateID"),$this->tableName, $condition);

		if(empty($responseDetails)) {

		     $responseValue =   "No rateID found!"; 	

		} else {
			foreach($responseDetails as $response) {
			    $responseValue =   $response['rateID'];
		  }  
		  return $responseValue;
		}
	}

	public function get_terminal_terminalINCount($terminalID) {
	    $condition = new QueryGroup();	
	    $condition->and_query(new QueryField("terminalStatus","=",0));
	    $condition->and_query(new QueryField("terminalID","=",$terminalID));		

     $responseDetails = $this->model->show_records(array("terminalIN"),$this->tableName, $condition);

		if(empty($responseDetails)) {

		     $responseValue =   "No terminalIN found!"; 	

		} else {
			foreach($responseDetails as $response) {
			    $responseValue =   $response['terminalIN'];
		  }

		  return $responseValue;
		}
	}

	public function get_terminal_transactionCount($terminalID) {
	    $condition = new QueryGroup();	
	    $condition->and_query(new QueryField("terminalStatus","=",0));
	    $condition->and_query(new QueryField("terminalID","=",$terminalID));		

     $responseDetails = $this->model->show_records(array("transactionCount"),$this->tableName, $condition);

		if(empty($responseDetails)) {

		     $responseValue =   "No transactionCount found!"; 	

		} else {
			foreach($responseDetails as $response) {
			    $responseValue =   $response['transactionCount'];
		  }

		  return $responseValue;
		}
	}
	
  public function get_terminal_logid($terminalCode) {
        $condition = new QueryGroup();    
        $condition->and_query(new QueryField("terminalCode","=",$terminalCode));
        $condition->and_query(new QueryField("terminalStatus","=",0)); 

        $responseDetails = $this->model->show_records(array("terminalID"),$this->tableName, $condition);

        if(empty($responseDetails)) {

             $responseValue =   "";     

        } else {
            foreach($responseDetails as $response) {
                $responseValue =   $response['terminalID'];
          }

          return $responseValue;
        }
    }  

	public function get_terminal_terminalOutCount($terminalID) {
	    $condition = new QueryGroup();	
	    $condition->and_query(new QueryField("terminalStatus","=",0));
	    $condition->and_query(new QueryField("terminalID","=",$terminalID));		

     $responseDetails = $this->model->show_records(array("terminalOUT"),$this->tableName, $condition);

		if(empty($responseDetails)) {

		     $responseValue =   "No terminalOUT found!"; 	

		} else {
			foreach($responseDetails as $response) {
			    $responseValue =   $response['terminalOUT'];
		  }

		  return $responseValue;
		}
	}


}
?>
