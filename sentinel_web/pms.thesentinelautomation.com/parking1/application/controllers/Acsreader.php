<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acsreader extends CI_Controller {

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
		
	
	}
	public function getserial()
	{
		$cardserial = '';

		$messageValue = "FFCA000000"; // it is a string with hexadecimal format

		$context = scard_establish_context();
		$readers = scard_list_readers($context);

		if($readers){
			
		


				$connection = scard_connect($context, $readers[1], 2);



				if($connection){
					$res = scard_transmit($connection, $messageValue);

					//$cardserial = $res;

					$status = substr($res, -4);
					if($status = "9000")
					{
						$cardserial = substr($res, 0, -4);
						$error = 0;
					}
					else
					{
						$cardserial = "";
						$error = 0;
					}
				

					scard_release_context($context);
				}
				else
				{
					$cardserial = "";
					$error = 0;
				}

		}
		else
		{
			$error = 1;
		}


		//print_r($cardserial);
		$response = array(
				'error' =>   $error,	
				'cardserial' =>   $cardserial,								
		);
		echo json_encode($response);
	}

	function convert_rtc($hex_rtc) {
	    $rtc = array_map(
	        'hexdec',
	        str_split($hex_rtc, 2)
	    );
	    return $rtc;
	}


	function initreader(){
		
		$context = scard_establish_context();
		//$readers = scard_list_readers($context);
		
		return $context;

	}

	function auth1($context)
	{
		$verify = "FF82002006";
		$pass = "FFFFFFFFFFFF"; // decimal to hex
		//119632
		$verify .= $pass; 
		$readers = scard_list_readers($context);
		if($readers){
			$connection = scard_connect($context, $readers[1]);
			$res = scard_transmit($connection, $verify);
		}
		return $res;



	}
	function auth2($context)
	{

		$verify = "FF860000050100";
		$data = "0B6020"; // decimal to hex
		//119632
		$verify .= $data;
		//print_r($verify); 
		$readers = scard_list_readers($context);
		if($readers){
			$connection = scard_connect($context, $readers[1]);
			$res = scard_transmit($connection, $verify);
		}
		return $res;


	}

	function verifypass2($context)
	{

		$res = $this->auth1($context);
		//print_r($res);
		$res = $this->auth2($context);
		//print_r($res);
		return $res;

	}


	function verifypass($context)
	{


		$verify = "FF860000050100";
		$data = "0B6020"; // decimal to hex
		//119632
		$verify .= $data; 
		$readers = scard_list_readers($context);
		if($readers){
			$connection = scard_connect($context, $readers[1]);
			$res = scard_transmit($connection, $verify);
		}
		return $res;

	}
	public function accessbits($context){
			//$key = "60";   //ACR122_KEYTYPE_A = 96, ACR122_KEYTYPE_B = 97,

		//$this->verify();

		$sector = 2;
		$sectoradd = (($sector * 4) + 3);


		$valuesend = "FFB000";
		$data = "0B10"; // decimal to hex
		//119632
		$valuesend .= $data; 
	

		//$context = $this->initreader();
		$readers = scard_list_readers($context);

		if($readers){
			$connection = scard_connect($context, $readers[1], 2);
		
			$res = scard_transmit($connection, $valuesend);
			//scard_release_context($context);
		
		}
		return $res;

	}
	public function bitsadd($context){
		$this->verifypass2($context);
		$res = $this->accessbits($context);


		$status = substr($res, -4);
	
		if($status = "9000")
		{

			$res = substr($res, 0, -4);
		}
		else
		{
			$res = "";
		}
		//print_r($res);

		return $res;

	}
	public function updatepassword(){

		$context = $this->initreader();
		$bitsdata = $this->bitsadd($context);

		//print_r($bitsdata);

		//$keyb = substr($bitsdata, -12);
		//$bitsdata = substr($bitsdata, 0, -12);
		$bitsadd = substr($bitsdata, 12, -12);
		//$bitsdata = substr($bitsdata, 0, -12);		
		//$keya = substr($bitsdata, -12);



		$valuesend = "FFD600";
		$data = "0B10"; // decimal to hex
		$keyapass = "FFFFFFFFFFFF";
		//119632
		$valuesend .= $data . $keyapass; 

		$valuesend2 = "";
		$keybpass = "FFFFFFFFFFFF";
		$valuesend2 .= $bitsadd . $keybpass;

		//print_r($valuesend . $valuesend2);

		$readers = scard_list_readers($context);

		if($readers){
			$connection = scard_connect($context, $readers[1], 2);
		
			$res = scard_transmit($connection, $valuesend . $valuesend2);
			
		
		}


		//scard_release_context($context);



		echo json_encode($res);
	}


}





















