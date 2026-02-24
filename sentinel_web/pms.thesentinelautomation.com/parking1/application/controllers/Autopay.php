<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autopay extends CI_Controller {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('functions');

		//Auth::test();

		if(!Auth::is_loggedin())
			Auth::Bounce($this->uri->uri_string());
	}

	public function index()
	{
		
		//get terminals
		/*$url = rtrim(api_url(), "/")."menu_details";
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);
		$data["menu"] = $json_data["data"];*/

	


		$data['title'] = 'Dashboard';
		$data['page'] = 'Autopay';
		$data['fname'] = $this->session->userdata('firstname');
		$data['lname'] = $this->session->userdata('lastname');



		//$this->load->view('template', $data);
		//$this->load->view('template');

		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		//$this->load->view('components/cards');
		$this->load->view('pages/autopay_view');
	}
	public function getautopaydata()
	{

		$response = array();
		$autopaydata = array();



		$bills = [1000,500,200,100,50,20];
		$coins = [10,5,1];
		$count=1;
		$recievetotal = [0,0,0,0,0,0];
		$changebilltotal = [0,0,0,0,0,0];
		$changecointotal = [0,0,0];

		//$php1000 = 0;$php500 = 0;$php200 = 0;$php100 = 0;$php50 = 0;$php20 = 0;


		$login_data = $this->functions->apiv1(array(),"autopay_getlogindetails");
		foreach ($login_data as  $value) {
			$autopaydata['termname'] =  $value["termname"];
			if(!isset($value["logoutdate"])) $value["logoutdate"] = date("Y-m-d 23:59:59");;

			$tellerdata =  array(
				'tellerlogid'	=> $value["tellerlogid"],
				'terminal'	=> $value["terminalid"],
				'from_date'	=> $value["logindate"],
				'to_date'     => $value["logoutdate"],    
			);


			$data_autoload = $this->functions->apiv1($tellerdata,"get_autopay");
			$data_autoload = $data_autoload[0];
			//print_r($data_autoload);
			//print_r("<br/>");

			$data_record = $this->functions->apiv1($tellerdata,"records_byteller");
			foreach($data_record as $record){
				$receivearr = explode(",", $record['recieved']);			
				
					foreach($receivearr as $x => $val) {
					  	$recievetotal[$x] += $val * $bills[$x];
					}

					$changearr = explode(",", $record['changebill']);

					foreach($changearr as $x => $val) {
					  	$changebilltotal[$x] += $val * $bills[$x];
					}

					$changecoinarr = explode(",", $record['changecoin']);

					foreach($changecoinarr as $x => $val) {
					  	$changecointotal[$x] += $val * $coins[$x];
					}
			

			}

					$autopaydata['lphp1000'] =  $data_autoload['php1000'];
					$autopaydata['lphp500'] =  $data_autoload['php500'];
					$autopaydata['lphp200'] =  $data_autoload['php200'];
					$autopaydata['lphp100'] =  $data_autoload['php100'];
					$autopaydata['lphp50'] =  $data_autoload['php50'];
					$autopaydata['lphp20'] =  $data_autoload['php20'];
					$autopaydata['lphp10'] =  $data_autoload['php10']; 
					$autopaydata['lphp5'] =  $data_autoload['php5'];
					$autopaydata['lphp1'] =  $data_autoload['php1']; 

					$autopaydata['rphp1000'] =  $recievetotal[0];
					$autopaydata['rphp500'] =  $recievetotal[1];
					$autopaydata['rphp200'] =  $recievetotal[2];
					$autopaydata['rphp100'] =  $recievetotal[3];
					$autopaydata['rphp50'] =  $recievetotal[4];
					$autopaydata['rphp20'] =  $recievetotal[5];

				
					$autopaydata['cphp1000'] =  $changebilltotal[0];
					$autopaydata['cphp500'] =  $changebilltotal[1];
					$autopaydata['cphp200'] =  $changebilltotal[2];
					$autopaydata['cphp100'] =  $changebilltotal[3];
					$autopaydata['cphp50'] =  $changebilltotal[4];
					$autopaydata['cphp20'] =  $changebilltotal[5];
					$autopaydata['cphp10'] =  $changecointotal[0];
					$autopaydata['cphp5'] =  $changecointotal[1];
					$autopaydata['cphp1'] =  $changecointotal[2];


					//$autopaydata['php1000'] =  $data_autoload['php1000'] + $recievetotal[0] - $changebilltotal[0];
					//$autopaydata['php500'] =  $data_autoload['php500'] + $recievetotal[1] - $changebilltotal[1];
					//$autopaydata['php200'] =  $data_autoload['php200'] + $recievetotal[2] - $changebilltotal[2];
					//$autopaydata['php100'] =  $data_autoload['php100'] + $recievetotal[3] - $changebilltotal[3];
					//$autopaydata['php50'] =  $data_autoload['php50'] + $recievetotal[4] - $changebilltotal[4];
					//$autopaydata['php20'] =  $data_autoload['php20'] + $recievetotal[5] - $changebilltotal[5];
					//$autopaydata['php10'] =  $data_autoload['php20'] - $changecointotal[0]; 
					//$autopaydata['php5'] =  $data_autoload['php20'] - $changecointotal[1];
					//$autopaydata['php1'] =  $data_autoload['php20'] - $changecointotal[2]; 

					$response[] = $autopaydata;
													
			
		}

		//print_r($autopaydata);

	
		echo json_encode($response);
		/*$string = '[{"tickers":"AAPL","dates":"2021-06-05","authors":" Someone","contents":"Financial report for AAPL containing financials, sentiment, and portfolio metrics","urls":"report/aapl-financial-report.html"},{"tickers":"GOOG","dates":"2021-06-05","authors":" Someone","contents":"Financial report for GOOG containing financials, sentiment, and portfolio metrics","urls":"report/goog-financial-report.html"},{"tickers":"NFLX","dates":"2021-06-01","authors":" Someone","contents":"Financial report for NFLX containing financials, sentiment, and portfolio metrics","urls":"report/nflx-financial-report.html"},{"tickers":"AMZN","dates":"2021-06-01","authors":" Someone","contents":"Financial report for AMZN containing financials, sentiment, and portfolio metrics","urls":"report/amzn-financial-report.html"}]';

		// Convert the string to a JSON object
	$json_object = json_decode($string, true);
	print_r(json_encode($response));
	//echo json_encode($json_object);
	//print_r($json_object);*/

	}

}














