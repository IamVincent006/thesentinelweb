<?php
class Voucher extends Model {
 	
	private $tableName;
	private $model;
	
	public function __construct() {
	    $this->model     = new Model();	
	    $this->tableName = PREFIX.'voucher';	
	}
	

    public function voucher_model(){
        $condition = new QueryGroup();    
        //$condition->and_query(new QueryField("cardserial","=",$cardserial));
        //$condition->and_query(new QueryField("card_status","=",1));  

        $responseDetails = $this->model->show_records(array('*'),$this->tableName, $condition);

        return $responseDetails;

    }

	public function voucher_details_model()
	{
	  	$condition = new QueryGroup();   
	  	$condition->and_query(new QueryField("dc_status","=",0)); 
        $responseDetails = $this->model->show_records(array("*"),$this->tableName, $condition);

        return $responseDetails;
	}
	public function get_voucher_details($dcid) {
		$condition = new QueryGroup();
		$condition->and_query(new QueryField("dc_id","=",$dcid));
		
		
		$addarea = $this->model->show_records(array("*"),$this->tableName, $condition);

		return $addarea;
	}
	public function get_voucher_detailsbycode($dccode) {
		$condition = new QueryGroup();
		$condition->and_query(new QueryField("dccode","=",$dccode));
		
		
		$addarea = $this->model->show_records(array("*"),$this->tableName, $condition);

		return $addarea;
	}

	public function update_voucher_model($dc_id,$list=array()) {
        $this->update($this->tableName,$list, new QueryField("dc_id","=",$dc_id));      
    }

    public function add_vocher_model($list=array()) {
        $insertarea = $this->insert($this->tableName,$list);
        return $insertarea;
    }
    public function replace_voucher_model($list=array()) {
        $insertrates = $this->replace($this->tableName,$list);
        return $insertrates;
    }


}
?>
