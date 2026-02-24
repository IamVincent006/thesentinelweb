<?php
class BCParking {

	function __construct($data=NULL) {
		$this->data = $data;
		$this->userinfo = new Userinfo();
		$this->userlevel = new Userlevel();
		$this->terminal = new Terminal();
		$this->tellerlog = new Tellerlog();
		$this->rate = new Rate();
		$this->terminalImages = new TerminalImages();
		$this->transaction = new Transaction();
		$this->terminaltype = new Terminaltype();
		$this->cardholder = new Cardholder();
		$this->payment = new Payment();
		$this->area = new Area();
		$this->slot = new Slot();
		$this->menu = new Menu();
		$this->auditlog = new Auditlog();
		$this->autoload = new Autoload();
		$this->voucher = new Voucher();
	}

	/*GLOBAL*/
	public function get_config() {
	


		$terminalID     =  $_REQUEST['terminalid'];
		$terminalDetails = $this->terminal->get_config_model($terminalID);

	

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $terminalDetails,
			);

		echo json_encode($response);

	}

	

	/*AUTOPAY*/
	public function autopay_getlogindetails()
	{

	
		//header('Content-Type: text/plain');
		
		
		$terminalDetails = $this->terminal->autopay_getlogindetails_model();
		
	

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $terminalDetails,
			);

			echo json_encode($response);
		//$entryreaID = $terminalDetails[0]['termarea']; 

	
	}



	public function insert_autopay()
	{



		$transArray   =   array(
								'autopay_id'		=>   $_REQUEST['autopay_id'],
								'terminalid'		=>   $_REQUEST['terminalid'],
								'treasurerid'		=>   $_REQUEST['treasurerid'],
								'php1'		=>   $_REQUEST['php1'],
								'php5'		=>   $_REQUEST['php5'],
								'php10'		=>   $_REQUEST['php10'],
								'php20'		=>   $_REQUEST['php20'],
								'php50'		=>   $_REQUEST['php50'],
								'php100'	=>   $_REQUEST['php100'],	
								'php200'	=>   $_REQUEST['php200'],		
								'php500'	=>   $_REQUEST['php500'],
								'php1000'	=>   $_REQUEST['php1000'],	
								'php1000'	=>   $_REQUEST['php1000'],		
				
							);
		if(isset($_REQUEST['datetime']))
			$transArray['datetime'] = $_REQUEST['datetime'];
		if(isset($_REQUEST['type']))
			$transArray['type'] = $_REQUEST['type'];
									
		$this->autoload->insert_autopay_model($transArray);
	}


	public function get_autopay()
	{
		$TellerLogID     =  $_REQUEST['tellerlogid'];
		$result = $this->autoload->get_autopay_model($TellerLogID);

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' => $result,
		
		);

		echo json_encode($response);

	}

	/*ENTRANCE*/
	public function check_cardholder(){

		if(isset($_REQUEST['cardserial']))
			$cardSerial  =  $_REQUEST['cardserial'];
		else
			$cardSerial = "";

		if(isset($_REQUEST['platenum']))
			$Platenum  = $_REQUEST['platenum'];
		else
			$Platenum = "";

		$result = $this->cardholder->get_cardholder_ifexist($cardSerial,$Platenum);

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' => $result,
		
		);

		echo json_encode($response);
		 //echo $this->core->display_result_json($status, $message, $response);	
		
	}

	public function get_transaction_parkid()
	{
		$parkID     =  $_REQUEST['park_id'];

		$terminals = $this->terminal->get_terminals_model();
		foreach ($terminals as $value) {	
			$terminalname[$value['termID']] =  $value['termIP'];
		}	

		$result = $this->transaction->get_transaction_parkid_model($parkID);

		$result[0]['entrytermIP'] = $terminalname[$result[0]['entry_termid']];
		if(isset($result[0]['exit_termid']))
			$result[0]['exittermIP'] = $terminalname[$result[0]['exit_termid']];
		else
			$result[0]['exittermIP'] = "null";
		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $result,
		);

		echo json_encode($result);

	}
	public function get_transaction_parkid_paid()
	{
		$parkID     =  $_REQUEST['park_id'];

		//$terminals = $this->terminal->get_terminals_model();
		//foreach ($terminals as $value) {	
		//	$terminalname[$value['termID']] =  $value['termIP'];
		//}	

		$result = $this->transaction->get_transaction_parkid_paid_model($parkID);

		//$result[0]['entrytermIP'] = $terminalname[$result[0]['entry_termid']];
		//if(isset($result[0]['exit_termid']))
		//	$result[0]['exittermIP'] = $terminalname[$result[0]['exit_termid']];
		//else
		//	$result[0]['exittermIP'] = "null";
		//$response = array(
		//	'status' => "200",
		//	'message' => "OK",
		//	'data' =>   $result,
		//);

		echo json_encode($result[0]);

	}
	
	public function check_cardexist(){

		if(isset($_REQUEST['cardserial']))
			$cardSerial     =  $_REQUEST['cardserial'];
		else
			$cardSerial = "";

		if(isset($_REQUEST['parkid']))
			$parkID     =  $_REQUEST['parkid'];
		else
			$parkID = "";
		
		$result = $this->transaction->get_transaction_ifexist($cardSerial,$parkID);

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' => $result,
			);

		echo json_encode($response);
		 //echo $this->core->display_result_json($status, $message, $response);	
		
	}

	public function update_cardexist(){
		//header('Content-Type: text/plain');
		date_default_timezone_set('Asia/Singapore');
		$datetime = date('Y-m-d H:i:s');

		$parkID     =  $_REQUEST['park_id'];
		$ExitTermID     =  $_REQUEST['exit_termid'];

		$terminaldata   = array(
             "process"  =>  100,   
             "exit_termid" => $ExitTermID, 
             "exitdate" => $datetime,                  
     	);			

		$this->transaction->UpdateExistTransaction($parkID,$terminaldata);

		$response = array(
			'status' => "200",
			'message' => "OK",		
		);	
		echo json_encode($response);
		
	}

	public function get_timenow()
	{
		header('Content-Type: text/plain');
		date_default_timezone_set('Asia/Singapore');
		$datetime = date('Y-m-d H:i:s');	

		$response = array(
			'status' => "200",
			'message' => "OK",

			'data' => array(
			    array(
			        "datetime" => $datetime,			  
			    ),		
			),
			);

			echo json_encode($response);
	}

	public function get_terminal_details() {
		header('Content-Type: text/plain');
		$terminalID     =  $_REQUEST['terminalid'];
		
		
		$terminalDetails = $this->terminal->get_terminal_details_model($terminalID);
		
	

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $terminalDetails,
			);

			echo json_encode($response);
		//$entryreaID = $terminalDetails[0]['termarea']; 

	}

	public function insert_parking_transaction() {
		/*entry*/
		//$parkID     =  $_REQUEST['park_id'];



		$transArray   =   array(
								'park_id'             =>   $_REQUEST['park_id'],
								'process'             =>   $_REQUEST['process'],
							);


		if(isset($_REQUEST['entryarea_id']) && $_REQUEST['entryarea_id']!="")
			$transArray['entryarea_id'] = $_REQUEST['entryarea_id'];
		if(isset($_REQUEST['entry_termid']) && $_REQUEST['entry_termid']!="")
			$transArray['entry_termid'] = $_REQUEST['entry_termid'];
		if(isset($_REQUEST['cardserial']) && $_REQUEST['cardserial']!="")
			$transArray['cardserial'] = $_REQUEST['cardserial'];
		if(isset($_REQUEST['entrydate']) && $_REQUEST['entrydate']!="")
			$transArray['entrydate'] = $_REQUEST['entrydate'];
		if(isset($_REQUEST['ratetype']) && $_REQUEST['ratetype']!="")
			$transArray['ratetype'] = $_REQUEST['ratetype'];
		if(isset($_REQUEST['platenum']) && $_REQUEST['platenum']!="")
			$transArray['platenum'] = $_REQUEST['platenum'];
		if(isset($_REQUEST['confidence']) && $_REQUEST['confidence']!="")
			$transArray['confidence'] = $_REQUEST['confidence'];
		if(isset($_REQUEST['brandmodel']) && $_REQUEST['brandmodel']!="")
			$transArray['brandmodel'] = $_REQUEST['brandmodel'];
		if(isset($_REQUEST['carcolor']) && $_REQUEST['carcolor']!="")
			$transArray['carcolor'] = $_REQUEST['carcolor'];
		if(isset($_REQUEST['entrycarimage']) && $_REQUEST['entrycarimage']!="")
			$transArray['entrycarimage'] = $_REQUEST['entrycarimage'];
		if(isset($_REQUEST['entryfaceimage']) && $_REQUEST['entryfaceimage']!="")
			$transArray['entryfaceimage'] = $_REQUEST['entryfaceimage'];
		if(isset($_REQUEST['vehicletype']) && $_REQUEST['vehicletype']!="")
			$transArray['vehicletype'] = $_REQUEST['vehicletype'];

		/*payment*/
		if(isset($_REQUEST['old_cardserial']) && $_REQUEST['old_cardserial']!="")
			$transArray['old_cardserial'] = $_REQUEST['old_cardserial'];
		if(isset($_REQUEST['tellerid']) && $_REQUEST['tellerid']!="")
			$transArray['tellerid'] = $_REQUEST['tellerid'];
		if(isset($_REQUEST['payment_termid']) && $_REQUEST['payment_termid']!="")
			$transArray['payment_termid'] = $_REQUEST['payment_termid'];
		if(isset($_REQUEST['paymentarea_id']) && $_REQUEST['paymentarea_id']!="")
			$transArray['paymentarea_id'] = $_REQUEST['paymentarea_id'];
		if(isset($_REQUEST['receiptnum']) && $_REQUEST['receiptnum']!="")
			$transArray['receiptnum'] = $_REQUEST['receiptnum'];

		if(isset($_REQUEST['voidnum']) && $_REQUEST['voidnum']!="")
			$transArray['voidnum'] = $_REQUEST['voidnum'];
		if(isset($_REQUEST['refundnum']) && $_REQUEST['refundnum']!="")
			$transArray['refundnum'] = $_REQUEST['refundnum'];

		if(isset($_REQUEST['paymentdate']) && $_REQUEST['paymentdate']!="")
			$transArray['paymentdate'] = $_REQUEST['paymentdate'];
		if(isset($_REQUEST['setl_ref']) && $_REQUEST['setl_ref']!="")
			$transArray['setl_ref'] = $_REQUEST['setl_ref'];

		if(isset($_REQUEST['dccode']) && $_REQUEST['dccode']!="")
			$transArray['dccode'] = $_REQUEST['dccode'];

		/*EXIT*/
		if(isset($_REQUEST['exit_termid']) && $_REQUEST['exit_termid']!="")
			$transArray['exit_termid'] = $_REQUEST['exit_termid'];

		if(isset($_REQUEST['exitdate']) && $_REQUEST['exitdate']!="")
			$transArray['exitdate'] = $_REQUEST['exitdate'];
		if(isset($_REQUEST['exitcarimage']) && $_REQUEST['exitcarimage']!="")
			$transArray['exitcarimage'] = $_REQUEST['exitcarimage'];
		if(isset($_REQUEST['exitfaceimage']) && $_REQUEST['exitfaceimage']!="")
			$transArray['exitfaceimage'] = $_REQUEST['exitfaceimage'];



		$this->transaction->insert_transaction($transArray);

		$response = array(
			'status' => "200",
			'message' => "OK",
		);	
		echo json_encode($response);			
	}

	public function update_parkingid()
	{
		$parkID     =  $_REQUEST['parkid'];
		$terminalID     =  $_REQUEST['terminalid'];
		$terminaldata   = array(
             "termparkid"  =>  $parkID,                    
     	);			

		$this->terminal->update_terminal_model($terminalID,$terminaldata);

		$response = array(
			'status' => "200",
			'message' => "OK",		
		);	
		echo json_encode($response);
	}

	public function update_dateendofshift()
	{

		$dateshift     =  $_REQUEST['dateshift'];
		$terminalID     =  $_REQUEST['terminalid'];

		$terminaldata   = array(
             "dateendshift"  =>  $dateshift,                    
     	);			

		$this->terminal->update_terminal_model($terminalID,$terminaldata);

		$response = array(
			'status' => "200",
			'message' => "OK",		
		);	
		echo json_encode($response);
		
	}

	public function update_termvoidid()
	{
		$Termvoid     =  $_REQUEST['termvoid'];
		$terminalID     =  $_REQUEST['terminalid'];

		$terminaldata   = array(
             "termvoid"  =>  $Termvoid,                    
     	);			

		$this->terminal->update_terminal_model($terminalID,$terminaldata);

		$response = array(
			'status' => "200",
			'message' => "OK",		
		);	
		echo json_encode($response);
	}
	public function update_termrefundid()
	{
		$Termrefund     =  $_REQUEST['termrefund'];
		$terminalID     =  $_REQUEST['terminalid'];

		$terminaldata   = array(
             "termrefund"  =>  $Termrefund,                    
     	);			

		$this->terminal->update_terminal_model($terminalID,$terminaldata);

		$response = array(
			'status' => "200",
			'message' => "OK",		
		);	
		echo json_encode($response);
	}



	public function update_termteller()
	{
		$TermTeller     =  $_REQUEST['termteller'];
		$terminalID     =  $_REQUEST['terminalid'];
		$terminaldata   = array(
             "termtellerlogID"  =>  $TermTeller,                    
     	);			

		$this->terminal->update_terminal_model($terminalID,$terminaldata);

		$response = array(
			'status' => "200",
			'message' => "OK",		
		);	
		echo json_encode($response);
	}




	/*#####################################################CASHIER#############################################*/


	public function get_userinfo() {

		$UserID     =  $_REQUEST['userid'];
		$UserDetails = $this->userinfo->get_userinfo_model($UserID);

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $UserDetails,
			);

		echo json_encode($response);
	}

	public function get_userverification() {
		

		//$Username     =  'admin';
		//$Password     =  'admin';

		$Username     =  $_REQUEST['username'];
		$Password     =  $_REQUEST['password'];
		$UserDetails = $this->userinfo->get_userverification_model($Username,$Password);


		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $UserDetails,
			);

		echo json_encode($response);
	}

	public function getuserbycard() {
		


		$UserDetails = $this->userinfo->getuserbycard_model($_REQUEST['cardserial']);


		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $UserDetails,
			);

		echo json_encode($response);
	}

	public function update_userverification_log()
	{

		header('Content-Type: text/plain');
		date_default_timezone_set('Asia/Singapore');
		$datetime = date('Y-m-d H:i:s');	

		$host     =  $_REQUEST['host'];
		$ip     =  $_REQUEST['ip'];
		$userid     =  $_REQUEST['userid'];

		//echo $ip;
		//echo $host;


  		$data   = array(
             	'last_pc'		=> $host,
              	'last_ip'		=> $ip,
              	'loginstatus'	=> 1,    
              	'logindate'		=> $datetime, 
     	);		

		$this->userinfo->update_userinfo_model($userid,$data);

		//echo json_encode($userid);

	}

	public function userlogout() {

		$userid     =  $_REQUEST['userid'];
  		$data   = array(
          	'loginstatus'	=> 0,     
     	);		

		$result = $this->userinfo->update_userinfo_model($userid,$data);

		$response = array(
			'data' =>   $result,
			);

		echo json_encode($response);


	}

	public function get_tellerlog() {

		$TerminalID     =  $_REQUEST['termid'];
		$TellerlogDetails = $this->tellerlog->get_tellerlog_model($TerminalID);

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $TellerlogDetails,
			);

		echo json_encode($response);
	}

	public function insert_tellerlog() {

		date_default_timezone_set('Asia/Singapore');
		$datetime = date('Y-m-d H:i:s');


		$TellerLogID     =  $_REQUEST['tellerlogid'];
		$UserID     =  $_REQUEST['tellerid'];
		//$LoginDate     =  $_REQUEST['logindate'];
		$TerminalID     =  $_REQUEST['terminalid'];
		$TermAreaID     =  $_REQUEST['termarea_id'];
		//$Status     =  $_REQUEST['status'];
		$Startcash     =  $_REQUEST['startcash'];


		$transArray   =   	array(
							'tellerlogid'         =>   $TellerLogID,
							'tellerid'        	  =>   $UserID,
							'logindate'        	  =>   $datetime,
							'terminalid'          =>   $TerminalID,
							'status'              =>   0,
							'loginarea_id'        =>   $TermAreaID,
							'startcash'           =>   $Startcash,

		);


		$this->tellerlog->insert_tellerlog_model($transArray);

		$response = array(
			'status' => "200",
			'message' => "OK",
			);

		echo json_encode($response);
	}

	public function update_tellerlog() {

		date_default_timezone_set('Asia/Singapore');
		$datetime = date('Y-m-d H:i:s');

		$TellerLogID     =  $_REQUEST['tellerlogid'];


		$TellerlogData   = array(
             "status"  =>  1,        
             "logoutdate" => $datetime,            
     	);	

		$this->tellerlog->update_tellerlog_model($TellerLogID,$TellerlogData);

		$response = array(
			'status' => "200",
			'message' => "OK",
			);

		echo json_encode($response);
	}


	public function get_parking_payment()
	{
		$parkID     =  $_REQUEST['park_id'];

		$PaymentDetails = $this->payment->get_payment_model($parkID);

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $PaymentDetails,
		);

		echo json_encode($response);

	}

	public function get_payid_payment()
	{
		//$parkID     =  $_REQUEST['payid'];

		$PaymentDetails = $this->payment->get_payid_model($_REQUEST['payid']);

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $PaymentDetails,
		);

		echo json_encode($response);

	}

	public function update_payid_payment(){
		$payid     =  $_REQUEST['payid'];
		$RctCnt     =  $_REQUEST['rctcnt'];

		$paymentdata   = array(
             "rctcnt"  =>  $RctCnt,                    
     	);			

		$this->payment->update_payid_model($payid,$paymentdata);

		$response = array(
			'status' => "200",
			'message' => "OK",		
		);	
		echo json_encode($response);
		
	}

	public function update_receiptnum()
	{
		$TermReceipt     =  $_REQUEST['termreceipt'];
		$terminalID     =  $_REQUEST['terminalid'];
		$terminaldata   = array(
             "termreceipt"  =>  $TermReceipt,                    
     	);			

		$this->terminal->update_terminal_model($terminalID,$terminaldata);
		
		$response = array(
			'status' => "200",
			'message' => "OK",		
		);	
		echo json_encode($response);
	}


	public function get_ratescode_display() {
		$AreaID     =  $_REQUEST['areaid'];
		$ratesdetails = $this->rate->get_ratecode_display($AreaID);	
		$response = array(
				'status' => "200",
				'message' => "OK",
				'data' =>   $ratesdetails,								
		);
		echo json_encode($response);
	}


	public function get_parking_rates() {
		//$RateID = 1;
		$RateID     =  $_REQUEST['rate_id'];
		$ratesdetails = $this->rate->get_rates_details($RateID);
		if(!$ratesdetails == [])
		{
			$response = array(
				'status' => "200",
				'message' => "OK",
				'data' => $ratesdetails,						
			);
			echo json_encode($response);			
		}
		else
		{
			$response = array(
				'status' => "404",
				'message' => "Not Found",					
			);
			echo json_encode($response);
		}		
	}

	public function get_parking_area() {
		$AreaID     =  $_REQUEST['area_id'];
		$ratesdetails = $this->area->get_area_details($AreaID);
		if(!$ratesdetails == [])
		{
			$response = array(
				'status' => "200",
				'message' => "OK",
				'data' => $ratesdetails,						
			);
			echo json_encode($response);			
		}
		else
		{
			$response = array(
				'status' => "404",
				'message' => "Not Found",					
			);
			echo json_encode($response);
		}		
	}

	public function get_parking_voucher() {
		$dcid     =  $_REQUEST['dcid'];
		$ratesdetails = $this->voucher->get_voucher_details($dcid);
		if(!$ratesdetails == [])
		{
			$response = array(
				'status' => "200",
				'message' => "OK",
				'data' => $ratesdetails,						
			);
			echo json_encode($response);			
		}
		else
		{
			$response = array(
				'status' => "404",
				'message' => "Not Found",					
			);
			echo json_encode($response);
		}		
	}

	public function get_parking_voucherbycode() {
		$dccode     =  $_REQUEST['dccode'];
		$ratesdetails = $this->voucher->get_voucher_detailsbycode($dccode);
		if(!$ratesdetails == [])
		{
			$response = array(
				'status' => "200",
				'message' => "OK",
				'data' => $ratesdetails,						
			);
			echo json_encode($response);			
		}
		else
		{
			$response = array(
				'status' => "404",
				'message' => "Not Found",					
			);
			echo json_encode($response);
		}		
	}

	public function get_rateid_display()
	{
		//$RateCode = "Regular";
		$RateCode     =  $_REQUEST['rate_code'];
		$ratesdetails = $this->rate->get_rateids_display($RateCode);
		if(!$ratesdetails == [])
		{
			$response = array(
				'status' => "200",
				'message' => "OK",
				'data' => $ratesdetails,						
			);
			echo json_encode($response);			
		}
		else
		{
			$response = array(
				'status' => "404",
				'message' => "Not Found",					
			);
			echo json_encode($response);
		}
	}




	public function get_parking_transaction() {

		//$cardSerial = "04263B1AD01390";
		$cardSerial     =  $_REQUEST['cardserial'];

		$terminals = $this->terminal->get_terminals_model();
		foreach ($terminals as $value) {	
			$terminalname[$value['termID']] =  $value['termIP'];
		}


		$transactionDetails = $this->transaction->get_transaction_details($cardSerial);
		//print_r($transactionDetails);
		if(!empty($transactionDetails))
		{
			$transactionDetails[0]['termIP'] = $terminalname[$transactionDetails[0]['entry_termid']];		
		}
		/*foreach ($transactionDetails as $key => $field) {

				$transactionDetails[$key]['termIP'] = $terminalname[$transactionDetails[$key]['entry_termid']];						
		}*/

		if(!$transactionDetails == [])
		{
			$response = array(
				'status' => "200",
				'message' => "OK",
				'data' => $transactionDetails,
			);
			echo json_encode($response);
		}
		else
		{
			$response = array(
				'status' => "404",
				'message' => "Not Found",					
			);

			echo json_encode($response);
		}
        //echo json_encode($parkID);	    
	}
	/*update*/

	public function update_parking_transaction() {
		
		date_default_timezone_set('Asia/Singapore');
		$datetime = date('Y-m-d H:i:s');
		$parkID        =  $_REQUEST['park_id'];
	

		if(isset($_REQUEST['cardserial']) && $_REQUEST['cardserial'] != "")
     		$terminaldata['cardserial'] = $_REQUEST['cardserial'];

		if(isset($_REQUEST['old_cardserial']) && $_REQUEST['old_cardserial'] != "")
     		$terminaldata['old_cardserial'] = $_REQUEST['old_cardserial'];

		if(isset($_REQUEST['payment_termid']) && $_REQUEST['payment_termid'] != "")
     		$terminaldata['payment_termid'] = $_REQUEST['payment_termid'];

		if(isset($_REQUEST['paymentdate']) && $_REQUEST['paymentdate'] != "")
     		$terminaldata['paymentdate'] = $_REQUEST['paymentdate'];

		if(isset($_REQUEST['process']) && $_REQUEST['process'] != "")
     		$terminaldata['process'] = $_REQUEST['process'];

		if(isset($_REQUEST['platenum']) && $_REQUEST['platenum'] != "")
     		$terminaldata['platenum'] = $_REQUEST['platenum'];

		if(isset($_REQUEST['ratetype']) && $_REQUEST['ratetype'] != "")
     		$terminaldata['ratetype'] = $_REQUEST['ratetype'];

     	if(isset($_REQUEST['tellerid']) && $_REQUEST['tellerid'] != "")
     		$terminaldata['tellerid'] = $_REQUEST['tellerid'];

     	if(isset($_REQUEST['paymentarea_id']) && $_REQUEST['paymentarea_id'] != "")
     		$terminaldata['paymentarea_id'] = $_REQUEST['paymentarea_id'];

     	if(isset($_REQUEST['receiptnum']) && $_REQUEST['receiptnum'] != "")
     		$terminaldata['receiptnum'] = $_REQUEST['receiptnum'];

     	if(isset($_REQUEST['voidnum']) && $_REQUEST['voidnum'] != "")
     		$terminaldata['voidnum'] = $_REQUEST['voidnum'];

     	if(isset($_REQUEST['refundnum']) && $_REQUEST['refundnum'] != "")
     		$terminaldata['refundnum'] = $_REQUEST['refundnum'];

     	if(isset($_REQUEST['dccode']) && $_REQUEST['dccode'] != "")
     		$terminaldata['dccode'] = $_REQUEST['dccode'];

     	if(isset($_REQUEST['setl_ref']) && $_REQUEST['setl_ref'] != "")
     		$terminaldata['setl_ref'] = $_REQUEST['setl_ref'];

		$this->transaction->update_transaction_details($parkID,$terminaldata);
		
		$response = array(
			'status' => "200",
			'message' => "OK",		
		);

		echo json_encode($response);

	    
	}
	public function insert_payment_transaction()
	{
		date_default_timezone_set('Asia/Singapore');
		$datetime = date('Y-m-d H:i:s');
		$PayID     	   =  $_REQUEST['payid'];
		$parkID        =  $_REQUEST['park_id'];
		$TellerID      =  $_REQUEST['tellerid'];
		$RateType      =  $_REQUEST['ratetype'];
		$ReceiptNum    =  $_REQUEST['receiptnum'];
		$Charge        =  $_REQUEST['charge'];
		$InitCharge    =  $_REQUEST['initcharge'];
		$SurCharge     =  $_REQUEST['surcharge'];
		$OnCharge      =  $_REQUEST['oncharge'];
		$LostCharge    =  $_REQUEST['lostcharge'];
		$PaymentDate   =  $_REQUEST['paymentdate'];
		$Discount      =  $_REQUEST['discount'];
		//$Vat     	   =  $_REQUEST['vat'];
		$VatExempt     =  $_REQUEST['vatexempt'];
		$VatSales     =  $_REQUEST['vatsales'];

		$transArray   =   array(
						'shortchange'         =>   $_REQUEST['shortchange'],
						'recieved'            =>   $_REQUEST['recieved'],
						'changebill'          =>   $_REQUEST['changebill'],
						'changecoin'          =>   $_REQUEST['changecoin'],
						'payid'               =>   $PayID,
						'park_id'        	  =>   $parkID,
						"tellerid" 			  =>   $TellerID,
						"ratetype" 			  =>   $RateType, 
						'charge'        	  =>   $Charge,
						'initcharge'          =>   $InitCharge,
						'surcharge'           =>   $SurCharge,
						'oncharge'            =>   $OnCharge,	
						'lostcharge'          =>   $LostCharge,	
			            'paymentdate' 		  =>   $PaymentDate, 
			            'receiptnum' 		  =>   $ReceiptNum, 
			            'discount' 		 	  =>   $Discount, 		
			            //'vat' 		 	  	  =>   $Vat, 
			            'vatexempt' 		  =>   $VatExempt, 
			            'vatsales' 			  =>   $VatSales, 	
			            		
		);

		$this->payment->insert_payment($transArray);

		$response = array(
			'status' => "200",
			'message' => "OK",		
		);

		echo json_encode($response);

	}

	/*public function update_parking_transaction() {
		
		date_default_timezone_set('Asia/Singapore');
		$datetime = date('Y-m-d H:i:s');



		$PlateNum      =  $_REQUEST['platenum'];
		$OldcardSerial =  $_REQUEST['old_cardserial'];
		$cardSerial    =  $_REQUEST['cardserial'];
		$PayID     	   =  $_REQUEST['payid'];
		$parkID        =  $_REQUEST['park_id'];
		$TellerID      =  $_REQUEST['tellerid'];
		$PayTerminalID =  $_REQUEST['payment_termid'];
		$PayAreaID     =  $_REQUEST['paymentarea_id'];
		$RateType      =  $_REQUEST['ratetype'];
		$ReceiptNum    =  $_REQUEST['receiptnum'];
		$Charge        =  $_REQUEST['charge'];
		$InitCharge    =  $_REQUEST['initcharge'];
		$SurCharge     =  $_REQUEST['surcharge'];
		$OnCharge      =  $_REQUEST['oncharge'];
		$LostCharge    =  $_REQUEST['lostcharge'];
		$PaymentDate   =  $_REQUEST['paymentdate'];
		$Discount      =  $_REQUEST['discount'];
		//$Vat     	   =  $_REQUEST['vat'];
		$VatExempt     =  $_REQUEST['vatexempt'];
		$VatSales     =  $_REQUEST['vatsales'];


		$terminaldata   = array(
			 "platenum"  =>  $PlateNum,  
			 "old_cardserial"  =>  $OldcardSerial,   
			 "cardserial"  =>  $cardSerial,   
             "process"  =>  2,   
             "payment_termid" => $PayTerminalID,
             "paymentarea_id" => $PayAreaID, 
             "ratetype" => $RateType, 
             "paymentdate" => $PaymentDate,
             'receiptnum'  => $ReceiptNum, 
             "tellerid" => $TellerID,
     	);			

		$this->transaction->update_transaction_details($parkID,$terminaldata);

     


		$transArray   =   array(
						'shortchange'         =>   $_REQUEST['shortchange'],
						'recieved'            =>   $_REQUEST['recieved'],
						'changebill'          =>   $_REQUEST['changebill'],
						'changecoin'          =>   $_REQUEST['changecoin'],
						'payid'               =>   $PayID,
						'park_id'        	  =>   $parkID,
						"tellerid" 			  =>   $TellerID,
						"ratetype" 			  =>   $RateType, 
						'charge'        	  =>   $Charge,
						'initcharge'          =>   $InitCharge,
						'surcharge'           =>   $SurCharge,
						'oncharge'            =>   $OnCharge,	
						'lostcharge'          =>   $LostCharge,	
			            'paymentdate' 		  =>   $PaymentDate, 
			            'receiptnum' 		  =>   $ReceiptNum, 
			            'discount' 		 	  =>   $Discount, 		
			            //'vat' 		 	  	  =>   $Vat, 
			            'vatexempt' 		  =>   $VatExempt, 
			            'vatsales' 			  =>   $VatSales, 	
			            		
		);

		$this->payment->insert_payment($transArray);

		
		$response = array(
			'status' => "200",
			'message' => "OK",		
		);

		echo json_encode($response);

	    
	}*/
	public function update_paid_transaction()
	{
		$parkID     =  $_REQUEST['park_id'];
		$ExitTermID     =  $_REQUEST['exit_termid'];
		$ExitDate     =  $_REQUEST['exitdate'];
		$CarImage     =  $_REQUEST['exitcarimage'];
		$FaceImage     =  $_REQUEST['exitfaceimage'];

		$terminaldata   = array(
             "process"  =>  1,   
             "exit_termid" => $ExitTermID,
             "exitdate" => $ExitDate, 
             "exitcarimage" => $CarImage,
             "exitfaceimage" => $FaceImage, 

     	);			

		$this->transaction->update_transaction_details($parkID,$terminaldata);
	}

	/*View Parker*/

	public function update_licesennum(){
		$parkID     =  $_REQUEST['parkid'];
		$Platenum     =  $_REQUEST['platenum'];

		$terminaldata   = array(
             "platenum"  =>  $Platenum,                    
     	);			

		$this->transaction->update_transaction_details($parkID,$terminaldata);

		$response = array(
			'status' => "200",
			'message' => "OK",		
		);	
		echo json_encode($response);
		
	}







	public function get_parker_details(){
	
		$StartDate = $_REQUEST['startdate'];
		$EndDate = $_REQUEST['enddate'];
		$Platenum = $_REQUEST['platenum'];



		$terminals = $this->terminal->get_terminals_model();
		foreach ($terminals as $value) {	
			$terminalname[$value['termID']] =  $value['termname'];
			$terminalip[$value['termID']] =  $value['termIP'];
		}


		$result = $this->transaction->get_parker_model($Platenum,$StartDate,$EndDate);


		
		foreach ($result as $key => $field) {
				$result[$key]['enttermip'] = $terminalip[$result[$key]['entry_termid']];
				$result[$key]['enttermname'] = $terminalname[$result[$key]['entry_termid']];

						
		}




		echo json_encode($result);
		 //echo $this->core->display_result_json($status, $message, $response);	
		
	}
	public function void_details(){
	


		$terminals = $this->terminal->get_terminals_model();
		foreach ($terminals as $value) {	
			$terminalname[$value['termID']] =  $value['termname'];
			$terminalip[$value['termID']] =  $value['termIP'];
		}			

		$result = $this->transaction->void_model($_REQUEST['query'],$_REQUEST['datelogin']);

		foreach ($result as $key => $field) {

				$result[$key]['paymenttermname'] = $terminalname[$result[$key]['payment_termid']];
				$result[$key]['paytermip'] = $terminalip[$result[$key]['payment_termid']];
				$result[$key]['enttermip'] = $terminalip[$result[$key]['entry_termid']];

						
		}


		echo json_encode($result);
		
		
	}	
	public function reprint_details(){
	


		$terminals = $this->terminal->get_terminals_model();
		foreach ($terminals as $value) {	
			$terminalname[$value['termID']] =  $value['termname'];
			$terminalip[$value['termID']] =  $value['termIP'];
		}			

		$result = $this->transaction->reprint_model($_REQUEST['query']);

		foreach ($result as $key => $field) {

				$result[$key]['paymenttermname'] = $terminalname[$result[$key]['payment_termid']];
				$result[$key]['paytermip'] = $terminalip[$result[$key]['payment_termid']];
				$result[$key]['enttermip'] = $terminalip[$result[$key]['entry_termid']];

						
		}


		echo json_encode($result);
		
		
	}	


	/*WEB*/

	public function update_parking_terminals() {


		$terminalID = $_REQUEST['termid'];
		$TermName = $_REQUEST['termname'];
		$TermIP = $_REQUEST['termIP'];
		$AreaCode = $_REQUEST['area_code'];
		$DocNum = $_REQUEST['docnum'];
		$TermType = $_REQUEST['termtype'];
		$TermArea = $_REQUEST['termarea'];
		$TermCnt = $_REQUEST['termcnt'];
		$TermReceipt = $_REQUEST['termreceipt'];
		$TermTellerLog = $_REQUEST['termtellerlogID'];
		$TermParkID = $_REQUEST['termparkid'];
    


		$terminalArray   =   array(
			'termname'		=>$TermName,
			'termIP'		=>$TermIP,
			'area_code'		=>$AreaCode,
			'docnum'		=>$DocNum,
			'termtype'		=>$TermType,
			'termarea'		=>$TermArea,	
			'termcnt'		=>$TermCnt,	
			'termtellercnt'		=>$TermCnt,		
			'termreceipt'		=>$TermReceipt,
			'termtellerlogID'	=>$TermTellerLog,
			'termparkid'	=>$TermParkID,

			);
	
		$result = $this->terminal->update_terminal_model($terminalID,$terminalArray);

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $result,
			);

		echo json_encode($response);

		
	}

	public function add_parking_terminals() {

		$TermName = $_REQUEST['termname'];
		$TermIP = $_REQUEST['termIP'];
		$AreaCode = $_REQUEST['area_code'];
		$DocNum = $_REQUEST['docnum'];
		$TermType = $_REQUEST['termtype'];
		$TermArea = $_REQUEST['termarea'];
		$TermCnt = $_REQUEST['termcnt'];
		$TermReceipt = $_REQUEST['termreceipt'];
		$TermTellerLog = $_REQUEST['termtellerlogID'];
		$TermParkID = $_REQUEST['termparkid'];
    


		$terminalArray   =   array(
			'termname'		=>$TermName,
			'termIP'		=>$TermIP,
			'area_code'		=>$AreaCode,
			'docnum'		=>$DocNum,
			'termtype'		=>$TermType,
			'termarea'		=>$TermArea,	
			'termcnt'		=>$TermCnt,
			'termrefund'  => "1",
			'termvoid'  => "1",
			'termtellercnt'		=>$TermCnt,		
			'termreceipt'		=>$TermReceipt,
			'termtellerlogID'	=>$TermTellerLog,
			'termparkid'	=>$TermParkID,

			);
	
		$result = $this->terminal->insert_terminals($terminalArray);

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $result,
			);

		echo json_encode($response);

		
	}


	public function area_details() {

	
		$UserDetails = $this->area->area_details_model();

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $UserDetails,
			);

		echo json_encode($response);

		
	}

	public function menu_details() {

	
		$menu = $this->menu->menu_details_model();

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $menu,
			);

		echo json_encode($response);

		
	}




	public function userinfo_details() {
		$Userlevel = $this->userlevel->userlevel_details_model();

		foreach ($Userlevel as $value) {	
			$userlevelname[$value['userlevel_id']] =  $value['userlevel_name'];
		}	
	
		$result = $this->userinfo->userinfo_details_model();

		foreach ($result as $key => $field) {
				$result[$key]['levelname'] = $userlevelname[$result[$key]['userlevel']];
						
		}


		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $result,
			);

		echo json_encode($response);
	}



	public function add_parking_users() { 

  		/*$data   = array(
             	'firstname'     => $_REQUEST['firstname'],
              	'lastname'      => $_REQUEST['lastname'],                         
                'username'    => $_REQUEST['username'],
                'password'       => $_REQUEST['password'],
                'userlevel'     => $_REQUEST['userlevel'],         
     	);	*/	


     	if(isset($_REQUEST['firstname']))
     		$data['firstname'] = $_REQUEST['firstname'];
     	if(isset($_REQUEST['lastname']))
     		$data['lastname'] = $_REQUEST['lastname'];
     	if(isset($_REQUEST['username']))
     		$data['username'] = $_REQUEST['username'];
     	if(isset($_REQUEST['password']))
     		$data['password'] = $_REQUEST['password'];
     	if(isset($_REQUEST['userlevel']))
     		$data['userlevel'] = $_REQUEST['userlevel'];



		$result = $this->userinfo->add_userinfo_model($data);  

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $result,
		);

		echo json_encode($response);  

	
	}

	public function edit_parking_users() { 



		$userid = $_REQUEST['userid'];
  		/*$data   = array(
             	'firstname'     => $_REQUEST['firstname'],
              	'lastname'      => $_REQUEST['lastname'],                         
                'username'    => $_REQUEST['username'],               
                'userlevel'     => $_REQUEST['userlevel'],  
                'status'     => $_REQUEST['status'],         
     	);		

     	if(isset($_REQUEST['password']))
     		$data['password'] = $_REQUEST['password'];*/
     	if(isset($_REQUEST['firstname']))
     		$data['firstname'] = $_REQUEST['firstname'];
     	if(isset($_REQUEST['lastname']))
     		$data['lastname'] = $_REQUEST['lastname'];
     	if(isset($_REQUEST['username']))
     		$data['username'] = $_REQUEST['username'];
     	if(isset($_REQUEST['password']))
     		$data['password'] = $_REQUEST['password'];
     	if(isset($_REQUEST['userlevel']))
     		$data['userlevel'] = $_REQUEST['userlevel'];
     	if(isset($_REQUEST['status']))
     		$data['status'] = $_REQUEST['status'];


		
		$result = $this->userinfo->update_userinfo_model($userid,$data); 

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $result,
			);

  		echo json_encode($response);   		
	
	}



	

	public function userlevel_details() {

	
		$UserDetails = $this->userlevel->userlevel_details_model();

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $UserDetails,
			);

		echo json_encode($response);

		
	}






	public function tellerlog_byterminal()
	{
		$terminal = $_REQUEST['terminal'];
		$from_date = $_REQUEST['from_date'];
		$to_date = $_REQUEST['to_date'];
		$area = $_REQUEST['area'];
		//$terminal = 2;
		//$from_date = "2023-08-01 08:00:00";
		//$to_date = "2023-09-29 21:00:00";
		//$area = 1;



		/*GET TERMINALS DATA*/
		$terminals = $this->terminal->get_terminals_model();
		foreach ($terminals as $value) {	
			$terminalname[$value['termID']] =  $value['termname'];
		}	

		$result = $this->tellerlog->tellerlog_byterminal_model($terminal,$from_date,$to_date,$area);

		foreach ($result as $key => $field) {

				$result[$key]['terminalname'] = $terminalname[$result[$key]['terminalid']];						
		}


		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $result,
			);

		echo json_encode($response);


	}

	public function tellerlog_byteller()
	{

		$tellerid = $_REQUEST['tellerid'];
		$from_date = $_REQUEST['from_date'];
		$to_date = $_REQUEST['to_date'];

		//$tellerid = 4;
		//$from_date = "2025-03-14 00:00:00";
		//$to_date = "2025-03-14 23:00:00";



		/*GET TERMINALS DATA*/
		$terminals = $this->terminal->get_terminals_model();
		foreach ($terminals as $value) {	
			$terminalname[$value['termID']] =  $value['termname'];
		}	

		$result = $this->tellerlog->tellerlog_byteller_model($tellerid,$from_date,$to_date);

		foreach ($result as $key => $field) {

				$result[$key]['terminalname'] = $terminalname[$result[$key]['terminalid']];						
		}


		//$response = array(
		//	'status' => "200",
		//	'message' => "OK",
		//	'data' =>   $result,
		//	);

		echo json_encode($result);


	}

	public function transaction_groupbydate()
	{
		$terminal = $_REQUEST['terminal'];
		$from_date = $_REQUEST['from_date'];
		$to_date = $_REQUEST['to_date'];
		//$terminal = 2;
		//$from_date = "2023-09-01 08:00:00";
		//$to_date = "2025-09-29 21:00:00";







		$datedetails = $this->transaction->transaction_getdate_model($terminal,$to_date);

		//$datediff =strtotime($datedetails[0]["maxpaydate"]) - strtotime($datedetails[0]["minpaydate"]) ;
		//$datecount =  round($datediff / (60 * 60 * 24)) + 1;




		$result = $this->transaction->transaction_groupbydate_model($terminal,$from_date,$to_date);
		$result[0]["minpaydate"] = $datedetails[0]["minpaydate"];
	



		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $result,
			);

		echo json_encode($response);


	}

	public function transaction_groupbyrate() {
		$terminal = $_REQUEST['terminal'];
		$from_date = $_REQUEST['from_date'];
		$to_date = $_REQUEST['to_date'];
		$area = $_REQUEST['area'];

		//$area = 1;
		//$terminal = 2;
		//$from_date = '2024-11-05 11:23:40';
		//$to_date = '2024-11-06 14:10:05';
		//$tellerid = 4;



		$rates = $this->rate->get_rates_model();
		foreach ($rates as $value) {	
			$ratesname[$value['rate_id']] =  $value['rate_code'];
		}	

		//print_r($ratesname);


		$result = $this->transaction->transaction_groupbyrate_model($terminal,$from_date,$to_date,$area);
		foreach ($result as $key => $field) {

			$result[$key]['ratetype'] = $ratesname[$result[$key]['ratetype']];
			//print_r($result[$key]['ratetype'])
		}
	

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $result,
			);

		echo json_encode($response);
		//echo json_encode($transactionDetails);

	}


	public function transaction_records() {
		$terminal = $_REQUEST['terminal'];
		$from_date = $_REQUEST['from_date'];
		$to_date = $_REQUEST['to_date'];
		//$terminal = 4;
		//$from_date = "2023-08-01 08:00:00";
		//$to_date = "2025-09-29 21:00:00";


		/*GET TERMINALS DATA*/
		$terminals = $this->terminal->get_terminals_model();
		foreach ($terminals as $value) {	
			$terminalname[$value['termID']] =  $value['termIP'];
		}	


		$rates = $this->rate->get_rates_model();
		foreach ($rates as $value) {	
			$ratesname[$value['rate_id']] =  $value['rate_code'];
		}	





		$result = $this->transaction->transaction_record_model($terminal,$from_date,$to_date);
		/*terminals*/
		foreach ($result as $key => $field) {

			$result[$key]['termIP'] = $terminalname[$result[$key]['payment_termid']];
		}
		
		/*rates*/
		foreach ($result as $key => $field) {

			$result[$key]['ratename'] = $ratesname[$result[$key]['ratetype']];
			//print_r($result[$key]['ratetype'])
		}



		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $result,
			);

		echo json_encode($response);
		//echo json_encode($transactionDetails);

	}


	public function transaction_total() {
		$terminal = $_REQUEST['terminal'];
		$from_date = $_REQUEST['from_date'];
		$to_date = $_REQUEST['to_date'];


		//$terminal = 2;
		//$from_date = "2025-02-17 00:00:00";
		//$to_date = "2025-02-17 23:59:59";
		
		$oldreceipt = $this->transaction->transaction_oldreceipt_model($terminal);

		$resultold = $this->transaction->transaction_oldtotal_model($terminal,$from_date);

		//print_r($resultold[0]["oldtotal"]);



		$result = $this->transaction->transaction_total_model($terminal,$from_date,$to_date);
		//print_r("<br/>");

		$result[0]["oldmin_or"] = $oldreceipt[0]["oldmin_or"];
		$result[0]["oldtotal"] = $resultold[0]["oldtotal"];
		$result[0]["oldcount"] = $resultold[0]["oldcount"];
		//print_r($result);
	

		if(!isset($result[0]["min_void"]))
			$result[0]["min_void"] = $oldreceipt[0]["oldmin_void"];
		if(!isset($result[0]["max_void"]))
			$result[0]["max_void"] = $oldreceipt[0]["oldmax_void"];
		if(!isset($result[0]["min_refund"]))
			$result[0]["min_refund"] = $oldreceipt[0]["oldmin_refund"];
		if(!isset($result[0]["max_refund"]))
			$result[0]["max_refund"] = $oldreceipt[0]["oldmax_refund"];





		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $result,
			);

		echo json_encode($response);
		//echo json_encode($transactionDetails);

	}

	public function records_byteller() {
		$terminal = $_REQUEST['terminal'];
		$from_date = $_REQUEST['from_date'];
		$to_date = $_REQUEST['to_date'];
		//$tellerid = $_REQUEST['tellerid'];
		//$terminal = 5;
		//$from_date = '2023-10-01 00:05:26';
		//$to_date = '2023-10-30 23:14:58';
		//$tellerid = 16;



		$result = $this->transaction->records_byteller_model($terminal,$from_date,$to_date);

	

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $result,
			);

		echo json_encode($response);
		//echo json_encode($transactionDetails);

	}

	public function transaction_byteller() {
		$terminal = $_REQUEST['terminal'];
		$from_date = $_REQUEST['from_date'];
		$to_date = $_REQUEST['to_date'];
		$tellerid = $_REQUEST['tellerid'];

		//$terminal = 2;
		//$from_date = '2024-11-05 11:23:40';
		//$to_date = '2025-11-05 23:59:59';
		//$tellerid = 4;





		$result = $this->transaction->transaction_byteller_model($terminal,$from_date,$to_date,$tellerid);

	

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $result,
			);

		echo json_encode($response);
		//echo json_encode($transactionDetails);

	}
	public function get_users() {
	
		$UserDetails = $this->userinfo->userinfo_details_model();
		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $UserDetails,
			);

		echo json_encode($response);

	}

	public function get_terminals() {
	
		$terminalDetails = $this->terminal->get_terminals_model();
		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' =>   $terminalDetails,
			);

		echo json_encode($response);

	}



	public function add_parking_rates() {
		//$rate_id = $_REQUEST['rate_id'];
  		$data   = array(
  				'area_id'     => $_REQUEST['area_id'],
             	'rate_code'     => $_REQUEST['rate_code'],
              	'initcharge_hour'      => $_REQUEST['inithour'],                         
                'initcharge'    => $_REQUEST['initcharge'],
                'succharge_hour'       => $_REQUEST['suchour'],
                'succharge'     => $_REQUEST['succharge'],
                'oncharge'      => $_REQUEST['oncharge'],
                'lostcharge'    => $_REQUEST['lostcharge'],
                'member_type'  		=> $_REQUEST['type'],
                'discount'  		=> $_REQUEST['discount'],            
     	);		

		$result = $this->rate->add_rates_model($data);  
 		$response = array(

			'data' => $result,

			);

		echo json_encode($response);   		
	
	}

	public function edit_parking_rates() {


		$rate_id = $_REQUEST['rate_id'];
  		$data   = array(
             	'rate_code'     => $_REQUEST['rate_code'],
              	'initcharge_hour'      => $_REQUEST['initcharge_hour'],                         
                'initcharge'    => $_REQUEST['initcharge'],
                'succharge_hour'       => $_REQUEST['succharge_hour'],
                'succharge'     => $_REQUEST['succharge'],
                'oncharge'      => $_REQUEST['oncharge'],
                'lostcharge'    => $_REQUEST['lostcharge'],
                'member_type'  		=> $_REQUEST['member_type'],   
                'discount'  		=> $_REQUEST['discount'],  
                'rate_status'  		=> $_REQUEST['rate_status'],            
     	);		

		$result = $this->rate->update_rates_model($rate_id,$data); 
 		$response = array(
			'data' => $result,
			);

		echo json_encode($response);


	}

	public function add_parking_area() {

  		$data   = array(
             	'area_code'     => $_REQUEST['area_code'],
                'area_name'  		=> $_REQUEST['area_name'], 
              	'payment_gracehour'      => $_REQUEST['payment_gracehour'],                         
                'payment_graceminute'    => $_REQUEST['payment_graceminute'],
                'entry_gracehour'       => $_REQUEST['entry_gracehour'],
                'entry_graceminute'     => $_REQUEST['entry_graceminute'],
                'cutoffhour'      => $_REQUEST['cutoffhour'],
                'cutoffminute'    => $_REQUEST['cutoffminute'],
           
     	);		

		$result = $this->area->add_area_model($data);    
 		$response = array(

			'data' => $result,

			);

		echo json_encode($response);	


	}

	public function edit_parking_area() {


		$area_id = $_REQUEST['area_id'];
  		$data   = array(
             	'area_code'     => $_REQUEST['area_code'],
                'area_name'  		=> $_REQUEST['area_name'], 
              	'payment_gracehour'      => $_REQUEST['payment_gracehour'],                         
                'payment_graceminute'    => $_REQUEST['payment_graceminute'],
                'entry_gracehour'       => $_REQUEST['entry_gracehour'],
                'entry_graceminute'     => $_REQUEST['entry_graceminute'],
                'cutoffhour'      => $_REQUEST['cutoffhour'],
                'cutoffminute'    => $_REQUEST['cutoffminute'],
           
     	);		


		$result = $this->area->update_area_model($area_id,$data);    
		 		$response = array(

			'data' => $result,
			);

		echo json_encode($response);	

	}

  	public function codeGenerator($id){
		 // for len 6

		 //Step 1: Get Base64
		 $code = base64_encode($id);
		 

		 //Step 2: Strip '==' if present
		 $codeStripped = str_replace('=', '', $code);

		 //Step 3: Compare if string has been stripped and if present convert to ASCII to reduce the code length
		 if($code !== $codeStripped){
		    $rand = rand(65,122);
		    if($rand >90 && $rand <97){ //to ignore non url characters
		       $ascii = $rand;
		    }else{
		       $ascii = chr($rand);
		    }

		    $code = $codeStripped. $ascii;
		    //echo $code;

		 }else{ //no '=' signs present
		    $code = $codeStripped;
		 }

		 //Step 4: Shuffle Characters
		 $code = str_shuffle($code);

		 //Step 5: If length if > 6 we will trim it, to make code shorter
		 if(strlen($code > 6)){
		    $code = substr($code,0,6);
		 }
			//print_r($code);
			//print_r("\n");

		 //Step 6: Convert Mix Random Case
		 for ($i=0, $c=strlen($code); $i<$c; $i++)
		 $code[$i] = (rand(0, 100) > 50
		 ? strtoupper($code[$i])
		 : strtolower($code[$i]));

		 //Step 7: Shuffle again Characters to increase uniquenes
		 $code = str_shuffle($code);
		 //print_r(strtoupper($code));
		 //Done and Return
		 return strtoupper($code);
	 
	}

	public function add_parking_voucher() {

		//$dc_id = $_REQUEST['dc_id'];
  		$data   = array(
             	'dc_name'     => $_REQUEST['dc_name'],
                'dc_amount'  		=> $_REQUEST['dc_amount'], 
              	'dc_desc'      => $_REQUEST['dc_desc'],                         
                'dccode'    => $_REQUEST['dccode'],
                'dc_status'    => 0,
           
     	);		

		$result = $this->voucher->add_vocher_model($data);  
		/*update code*/
		$generatecode = 10000 + $result;
		$dccode = $this->codeGenerator($generatecode);
  		$dataupdate   = array(                        
                'dccode'    => $dccode,
           
     	);
		$resultupdate = $this->voucher->update_voucher_model($result,$dataupdate);  
 		$response = array(

			'data' => $result,
			);

		echo json_encode($response);	

	}

	public function edit_parking_voucher() {

		$dc_id = $_REQUEST['dc_id'];
  		/*$data   = array(
             	'dc_name'     => $_REQUEST['dc_name'],
                'dc_amount'  		=> $_REQUEST['dc_amount'], 
              	'dc_desc'      => $_REQUEST['dc_desc'],                         
                'dccode'    => $_REQUEST['dccode'],
           
     	);	*/	

 		if(isset($_REQUEST['dc_name']))
			$data['dc_name'] = $_REQUEST['dc_name'];
		if(isset($_REQUEST['dc_amount']))
			$data['dc_amount'] = $_REQUEST['dc_amount'];
		if(isset($_REQUEST['dc_desc']))
			$data['dc_desc'] = $_REQUEST['dc_desc'];
		if(isset($_REQUEST['dccode']))
			$data['dccode'] = $_REQUEST['dccode'];
		if(isset($_REQUEST['dc_status']))
			$data['dc_status'] = $_REQUEST['dc_status'];


		$result = $this->voucher->update_voucher_model($dc_id,$data);    
		 		$response = array(

			'data' => $result,
			);

		echo json_encode($response);	

	}

	public function Voucher(){
		
		//GET Voucher Data
		$voucherresult = $this->voucher->voucher_details_model();
		

		$response = array(

			'data' => $voucherresult,
			);

		echo json_encode($response);
			 
	}

	public function Area(){
		
		/*GET Rates DATA*/
		$ratesresult = $this->area->area_details_model();

		$response = array(

			'data' => $ratesresult,
			);

		echo json_encode($response);
			 
	}
	public function Rates(){
		
		/*GET Rates DATA*/
		$ratesresult = $this->rate->get_rates_model();

		$response = array(

			'data' => $ratesresult,
			);

		echo json_encode($response);
			 
	}
	public function insert_auditlog()
	{

		$auditlog = array();

		if(isset($_REQUEST['terminal']))
			$auditlog['term_id'] = $_REQUEST['terminal'];	
		if(isset($_REQUEST['userid']))
			$auditlog['user_id'] = $_REQUEST['userid'];	


		$auditlog['function'] = $_REQUEST['function'];
		$auditlog['description'] = $_REQUEST['description'];
		$auditlog['ip'] = $_REQUEST['ip'];
		$auditlog['pcname'] = $_REQUEST['pcname'];
		
		$result = $this->auditlog->insert_auditlog_model($auditlog);
		$response = array(
			//'status' => "200",
			//'message' => "OK",
			'data' => $result,
		);	
		echo json_encode($response);
	}

	public function auditlog_details(){
		

		$users = $this->userinfo->userinfo_details_model();
		foreach ($users as $value) {	
			$users[$value['userid']] =  $value['firstname'] . ' ' . $value['lastname'];
		}		

		$result = $this->auditlog->auditlog_details_model();
		foreach ($result as $key => $field) {
			if($result[$key]["user_id"] == 0)
				$result[$key]['username'] = "";
			else	
				$result[$key]['username'] = $users[$result[$key]['user_id']];
						
		}



			$response = array(
			'data' => $result,
			);

		echo json_encode($response);
		
		
	}	


	public function check_user_exist(){
		$UserName     =  $_REQUEST['username'];
		$result = $this->userinfo->get_userinfo_exist($UserName);

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' => $result,
		
			);

		echo json_encode($response);
		 //echo $this->core->display_result_json($status, $message, $response);	
		
	}

	public function monitoring(){
		
		/*GET TERMINALS DATA*/
		$terminals = $this->terminal->get_terminals_model();
		foreach ($terminals as $value) {	
			$terminalname[$value['termID']] =  $value['termname'];
		}			

		//print_r($terminalname);

		$result = $this->transaction->Monitoring();
		//print_r($result);
		foreach ($result as $key => $field) {

				$result[$key]['entry_termid'] = $terminalname[$result[$key]['entry_termid']];

				if(isset($result[$key]['payment_termid']))
				{
					$result[$key]['payment_termid'] = $terminalname[$result[$key]['payment_termid']];
				}
				if(isset($result[$key]['exit_termid']))
				{
					$result[$key]['exit_termid'] = $terminalname[$result[$key]['exit_termid']];		
				}
						
		}

				//print_r($result);
				//print_r($result);
		//print_r();
			$response = array(

			'data' => $result,
			);

		echo json_encode($response);
		
		
	}	
	public function cardholder(){

		$result = $this->cardholder->card_holder_model();


		$response = array(
			'data' => $result,
		);

		echo json_encode($response);
	}

	public function insert_cardholder(){

		$transArray   =   array(
			'area_id'             =>   $_REQUEST['area_id'],
			'cardserial'             =>   $_REQUEST['cardserial'],
			'ratetype'               =>   $_REQUEST['ratetype'],
			'platenum'               =>   $_REQUEST['platenum'],
			'firstname'              =>   $_REQUEST['firstname'],
			'lastname'               =>   $_REQUEST['lastname'],
			'cardvalidity'           =>   $_REQUEST['cardvalidity'],				            		
		);

		$result = $this->cardholder->insert_cardholder_model($transArray);

		$response = array(
			'data' => $result,
		);
		echo json_encode($response);

	}

	public function get_cardholder(){
		$ID     =  $_REQUEST['id'];
		$result = $this->cardholder->get_cardholder_model($ID);

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' => $result,
		
			);

		echo json_encode($response);
		
		
	}
	public function update_cardholder(){


		$id = $_REQUEST['id'];
		$transArray   =   array(
			'area_id'             =>   $_REQUEST['area_id'],
			'cardserial'             =>   $_REQUEST['cardserial'],
			'ratetype'               =>   $_REQUEST['ratetype'],
			'platenum'               =>   $_REQUEST['platenum'],
			'firstname'              =>   $_REQUEST['firstname'],
			'lastname'               =>   $_REQUEST['lastname'],
			'cardvalidity'           =>   $_REQUEST['cardvalidity'],				            		
		);		


		$result = $this->cardholder->update_cardholder_model($id,$transArray);

		$response = array(
			'status' => "200",
			'message' => "OK",
			'data' => $result,
		
			);

		echo json_encode($response);
		
	}

	////////////////*SLOTS*////////////////////////////////////////////////////

	public function download_page($AreaID){



		$AreaDetails = $this->area->get_area_details($AreaID);


		$pgsip = $AreaDetails[0]["pgsip"];
		$username=$AreaDetails[0]["pgsusername"];
		$password=$AreaDetails[0]["pgspassword"];
		$URL="http://" . $pgsip . "/PSIA/Custom/SelfExt/ContentMgmt/Traffic/ChanRunStatus";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$URL);
		curl_setopt($ch, CURLOPT_TIMEOUT, 1); //timeout after 30 seconds
		curl_setopt($ch, CURLOPT_MAXREDIRS, 1); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
		$result=curl_exec ($ch);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
		curl_close ($ch);
		return array($status_code, $result);
	    //return $status_code,$result;
	}


	public function get_slots()
	{
		$AreaID     =  $_REQUEST['areaid'];

		$data1 = array();


		list($statuscode,$sXML) = $this->download_page($AreaID);

		if($statuscode == 200)
		{
			$oXML = new SimpleXMLElement($sXML);

			$slot = $this->slot->get_slot_details();
			foreach ($slot as $floor) {	
				//print_r($floor);
				$slotcount = 0;
				$occupiedslot = 0;
				foreach($oXML->xpath('//parkingStatus') as $child){
					//print_r($child->parkingStatusList->parkingStatus->parkNum);
					if(strpos(strtoupper($child->parkNum), strtoupper($floor['floor'])) !==false)
					{
						//print_r($child->licensePlate);
						if(strtoupper($child->licensePlate) != "")
						{
							$occupiedslot++;
						}
						$slotcount++;
					}

			    	
				}
				$data1[$floor['floor']] = array('slotcount' => $slotcount,'occupiedslot' => $occupiedslot,"description" => $floor['description']);
			}			

			//print_r($data);

		}
		else
		{
			$data1['TOTAL COUNT'] = array('slotcount' => 0,'occupiedslot' => 0,"description" => "TOTAL COUNT");

		}
	
		$response = array(
		
			'data' => $data1,
		
			);

		echo json_encode($response);


	}
