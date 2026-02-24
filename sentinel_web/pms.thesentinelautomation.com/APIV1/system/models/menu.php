<?php
class Menu extends Model {
 	
	private $tableName;
	private $model;
	
	public function __construct() {
	    $this->model     = new Model();	
	    $this->tableName = PREFIX.'menu';	
	}
	

	public function menu_details_model()
	{
	  	$condition = new QueryGroup();   
	  	//$condition->and_query(new QueryField("userlevel","!=",1)); 
        $responseDetails = $this->model->show_records(array("*"),$this->tableName, $condition,array("sort ASC"));

        return $responseDetails;
	}



}
?>
