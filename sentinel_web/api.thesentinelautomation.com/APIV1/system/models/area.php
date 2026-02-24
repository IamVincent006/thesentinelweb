<?php
class Area extends Model {
 	
	private $tableName;
	private $model;
	
	public function __construct() {
	    $this->model     = new Model();	
	    $this->tableName = PREFIX.'area';	
	}
	

	public function area_details_model()
	{
	  	$condition = new QueryGroup();   
	  	//$condition->and_query(new QueryField("userlevel","!=",1)); 
        $responseDetails = $this->model->show_records(array("area_id","area_name","area_code","payment_gracehour","payment_graceminute","entry_gracehour","entry_graceminute","cutoffhour","cutoffminute"),$this->tableName, $condition);

        return $responseDetails;
	}
	public function get_area_details($areaID) {
		$condition = new QueryGroup();
		$condition->and_query(new QueryField("area_id","=",$areaID));
		
		
		$addarea = $this->model->show_records(array("area_id","area_name","area_code","payment_gracehour","payment_graceminute","entry_gracehour","entry_graceminute","cutoffhour","cutoffminute","pgsip","pgsusername","pgspassword"),$this->tableName, $condition);

		return $addarea;
	}

	public function update_area_model($AreaID,$list=array()) {
        $this->update($this->tableName,$list, new QueryField("area_id","=",$AreaID));      
    }

    public function add_area_model($list=array()) {
        $insertarea = $this->insert($this->tableName,$list);
        return $insertarea;
    }


}
?>
