<?php
class Userinfo extends Model {
 	
	private $tableName;
	private $model;
	
	public function __construct() {
	    $this->model     = new Model();	
	    $this->tableName = PREFIX.'userinfo';	
	}
	public function getsyncuserprocess()
	{
	  	$condition = new QueryGroup();   
        $responseDetails = $this->model->show_records(array("*"),$this->tableName, $condition);
        return $responseDetails;
	}
	
	public function get_userinfo_model($UserID)
	{
	  	$condition = new QueryGroup();   
	  	//$condition->and_query(new QueryField("status","=",1)); 
        $condition->and_query(new QueryField("userid","=",$UserID));

        $responseDetails = $this->model->show_records(array("firstname","username","password","lastname","userlevel","status"),$this->tableName, $condition);

        return $responseDetails;
	}
	public function get_userinfo_exist($Username)
	{
	  	$condition = new QueryGroup();   
	  	//$condition->and_query(new QueryField("status","=",1)); 
        $condition->and_query(new QueryField("username","=",$Username));

        $responseDetails = $this->model->show_records(array("firstname","username","password","lastname","userlevel","status"),$this->tableName, $condition);

        return $responseDetails;
	}
	public function userinfo_details_model()
	{
	  	$condition = new QueryGroup();   
	  	//$condition->and_query(new QueryField("status","=",1)); 
	  	//$condition->and_query(new QueryField("userlevel","!=",1)); 
        $responseDetails = $this->model->show_records(array("userid","last_pc","loginstatus","username","firstname","lastname","userlevel","status","logindate"),$this->tableName, $condition);

        return $responseDetails;
	}

	public function get_userverification_model($Username,$Password)
	{
	  	$condition = new QueryGroup();   
	  	$condition->and_query(new QueryField("username","=",$Username)); 
        $condition->and_query(new QueryField("password","=",$Password));

        $responseDetails = $this->model->show_records(array("userid","firstname","lastname","userlevel"),$this->tableName, $condition);

        return $responseDetails;
	}

	public function getuserbycard_model($cardserial)
	{
	  	$condition = new QueryGroup();   
	  	$condition->and_query(new QueryField("cardserial","=",$cardserial)); 
        $condition->and_query(new QueryField("userlevel","=", "4"));

        $responseDetails = $this->model->show_records(array("userid","firstname","lastname","userlevel"),$this->tableName, $condition);

        return $responseDetails;
	}


    public function add_userinfo_model($list=array()) {
        $insertrates = $this->insert($this->tableName,$list);
        return $insertrates;
    }

    public function delete_userinfo_model($userid) {

        $DeleteUser = $this->delete($this->tableName,new QueryField("userid","=",$userid));

        //$insertrates = $this->insert($this->tableName,$list);
        return $DeleteUser;
    }


    public function replace_userinfo_model($list=array()) {
        $insertrates = $this->replace($this->tableName,$list);
        return $insertrates;
    }

	public function update_userinfo_model($userid,$list=array()) {
        $this->update($this->tableName,$list, new QueryField("userid","=",$userid));      
    }

}
?>
