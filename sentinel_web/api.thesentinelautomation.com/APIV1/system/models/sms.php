<?php
/**
 * @desc For sms functionality
 * @param string $number
 * @param string $command
 */

class Sms extends Model {

 	private $tableName;
	private $model;

	public function __construct() {
		
	    $this->model     = new Model();	
	    $this->tableName 	    = PREFIX.'sms';
	    $this->tableNameKeyword = PREFIX.'keywords';
	    
	}

	public function sms_result($number,$command) {

			$messageArr      =  explode(" ",$command, 2);
			$firstKey        =  trim(strtoupper($messageArr[0]));
			$secondKey       =  trim($messageArr[1]);
		
			$ptn 			 =  "/^63/";
			$str 			 =  $number;
			$rpltxt 		 =  "0";
			$phone 			 =  preg_replace ( $ptn, $rpltxt, $str );
		
			if($this->check_keyword($firstKey) == 1) {
				
				if($this->insert_message($phone,$secondKey,$firstKey) > 0) {
			
					$resultMessage  =  array(
											'status'   => 0,
											'phone'    => $number,
											'message'  => $trailMessage
											);
			
				} else {
			
					$resultMessage  =  array(
											'status'   => 1,
											'phone'    => $number,
											'message'  => "Invalid format or not existing keyword."
											);
			
				}
				
			} else {
				
				$resultMessage  =  array(
										'status'   => 1,
										'phone'    => $number,
										'message'  => "Invalid format or not existing keyword."
										);
				
			}
			
			return $resultMessage;
		
		}
		
		/**
		 * @desc Check keyword if exists
		 * @param string $keyword
		 */
		private function check_keyword($keyword) {
			
			$condition = new QueryGroup();
			$condition->and_query(new QueryField("keywordStatus","=",0));
			$condition->and_query(new QueryField("keyword","=",$keyword));
			
			$keywordDetails = $this->model->show_records(array("keywordID","keyword","keywordStatus"),$this->tableNameKeyword, $condition);
			return $keywordDetails;
			
		}
		
		
		/**
		 * @desc Insert to messages table
		 * @param string $number
		 * @param string $message
		 * @param string $keyword
		 */
		private function insert_message($number,$message,$keyword) {
		
			$data['smsFrom']         =   "SYSTEM";
			$data['smsTo']			 =   $number;
			$data['smsBody']		 =   $message;
			$data['timeStamp']       =   date('Y-m-d H:i:s');
			$data['smsStatus']       =   "RECEIVED";
			$data['smsKeyword']      =   $keyword;
			
			$insertID = $this->insert($this->tableName, $data);
		
			return $insertID;
		
		}
		
		private function get_terminals_by_keyword($keyword) {
			
			$condition = new QueryGroup();
			$condition->and_query(new QueryField("terminalStatus","=",0));
			$condition->and_query(new QueryField("terminalID","=",$terminalID));
			
			$terminalDetails = $this->model->show_records(array("terminalID","rateID","operatorID","propertyID","terminalName","terminalAvailable","terminalTotal","terminalDescription","terminalIN","terminalOUT","terminalAdjust","availableVehicles","terminalOpenHr","terminalCloseHr"),$this->tableName, $condition);
			return $terminalDetails;
			
		}
}