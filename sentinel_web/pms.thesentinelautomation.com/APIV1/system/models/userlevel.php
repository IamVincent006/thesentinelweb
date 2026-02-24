<?php
class Userlevel extends Model {
 	
	private $tableName;
	private $model;
	
	public function __construct() {
	    $this->model     = new Model();	
	    $this->tableName = PREFIX.'userlevel';	
	}
	

	public function userlevel_details_model()
	{
	  	$condition = new QueryGroup();   
	  	//$condition->and_query(new QueryField("userlevel","!=",1)); 
        $responseDetails = $this->model->show_records(array("userlevel_id","userlevel_name"),$this->tableName, $condition);

        return $responseDetails;
	}



}
?>
