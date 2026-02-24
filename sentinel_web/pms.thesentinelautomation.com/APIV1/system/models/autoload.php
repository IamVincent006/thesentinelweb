<?php
class Autoload extends Model {
 	
	private $tableName;
	private $model;
	
	public function __construct() {
	    $this->model     = new Model();	
	    $this->tableName = PREFIX.'autoload';	
	}
	



    public function insert_autopay_model($list=array()) {
        $Autopay = $this->insert($this->tableName,$list);
        return $Autopay;
    }

    public function get_autopay_model($TellerLogID){
        $condition = new QueryGroup();    
        $condition->and_query(new QueryField("autopay_id","=",$TellerLogID));
        //$condition->and_query(new QueryField("card_status","=",1));  
        $responseDetails = $this->model->show_records(array('*'),$this->tableName, $condition);
        return $responseDetails;

    }
    public function getsyncautoloadprocess() {
        $condition = new QueryGroup();   

        $terminalDetails = $this->model->show_records(array("*"),$this->tableName, $condition);
        return $terminalDetails;        
    }
    public function deleteautopay($AutoID) {

        $DeleteParkID = $this->delete($this->tableName,new QueryField("autopay_id","=",$AutoID));
        return $DeleteParkID;
    }


}
?>
