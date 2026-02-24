<?php
class Rate extends Model {

 	private $tableName;
	private $model;

	public function __construct() {
	    $this->model     = new Model();	
	    $this->tableName = PREFIX.'rate';	
	}
	
	public function get_rates($rateID) {
		$condition = new QueryGroup();
		$condition->and_query(new QueryField("rateStatus","=",0));
		$condition->and_query(new QueryField("rateID","=",$rateID));
		
		
		$rates = $this->model->show_records(array("rateInitial","rateDefaultHour","rateInitialDuration",
			"ratePerHour","rateOvernight","rateOvernightTime","rateLostCard"),$this->tableName, $condition);

		$defaultRate = $rates[0]['rateInitial'] + ($rates[0]['ratePerHour'] * ($rates[0]['rateDefaultHour'] - $rates[0]['rateInitialDuration']));

		return $defaultRate;
	}

	public function get_rates_details($rateID) {
		$condition = new QueryGroup();
		//$condition->and_query(new QueryField("rate_status","=",1));
		$condition->and_query(new QueryField("rate_id","=",$rateID));
		
		
		$rates = $this->model->show_records(array("*"),$this->tableName, $condition);

		return $rates;
	}

	public function get_ratecode_display($AreaID) {
		$condition = new QueryGroup();
		$condition->and_query(new QueryField("rate_status","=",1));
		$condition->and_query(new QueryField("area_id","=",$AreaID));
		
		$rates = $this->model->show_records(array("rate_code"),$this->tableName, $condition);

		return $rates;
	}

	public function get_rateids_display($RateCode) {
		$condition = new QueryGroup();
		$condition->and_query(new QueryField("rate_status","=",1));
		$condition->and_query(new QueryField("rate_code","=",$RateCode));
		
		$rates = $this->model->show_records(array("rate_code","rate_id","member_type"),$this->tableName, $condition);

		return $rates;
	}


    public function lastrate_model(){
        $condition = new QueryGroup(); 
        //$condition->and_query(new QueryField("dc_status","=",0));    
        $responseDetails = $this->model->show_records(array("*"),$this->tableName, $condition,array("date_modified desc"),0,1);
        return $responseDetails;
    }


	public function get_rates_model() {
		$condition = new QueryGroup();
		//$condition->and_query(new QueryField("rate_status","=",1));
		//$condition->order_by("rate_id", "asc");
		//$condition->and_query(new QueryField("date_modified",">",$datemodified));   
		$rates = $this->model->show_records(array("*"),$this->tableName, $condition,array("date_modified ASC"));

		return $rates;
	}

	public function get_rates_model1($datemodified) {
		$condition = new QueryGroup();
		//$condition->and_query(new QueryField("rate_status","=",1));
		//$condition->order_by("rate_id", "asc");
		$condition->and_query(new QueryField("date_modified",">",$datemodified));   
		$rates = $this->model->show_records(array("*"),$this->tableName, $condition,array("date_modified ASC"));

		return $rates;
	}

	public function update_rates_model($RateID,$list=array()) {
        $this->update($this->tableName,$list, new QueryField("rate_id","=",$RateID));      
    }
    public function add_rates_model($list=array()) {
        $insertrates = $this->insert($this->tableName,$list);
        return $insertrates;
    }
    public function replace_rates_model($list=array()) {
        $insertrates = $this->replace($this->tableName,$list);
        return $insertrates;
    }

}
?>
