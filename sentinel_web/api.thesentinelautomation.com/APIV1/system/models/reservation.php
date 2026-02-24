<?php
class Reservation extends Model {
 	
	private $tableName;
	private $model;
	
	public function __construct() {
	    $this->model     = new Model();	
	    $this->tableName = PREFIX.'reservation';	
	}

	public function check_reservation_list($terminalID) {

	    $conditionDate = new QueryGroup();
	    $conditionDate->and_query(new QueryField("reservationDate","=",date('Y-m-d')));

	    $conditionPending = new QueryGroup();
	    $conditionPending->or_query(new QueryField("reservationStatus","=",0));
	    $conditionPending->or_query($conditionDate);	

	    $condition = new QueryGroup();	
	    $condition->and_query(new QueryField("terminalID","=",$terminalID));
	    $condition->and_query($conditionPending);	

            $reservationDetails = $this->model->show_records(array("reservationStatus","reservationRefNo","reservationID","reservationDate","reservationTime","userID","terminalID","totalCharges"),$this->tableName, $condition, array("reservationID DESC"));
	    return $reservationDetails;	
	
	}


}
?>
