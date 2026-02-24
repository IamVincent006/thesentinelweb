<?php
class Transaction extends Model {
    
    private $tableName;
    private $model;
    
    public function __construct() {
        $this->model     = new Model();
        $this->tableName = PREFIX.'transaction';
	    $this->tableNameTerminals = PREFIX.'terminals';
        $this->tableTerminalLogs = PREFIX.'slotscount';
    }
    
    
    public function get_transaction_count_by_user($userID) {
        $transCountDetails = $this->model->show_records(array("MAX(transID) AS MaxTransCount"),$this->tableName, new QueryField("userID","=",$userID));
        
    	if(count($transCountDetails) > 0) {
    		$maxCount = $transCountDetails[0]['MaxTransCount'];
    	} else {
    		$maxCount = $transCountDetails[0]['MaxTransCount'] + 1;
    	}
    
    	return $maxCount;  
    }
    
    public function get_trans_latest_balance($userID) {
        $transBalanceDetails = $this->model->show_records(array("transCurrentBalance"),$this->tableName, new QueryField("userID","=",$userID),array("transID DESC"),0,1);
        return $transBalanceDetails[0]['transCurrentBalance'];
    }
    
    public function inserterminallogs($list=array()) {
        $insertTermLog = $this->insert($this->tableTerminalLogs,$list);
        return $insertTermLog;
    }


    public function insert_transaction($list=array()) {
        $insertTransID = $this->insert($this->tableName,$list);
        return $insertTransID;
    }
    
    public function update_transaction($userID, $transID, $list=array()) {
        $condition = new QueryGroup();
        $condition->and_query(new QueryField("userID","=",$userID));
        $condition->and_query(new QueryField("transID","=",$transID));
        $condition->and_query(new QueryField("transRemarks","=","Check In"));
        $condition->and_query(new QueryField("transStatus","=",0));
        
        $this->update($this->tableName, $list, $condition);   
    }
    
    public function get_check_in($userID) {
        $condition = new QueryGroup();
        //$condition->and_query(new QueryField("transID","=",$transID));
        $condition->and_query(new QueryField("userID","=",$userID));
        $condition->and_query(new QueryField("transRemarks","=","Check In"));
        $condition->and_query(new QueryField("transStatus","=",0));
        
        $getCheckIn = $this->model->show_records(array("transID, transPlateNo, terminalID, transQRImage, transDateTime, transNumberOfHours, transAmount"),$this->tableName, $condition,array("transID DESC"),0,1);
        return $getCheckIn;   
    }
    
    public function check_existing_transaction($userID) {
        $condition = new QueryGroup();
        $condition->and_query(new QueryField("userID","=",$userID));
        //$condition->and_query(new QueryField("DATE(transDateTime)","=",date('Y-m-d')));
        $condition->and_query(new QueryField("transRemarks","!=","Wallet Deposit"));
        $condition->and_query(new QueryField("transStatus","!=",3));
            
        $checkExists = $this->model->show_records(array("transID"),$this->tableName, $condition);
        
        return $checkExists;       
    }

    public function get_wallet_deposit() {

	$condition = new QueryGroup();
        $condition->and_query(new QueryField("userID","=",$userID));
        $condition->and_query(new QueryField("transRemarks","=","Wallet Deposit"));

        $checkWallet = $this->model->show_records(array("transRunningBalance"),$this->tableName, $condition,array("transID DESC"),0,1);

        return $checkWallet[0]['transRunningBalance'];

    }
    
    public function get_payment_list($userID) {
	  
	    $condition = new QueryGroup();
        
	    $condition->and_query(new QueryField($this->tableName.".userID","=",$userID));
	    //$condition->and_query(new QueryField($this->tableName.".transRemarks","=","Check In"));
	    //$condition->and_query(new QueryField($this->tableName.".transStatus","=",0)); 	
	    	
    	$select = new Select();
    	$select->add_fields(array("
				 $this->tableName.transID,
				 $this->tableNameTerminals.terminalName,
				 $this->tableName.userID,
			         $this->tableName.transPlateNo,
				 $this->tableName.terminalID,
				 $this->tableName.transDateTime,
				 $this->tableName.transQRImage,
				 $this->tableName.transNumberOfHours, 
				 $this->tableName.transAmount,
				 $this->tableName.transCurrentBalance,
				 $this->tableName.transRunningBalance,
				 $this->tableName.transRemarks,
				 $this->tableName.transStatus	
				 "
				 ));
    	$select->set_table_name($this->tableName);
    	$select->add_join(new Join($this->tableNameTerminals, new QueryField($this->tableName.".terminalID", "=", $this->tableNameTerminals.".terminalID"),"LEFT"));
        $select->add_sort("transID DESC");
    	$select->set_condition($condition);

    	$checkTransList	=	$this->select($select);

        return $checkTransList;

    }
    
   
}
?>
