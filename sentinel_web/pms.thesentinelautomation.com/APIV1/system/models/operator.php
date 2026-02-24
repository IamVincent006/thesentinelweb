<?php
class Operator extends Model {
 	
	private $tableName;
	private $model;
	
	public function __construct() {
	    $this->model     = new Model();	
	    $this->tableName = PREFIX.'operator';	
	}

	public function get_operator_details($operatorID) {
	    $condition = new QueryGroup();	
	    $condition->and_query(new QueryField("operatorStatus","=",0));
	    $condition->and_query(new QueryField("operatorID","=",$operatorID));		

        $operatorDetails = $this->model->show_records(array("operatorID","operatorName","operatorContact"),$this->tableName, $condition);
	    return $operatorDetails;		
	}

}
?>
