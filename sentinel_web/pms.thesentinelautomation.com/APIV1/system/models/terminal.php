<?php
class Terminal extends Model {

 	private $tableName;
	private $model;

	public function __construct() {
	    $this->model     	    = new Model();	
	    $this->tableName 	    = PREFIX.'terminal';
	    $this->tableNameKeyword = PREFIX.'keywords';	
	    $this->tbl_tellerlog	= PREFIX.'tellerlog';	
	}
	


	public function get_terminal_inout($propertyID) {

	    $condition = new QueryGroup();	
	    $condition->and_query(new QueryField("terminalStatus","=",0));
	    $condition->and_query(new QueryField("propertyID","=",$propertyID));
        

		$terminal = $this->model->show_records(array("sum(terminalIN) as TotalIN","sum(terminalOUT) as TotalOUT","sum(terminalTotal) as availTOTAL,sum(terminalAdjust) as TotalAdjust"),$this->tableName,$condition );



		return $terminal;
	}

	public function update_terminal_model($terminalID,$list=array()) {
	
		$this->update($this->tableName,$list, new QueryField("termID","=",$terminalID));
	}







	public function edit_terminals($terminalCode,$list=array()) {
	
		$this->update($this->tableName,$list, new QueryField("terminalCode","=",$terminalCode));
	
	}

	public function get_terminals_model() {
	    $condition = new QueryGroup();	
	    $condition->and_query(new QueryField("termstatus","=",1));	

         $terminalDetails = $this->model->show_records(array("termID","docnum","termIP","termname","area_code","termtype","termarea","termcnt","termreceipt","termparkid","termtellercnt","termtellerlogID"),$this->tableName, $condition);
	    return $terminalDetails;		
	}


	public function get_config_model($terminalID) {
	    $condition = new QueryGroup();	
	    $condition->and_query(new QueryField("termstatus","=",1));
	    $condition->and_query(new QueryField("termID","=",$terminalID));		

         $terminalDetails = $this->model->show_records(array("termname","area_code","termtype","termarea","termcnt","termtellercnt","docnum"),$this->tableName, $condition);
	    return $terminalDetails;		
	}

	public function get_terminal_details_model($terminalID) {
	    $condition = new QueryGroup();	
	    $condition->and_query(new QueryField("termstatus","=",1));
	    $condition->and_query(new QueryField("termID","=",$terminalID));		

         $terminalDetails = $this->model->show_records(array("termname","area_code","docnum","termtype","termarea","termIP","termcnt","termtellercnt","termstatus","termreceipt","termparkid","termtellerlogID","termidcnt","termvoid","termrefund","dateendshift"),$this->tableName, $condition);
	    return $terminalDetails;		
	}

	public function autopay_getlogindetails_model() {
	    /*$condition = new QueryGroup();	
	    $condition->and_query(new QueryField("termstatus","=",1));
	    $condition->and_query(new QueryField("termtype","=","AUTOPAY"));
        $terminalDetails = $this->model->show_records(array("termID"),$this->tableName, $condition);*/

        $condition = new QueryGroup();

        $condition->and_query(new QueryField($this->tableName.".termstatus","=",1));
        $condition->and_query(new QueryField($this->tableName.".termtype","=","AUTOPAY"));
        $condition->and_query(new QueryField($this->tbl_tellerlog.".status","=",0));


        $select = new Select();
        $select->add_fields(array("
        			tellerlogid,
        			terminalid,
        			termname,
                    logindate,
                    logoutdate

                 "));

        $select->set_table_name($this->tableName);
        $select->add_join(new Join($this->tbl_tellerlog, new QueryField($this->tableName.".termID", "=", $this->tbl_tellerlog.".terminalid"),"RIGHT"));
        $select->set_condition($condition);
        $terminalDetails =   $this->select($select);

   
	    return $terminalDetails;		
	}



	public function insert_terminals($list=array()) {

        $terminal = $this->insert($this->tableName,$list);
        return $terminal;		
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



	



}
?>
