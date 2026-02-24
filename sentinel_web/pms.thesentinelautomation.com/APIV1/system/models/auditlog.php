<?php
class Auditlog extends Model {
 	
	private $tableName;
	private $model;
	
	public function __construct() {
	    $this->model     = new Model();	
	    $this->tableName = PREFIX.'auditlog';	
	}
	

    public function insert_auditlog_model($list=array()) {
        $insertParkID = $this->insert($this->tableName,$list);
        return $insertParkID;
    }

    public function auditlog_details_model($list=array()) {
        
    	$condition = new QueryGroup();   
        $terminalDetails = $this->model->show_records(array("
            CONVERT_TZ(date,'+05:00','+08:00') as date,
            function,
            description,
            ip,pcname,
            user_id"),$this->tableName, $condition);

        return $terminalDetails;

    }



}
?>
