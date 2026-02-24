<?php
class Property extends Model {
 	
	private $tableName;
	private $model;
	
	public function __construct() {
	    $this->model     = new Model();	
	    $this->tableName = PREFIX.'property';	
	}

	public function get_property_details($propertyID) {
	    $condition = new QueryGroup();	
	    $condition->and_query(new QueryField("propertyStatus","=",0));
	    $condition->and_query(new QueryField("propertyID","=",$propertyID));		

            $propertyDetails = $this->model->show_records(array("propertyID","propertyName"),$this->tableName, $condition);
	    return $propertyDetails[0]['propertyName'];		
	}

}
?>
