<?php
class Slot extends Model {
 	
	private $tableName;
	private $model;
	
	public function __construct() {
	    $this->model     = new Model();	
	    $this->tableName = PREFIX.'slots';	
	}
	

	public function get_slot_details() {
	    $condition = new QueryGroup();	
	    //$condition->and_query(new QueryField("termstatus","=",1));	
        $slotdetails = $this->model->show_records(array("floor","description"),$this->tableName, $condition);
	    
	    return $slotdetails;		
	}


}
?>
