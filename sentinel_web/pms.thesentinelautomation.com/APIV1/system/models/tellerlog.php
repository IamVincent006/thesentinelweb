<?php
class Tellerlog extends Model {

 	private $tableName;
	private $model;

	public function __construct() {
	    $this->model     = new Model();	
	    $this->tableName = PREFIX.'tellerlog';	
	    $this->userinfo = PREFIX.'userinfo';	
	}


    public function get_tellerlog_model($TerminalID) {


	  	$condition = new QueryGroup();   
	  	$condition->and_query(new QueryField("status","=",0)); 
        $condition->and_query(new QueryField("terminalid","=",$TerminalID));

        $responseDetails = $this->model->show_records(array("tellerid","tellerlogid","logindate",),$this->tableName, $condition);

        return $responseDetails;
    }  
    public function tellerlog_byterminal_model($terminal,$from_date,$to_date,$area) {


        $condition = new QueryGroup();

        if($area==0)
            $condition->and_query(new QueryField("terminalid","=",$terminal));
        else
            $condition->and_query(new QueryField($this->tableName.".loginarea_id","=",$area));

	  	//$condition->and_query(new QueryField($this->tableName.".status","=",1)); 
        $condition->and_query(new QueryField("$this->tableName.logindate",">=",$from_date));
        $condition->and_query(new QueryField("$this->tableName.logindate","<=",$to_date));


        $select = new Select();


        $select->add_fields(array("
            startcash,
            tellerid,
            firstname,
            lastname,
            terminalid,
            $this->tableName.logindate,
            $this->tableName.logoutdate
           

        "));

        $select->set_table_name($this->tableName);
        $select->add_join(new Join($this->userinfo, new QueryField($this->tableName.".tellerid", "=", $this->userinfo.".userid"),"LEFT"));

        $select->add_sort("logindate ASC");
        $select->set_condition($condition);
      //  $select->add_group("pdate");
        $responseDetails =  $this->select($select);



        return $responseDetails;
    } 

    public function tellerlog_byteller_model($tellerid,$from_date,$to_date) {



        $condition = new QueryGroup();


        
         
        $condition->and_query(new QueryField("tellerid","=",$tellerid));
        //$condition->and_query(new QueryField($this->tableName.".status","=",1)); 
        $condition->and_query(new QueryField("$this->tableName.logindate",">=",$from_date));
        $condition->and_query(new QueryField("$this->tableName.logindate","<=",$to_date));


        $select = new Select();
        $select->add_fields(array("
            sum(startcash) as startcash,
            tellerid,
            firstname,
            lastname,
            terminalid,
            min($this->tableName.logindate) logindate,
            max($this->tableName.logoutdate) logoutdate,
            SUM(IF($this->tableName.status='0', 1, 0)) as logincount


        "));

        $select->set_table_name($this->tableName);
        $select->add_join(new Join($this->userinfo, new QueryField($this->tableName.".tellerid", "=", $this->userinfo.".userid"),"LEFT"));
        $select->set_condition($condition);
        $responseDetails =  $this->select($select);



        return $responseDetails;
    } 

    public function update_tellerlog_model($TellerLogID,$list=array())
    {
    	$condition = new QueryGroup();   
	  	$condition->and_query(new QueryField("status","=",0)); 
	  	$condition->and_query(new QueryField("tellerlogid","=",$TellerLogID));
	  	
    	$this->update($this->tableName,$list, $condition);
    }

    public function replace_tellerlog_model($list=array())
    {

        $ReplaceParkID = $this->replace($this->tableName,$list);
        return $ReplaceParkID;

    }

    public function insert_tellerlog_model($list=array())
    {

        $insertParkID = $this->insert($this->tableName,$list);
        return $insertParkID;

    }

    public function tellerlog_model1($datemodified){
        $condition = new QueryGroup(); 
        $condition->and_query(new QueryField("status","=",1)); 
        $condition->and_query(new QueryField("date_modified",">",$datemodified));    
        //$condition->and_query(new QueryField("cardserial","=",$cardserial));
        //$condition->and_query(new QueryField("card_status","=",1));  
        $responseDetails = $this->model->show_records(array("*"),$this->tableName, $condition,array("date_modified asc"),0,5);
        return $responseDetails;
    }

    public function lasttellerlog_model(){
        $condition = new QueryGroup(); 
        //$condition->and_query(new QueryField("dc_status","=",0));    
        $responseDetails = $this->model->show_records(array("*"),$this->tableName, $condition,array("date_modified desc"),0,1);
        return $responseDetails;
    }

    public function getsynctellerlogprocess() {

        $condition = new QueryGroup();   
        $condition->and_query(new QueryField("status","=",1)); 
        $ResponseDetails = $this->model->show_records(array("*"),$this->tableName, $condition);
        return $ResponseDetails; 

    }
    public function deletetellerlog($TellerLogID) {

        $DeleteParkID = $this->delete($this->tableName,new QueryField("tellerlogid","=",$TellerLogID));
        return $DeleteParkID;
    }

}
?>
