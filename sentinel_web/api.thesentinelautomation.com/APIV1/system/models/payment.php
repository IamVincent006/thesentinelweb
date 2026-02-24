<?php
class Payment extends Model {

 	private $tableName;
	private $model;

	public function __construct() {
	    $this->model     = new Model();	
	    $this->tableName = PREFIX.'payment';	
	}

    public function insert_payment($list=array()) {
        $insertParkID = $this->insert($this->tableName,$list);
        return $insertParkID;
    }

    public function update_payid_model($PayID,$list=array()) {
        $this->update($this->tableName,$list, new QueryField("payid","=",$PayID));      
    }


    public function get_payid_model($PayID) {

        $condition = new QueryGroup();    
        $condition->and_query(new QueryField("payid","=",$PayID));

        $responseDetails = $this->model->show_records(array("rctcnt"),$this->tableName, $condition);

        return $responseDetails;

    }

    public function get_payment_model($parkID) {

        $condition = new QueryGroup();    
        $condition->and_query(new QueryField("park_id","=",$parkID));

        $responseDetails = $this->model->show_records(array("sum(charge) as prevcharge","sum(initcharge) as previnitcharge",
    	"sum(surcharge) as prevsurcharge","sum(oncharge) as prevoncharge","sum(lostcharge) as prevlostcharge","max(paymentdate) as paymentdate"),$this->tableName, $condition);

        return $responseDetails;

        /*group by*/

                /*$select = new Select();
        $select->add_fields(array("sum(charge) as charge"));
        $select->set_table_name($this->tableName);
        //$select->set_condition(new QueryField("park_id", "=", $parkID));
        $select->add_group("park_id");
        $checkRequest = $this->select($select);
        print_r($checkRequest);
        //return $checkRequest;*/
    }

    public function getsyncpaymentprocess() {

        $condition = new QueryGroup();   

        $ResponseDetails = $this->model->show_records(array("*"),$this->tableName, $condition);
        return $ResponseDetails; 

    }
    public function deletepayment($ParkID) {

        $DeleteParkID = $this->delete($this->tableName,new QueryField("payid","=",$ParkID));
        return $DeleteParkID;
    }


}
?>
