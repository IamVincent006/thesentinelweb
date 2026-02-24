<?php
class Cardholder extends Model {

 	private $tableName;
	private $model;

	public function __construct() {
	    $this->model     = new Model();	
	    $this->tableName = PREFIX.'cardholder';	
	}


    public function get_cardholder_ifexist($cardserial,$platenum) {
        $condition = new QueryGroup();    
        $condition->and_query(new QueryField("cardserial","=",$cardserial));
        $condition->or_query(new QueryField("platenum","=",$platenum));

        $responseDetails = $this->model->show_records(array("ratetype","platenum","cardvalidity"),$this->tableName, $condition);

        return $responseDetails;
    }  
    public function card_holder_model(){
        $condition = new QueryGroup();    
        //$condition->and_query(new QueryField("cardserial","=",$cardserial));
        //$condition->and_query(new QueryField("card_status","=",1));  

        $responseDetails = $this->model->show_records(array('*'),$this->tableName, $condition);

        return $responseDetails;

    }

    public function get_cardholder_model($id){
        $condition = new QueryGroup();    
        $condition->and_query(new QueryField("cardholder_id","=",$id));
        //$condition->and_query(new QueryField("card_status","=",1));  

        $responseDetails = $this->model->show_records(array('*'),$this->tableName, $condition);

        return $responseDetails;

    }
    public function insert_cardholder_model($list=array()){

        $condition = new QueryGroup();    
        $responseDetails = $this->insert($this->tableName,$list);
        return $responseDetails;

    
    }
    public function update_cardholder_model($id,$list=array()) {
    
        $this->update($this->tableName,$list, new QueryField("cardholder_id","=",$id));
    
    }
    public function replace_cardholder_model($list=array()) {
        $insertrates = $this->replace($this->tableName,$list);
        return $insertrates;
    }


}
?>
