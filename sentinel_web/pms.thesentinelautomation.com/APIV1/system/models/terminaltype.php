<?php
class Terminaltype extends Model {
 	
	private $tableName;
	private $model;
	
	public function __construct() {
	    $this->model     = new Model();	
	    $this->tableName = PREFIX.'terminaltype';	
	}

	public function get_terminal_type($terminalTypeID) {

	    $condition = new QueryGroup();	
	   // $condition->and_query(new QueryField("terminalStatus","=",0));
	    $condition->and_query(new QueryField("terminalTypeID","=",$terminalTypeID));		

         $terminalDetails = $this->model->show_records(array("terminalTypeName","terminalTypeCode"),$this->tableName, $condition);
          
	    return $terminalDetails;		
	}


}
?>