/*######SYNCHING DATABASE###################################*/
	public function gettransactiondata(){
		
		$result = $this->transaction->Monitoring();
		if(!empty($result)) 
			echo json_encode($result[0]);
		else
			echo json_encode($result);
			
	}
	public function deletetransactiondata(){	
		$ParkID = $_REQUEST['park_id'];

		$result = $this->transaction->DeleteTransaction($ParkID);
		echo json_encode($result);
			
	}

	public function deletetpaymentdata(){	
		$ParkID = $_REQUEST['park_id'];
		$result = $this->payment->deletepayment($ParkID);
		echo json_encode($result);
			
	}
	public function deletetautopaydata(){	
		$AutoID = $_REQUEST['autopay_id'];
		$result = $this->autoload->deleteautopay($AutoID);
		echo json_encode($result);
			
	}
	public function deletetellerlogdata(){	
		$TellerLogID = $_REQUEST['tellerlogid'];
		$result = $this->tellerlog->deletetellerlog($TellerLogID);
		echo json_encode($result);
			
	}
	public function getsyncautoload(){		
		$result = $this->autoload->getsyncautoloadprocess();
		if(!empty($result)) 
			echo json_encode($result[0]);
		else
			echo json_encode($result);
			
	}

	public function getsynctransaction(){		
		$result = $this->transaction->getsynctransactionprocess();

		if(!empty($result)) 
			echo json_encode($result[0]);
		else
			echo json_encode($result);
			
	}
	public function getsynctellerlog(){		
		$result = $this->tellerlog->getsynctellerlogprocess();

		if(count($result)>0)
			echo json_encode($result[0]);
		else
			echo json_encode($result);

		//echo json_encode($result[0]);
			
	}

	public function getsyncpayment(){		
		$result = $this->payment->getsyncpaymentprocess();
		if(count($result)>0)
			echo json_encode($result[0]);
		else
			echo json_encode($result);
			
	}
	public function getsyncuser(){		
		$result = $this->userinfo->getsyncuserprocess();
		echo json_encode($result);
			
	}
	public function getsyncrate(){		
		$result = $this->rate->get_rates_model();
		echo json_encode($result);
		//if(count($result)>0)
		//	echo json_encode($result[0]);
		//else
		//	echo json_encode($result);
			
	}
	public function getsynccardholder(){		
		$result = $this->cardholder->card_holder_model();
		echo json_encode($result);
		/*if(count($result)>0)
			echo json_encode($result[0]);
		else
			echo json_encode($result);*/
			
	}
	public function getsyncvoucher(){		
		$result = $this->voucher->voucher_model();
		echo json_encode($result);
		/*if(count($result)>0)
			echo json_encode($result[0]);
		else
			echo json_encode($result);*/
			
	}

	

	public function replace_parking_users() { 

  		$data   = array(
  				'userid'     => $_REQUEST['userid'],
             	'firstname'     => $_REQUEST['firstname'],
              	'lastname'      => $_REQUEST['lastname'],                         
                'username'    => $_REQUEST['username'],
                'password'       => $_REQUEST['password'],
                'userlevel'     => $_REQUEST['userlevel'],  
                'mag_data'     => $_REQUEST['mag_data'], 
                'logindate'     => $_REQUEST['logindate'], 
                'last_pc'     => $_REQUEST['last_pc'], 
                'loginstatus'     => $_REQUEST['loginstatus'], 
                'status'     => $_REQUEST['status'], 
                'cardserial'     => $_REQUEST['cardserial'], 
                'valetstatus'     => $_REQUEST['valetstatus'], 
                'date_modified'     => $_REQUEST['date_modified'], 
                'date_created'     => $_REQUEST['date_created'], 

		);		




  		$this->userinfo->delete_userinfo_model($_REQUEST['userid']);
  		
		//$result = $this->userinfo->replace_userinfo_model($data);  
  		$result = $this->userinfo->add_userinfo_model($data);  
		$response = array(
			'status' => "200",
			'message' => "OK",
		);

		echo json_encode($response);

	
	}


	public function replace_parking_rates() { 

  		$data   = array(
  				'rate_id'     => $_REQUEST['rate_id'],
             	'member_type'     => $_REQUEST['member_type'],
              	'rate_code'      => $_REQUEST['rate_code'],                         
                'area_id'    => $_REQUEST['area_id'],
                'initcharge_hour'       => $_REQUEST['initcharge_hour'],
                'initcharge'     => $_REQUEST['initcharge'],  
                'succharge_hour'     => $_REQUEST['succharge_hour'], 
                'succharge'     => $_REQUEST['succharge'], 
                'oncharge'     => $_REQUEST['oncharge'], 
                'lostcharge'     => $_REQUEST['lostcharge'], 
                'discount'     => $_REQUEST['discount'], 
                'rate_status'     => $_REQUEST['rate_status'], 
                'date_modified'     => $_REQUEST['date_modified'], 


		);		



		$result = $this->rate->replace_rates_model($data);  

		$response = array(
			'status' => "200",
			'message' => "OK",
		);

		echo json_encode($response);

	
	}
	public function replace_cardholders() { 

  		$data   = array(
  				'cardholder_id'     => $_REQUEST['cardholder_id'],
             	'cardserial'     => $_REQUEST['cardserial'],
              	'date_created'      => $_REQUEST['date_created'],                         
                'ratetype'    => $_REQUEST['ratetype'],
                'area_id'       => $_REQUEST['area_id'],
                'platenum'     => $_REQUEST['platenum'],  
                'firstname'     => $_REQUEST['firstname'], 
                'lastname'     => $_REQUEST['lastname'], 
                'cardvalidity'     => $_REQUEST['cardvalidity'], 
                'card_status'     => $_REQUEST['card_status'],                

		);		


		$result = $this->cardholder->replace_cardholder_model($data);  
		$response = array(
			'status' => "200",
			'message' => "OK",
		);

		echo json_encode($response);

	
	}

	public function replace_voucher() { 

  		$data   = array(
  				'dc_id'     => $_REQUEST['dc_id'],
             	'dc_name'     => $_REQUEST['dc_name'],
              	'dc_amount'      => $_REQUEST['dc_amount'],                         
                'dc_desc'    => $_REQUEST['dc_desc'],
                'dccode'       => $_REQUEST['dccode'],
                'dc_status'     => $_REQUEST['dc_status'],  
                             

		);		

		$result = $this->voucher->replace_voucher_model($data);  
		$response = array(
			'status' => "200",
			'message' => "OK",
		);

		echo json_encode($response);

	
	}



	public function inserttellerlogdata() {

		date_default_timezone_set('Asia/Singapore');
		$transArray   =   	array(
							'tellerlogid'         =>   $_REQUEST['tellerlogid'],
							'tellerid'        	  =>   $_REQUEST['tellerid'],
							'logindate'        	  =>   $_REQUEST['logindate'],
							'logoutdate'       	  =>   $_REQUEST['logoutdate'],
							'terminalid'          =>   $_REQUEST['terminalid'],
							'loginarea_id'        =>   $_REQUEST['loginarea_id'],
							'status'              =>   $_REQUEST['status'],
							'date_modified'       =>   $_REQUEST['date_modified'],
							'startcash'     	  =>   $_REQUEST['startcash'],


		);


		$this->tellerlog->replace_tellerlog_model($transArray);

		$response = array(
			'status' => "200",
			'message' => "OK",
			);

		echo json_encode($response);
	}

	/*REPORT C#*/
	public function transaction_total_xreading() {
		$terminal = $_REQUEST['terminal'];
		$from_date = $_REQUEST['from_date'];
		$to_date = $_REQUEST['to_date'];
		$tellerid = $_REQUEST['tellerid'];
		
		//$tellerid = 4;
		//$terminal = 4;
		//$from_date = "2025-02-21 00:00:00";
		//$to_date = "2025-02-21 23:59:9";

		
		$oldreceipt = $this->transaction->transaction_oldreceipt_model($terminal);

		$resultold = $this->transaction->transaction_oldtotal_model($terminal,$from_date);

		//print_r($resultold[0]["oldtotal"]);



		$result = $this->transaction->transaction_total_xreading_model($terminal,$tellerid,$from_date,$to_date);
		//print_r("<br/>");

		if(!isset($resultold[0]["oldtotal"]))
			$resultold[0]["oldtotal"] = 0;

		$result[0]["oldmin_or"] = $oldreceipt[0]["oldmin_or"];
		$result[0]["oldtotal"] = $resultold[0]["oldtotal"];
		$result[0]["oldcount"] = $resultold[0]["oldcount"];



		if(!isset($result[0]["min_void"]))
			$result[0]["min_void"] = $oldreceipt[0]["oldmin_void"];
		if(!isset($result[0]["max_void"]))
			$result[0]["max_void"] = $oldreceipt[0]["oldmax_void"];
		if(!isset($result[0]["min_refund"]))
			$result[0]["min_refund"] = $oldreceipt[0]["oldmin_refund"];
		if(!isset($result[0]["max_refund"]))
			$result[0]["max_refund"] = $oldreceipt[0]["oldmax_refund"];



		//print_r($result);
	




		if(count($result)>0)
			echo json_encode($result[0]);
		else
			echo json_encode($result);
		//echo json_encode($transactionDetails);

	}

	public function transaction_total_zreading() {
		$terminal = $_REQUEST['terminal'];
		$from_date = $_REQUEST['from_date'];
		$to_date = $_REQUEST['to_date'];
		

		//$terminal = 4;
		//$from_date = "2025-02-20 00:00:00";
		//$to_date = "2025-02-20 23:59:9";


 
                


		
		
		$oldreceipt = $this->transaction->transaction_oldreceipt_model($terminal);

		$resultold = $this->transaction->transaction_oldtotal_model($terminal,$from_date);
		


		$datedetails = $this->transaction->transaction_getdate_model($terminal,$to_date);

		$datediff =strtotime($datedetails[0]["maxpaydate"]) - strtotime($datedetails[0]["minpaydate"]) ;
		$datecount =  round($datediff / (60 * 60 * 24)) + 1;
	




		$result = $this->transaction->transaction_total_model($terminal,$from_date,$to_date);
		//print_r("<br/>");

		if(!isset($resultold[0]["oldtotal"]))
			$resultold[0]["oldtotal"] = 0;

		//$result[0]["tcount"] = $datedetails[0]["tcount"];
		//$result[0]["min_void"] = $oldreceipt[0]["oldmin_void"];
		//$result[0]["oldmin_or"] = $oldreceipt[0]["oldmin_or"];
		$result[0]["oldtotal"] = $resultold[0]["oldtotal"];
		//$result[0]["oldcount"] = $resultold[0]["oldcount"];
		$result[0]["datecount"] = $datecount;




		//if(!isset($result[0]["max_void"]))
		//	$result[0]["max_void"] = $oldreceipt[0]["oldmax_void"];
		//if(!isset($result[0]["min_refund"]))
		//	$result[0]["min_refund"] = $oldreceipt[0]["oldmin_refund"];
		//if(!isset($result[0]["max_refund"]))
		//	$result[0]["max_refund"] = $oldreceipt[0]["oldmax_refund"];



		//print_r($result);
	




		if(count($result)>0)
			echo json_encode($result[0]);
		else
			echo json_encode($result);
	

	}

	public function transaction_total_c() {
		$terminal = $_REQUEST['terminal'];
		$from_date = $_REQUEST['from_date'];
		$to_date = $_REQUEST['to_date'];
		
		//$terminal = 2;
		//$from_date = "2025-02-17 00:00:00";
		//$to_date = "2025-02-17 23:59:9";

		
		$oldreceipt = $this->transaction->transaction_oldreceipt_model($terminal);

		$resultold = $this->transaction->transaction_oldtotal_model($terminal,$from_date);

		//print_r($resultold[0]["oldtotal"]);



		$result = $this->transaction->transaction_total_model($terminal,$from_date,$to_date);
		//print_r("<br/>");

		if(!isset($resultold[0]["oldtotal"]))
			$resultold[0]["oldtotal"] = 0;

		$result[0]["oldmin_or"] = $oldreceipt[0]["oldmin_or"];
		$result[0]["oldtotal"] = $resultold[0]["oldtotal"];
		$result[0]["oldcount"] = $resultold[0]["oldcount"];



		if(!isset($result[0]["min_void"]))
			$result[0]["min_void"] = $oldreceipt[0]["oldmin_void"];
		if(!isset($result[0]["max_void"]))
			$result[0]["max_void"] = $oldreceipt[0]["oldmax_void"];
		if(!isset($result[0]["min_refund"]))
			$result[0]["min_refund"] = $oldreceipt[0]["oldmin_refund"];
		if(!isset($result[0]["max_refund"]))
			$result[0]["max_refund"] = $oldreceipt[0]["oldmax_refund"];



		//print_r($result);
	




		if(count($result)>0)
			echo json_encode($result[0]);
		else
			echo json_encode($result);
		//echo json_encode($transactionDetails);

	}






	

	public function tellerlog_byterminal_c()
	{
		$terminal = $_REQUEST['terminal'];
		$from_date = $_REQUEST['from_date'];
		$to_date = $_REQUEST['to_date'];
		$area = $_REQUEST['area'];


		/*GET TERMINALS DATA*/
		$terminals = $this->terminal->get_terminals_model();
		foreach ($terminals as $value) {	
			$terminalname[$value['termID']] =  $value['termname'];
		}	

		$result = $this->tellerlog->tellerlog_byterminal_model($terminal,$from_date,$to_date,$area);

		foreach ($result as $key => $field) {

				$result[$key]['terminalname'] = $terminalname[$result[$key]['terminalid']];						
		}



		echo json_encode($result);


	}
	public function transaction_groupbyrate_xread() {
		$tellerid = $_REQUEST['tellerid'];
		$terminal = $_REQUEST['terminal'];
		$from_date = $_REQUEST['from_date'];
		$to_date = $_REQUEST['to_date'];
		$area = $_REQUEST['area'];


		//$area = 0;
		//$terminal =2;
		//$from_date = '2024-11-06 14:10:13';
		//$to_date = '2025-01-30 11:25:49';
		//$tellerid = 4;



		$rates = $this->rate->get_rates_model();
		foreach ($rates as $value) {	
			$ratesname[$value['rate_id']] =  $value['rate_code'];
		}	

		//print_r($ratesname);


		$result = $this->transaction->transaction_groupbyrate_void_model($terminal,$tellerid,$from_date,$to_date,$area);
		foreach ($result as $key => $field) {

			$result[$key]['ratetype'] = $ratesname[$result[$key]['ratetype']];
			//print_r($result[$key]['ratetype'])
		}
	

		echo json_encode($result);
		//echo json_encode($transactionDetails);

	}

	public function transaction_groupbyrate_zread() {
		$terminal = $_REQUEST['terminal'];
		$from_date = $_REQUEST['from_date'];
		$to_date = $_REQUEST['to_date'];
		$area = $_REQUEST['area'];


		//$area = 0;
		//$terminal = 4;
		//$from_date = '2024-11-06 14:10:13';
		//$to_date = '2026-01-30 11:25:49';


                //min(DATE_FORMAT($this->tbl_payment.paymentdate, '%Y-%m-%d')) as minpaydate,




		$rates = $this->rate->get_rates_model();
		foreach ($rates as $value) {	
			$ratesname[$value['rate_id']] =  $value['rate_code'];
		}	

		//print_r($ratesname);


		$result = $this->transaction->transaction_groupbyrate_zreading_model($terminal,$from_date,$to_date,$area);
		foreach ($result as $key => $field) {

			$result[$key]['ratetype'] = $ratesname[$result[$key]['ratetype']];
			//print_r($result[$key]['ratetype'])
		}
	

		echo json_encode($result);
		//echo json_encode($transactionDetails);

	}



		
}
?>
