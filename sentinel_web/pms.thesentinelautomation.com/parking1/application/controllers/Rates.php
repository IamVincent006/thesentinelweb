<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rates extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('functions');
		
		if(!Auth::is_loggedin())
			Auth::Bounce($this->uri->uri_string());
	}

	public function index()
	{
		//get menu*/
		/*$auditsend = array();
		$json = $this->functions->apiv1($auditsend,"menu_details");
		$data["menu"] = $json;*/
		
		/**/
		$data['title'] = 'Dashboard';
		$data['page'] = 'Rates';
		$data['fname'] = $this->session->userdata('firstname');
		$data['lname'] = $this->session->userdata('lastname');

		/**/
		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		$this->load->view('pages/rates_view');
	}

	public function addrate()
	{


		$this->load->helper(array('form', 'url'));
	    $this->load->library('form_validation');
		$data['rate_code'] = $this->input->post('rate_code');	
		$data['inithour'] = $this->input->post('inithour');
		$data['initcharge'] = $this->input->post('initcharge');
		$data['suchour'] = $this->input->post('suchour');
		$data['succharge'] = $this->input->post('succharge');
		$data['oncharge'] = $this->input->post('oncharge');
		$data['lostcharge'] = $this->input->post('lostcharge');
		$data['type'] = $this->input->post('type');	
		$data['discount'] = $this->input->post('discount');	

	    if ($this->input->post('submit')) 
    	{

    		$this->form_validation->set_rules('rate_code', 'Rate Code', 'discount');
			$this->form_validation->set_rules('rate_code', 'Rate Code', 'required');
			$this->form_validation->set_rules('inithour', 'Initial Hour', 'required|numeric');
    		$this->form_validation->set_rules('initcharge', 'Initial Charge', 'required|numeric');
    		$this->form_validation->set_rules('suchour', 'Succeding Hour', 'required|numeric');
    		$this->form_validation->set_rules('succharge', 'Succeding Charge', 'required|numeric');
    		$this->form_validation->set_rules('oncharge', 'Overnight Charge', 'required|numeric');
    		$this->form_validation->set_rules('lostcharge', 'Lost Charge', 'required|numeric');
    		$this->form_validation->set_rules('type', 'Type', 'required|numeric');
	
			if($this->form_validation->run() == TRUE)
			{

			
				$area_id   =   $this->input->post('termarea');
				$rate_code   =   $this->input->post('rate_code');
				$inithour   =   $this->input->post('inithour');
				$initcharge   =   $this->input->post('initcharge');
				$suchour   =   $this->input->post('suchour');
				$succharge   =   $this->input->post('succharge');
				$oncharge   =   $this->input->post('oncharge');
				$lostcharge   =   $this->input->post('lostcharge');
				$type   =   $this->input->post('type');
				$discount   =   $this->input->post('discount');
			

				$datasend =  array(
						  'area_id'     => $area_id,
				          'rate_code'     => $rate_code,
                          'inithour'     => $inithour,                         
                          'initcharge'     => $initcharge,
                          'suchour'     => $suchour,
                          'succharge'       => $succharge,
                          'oncharge'         => $oncharge,
                          'lostcharge'  => $lostcharge,
                          'type'  => $type,	
                          'discount'  => $discount,				    
				);

		
				$result = $this->functions->apiv1($datasend,"add_parking_rates");
				


				/*inserlog*/
     			//'pcname' => gethostname(),

				$audit_data = "";
				//$audit_term = gethostbyaddr($_SERVER['REMOTE_ADDR']);
				$audit_term = gethostname();
				$audit_ip = $_SERVER['REMOTE_ADDR'];

				foreach ($datasend as $key => $value) {

						$audit_data .= "$key: ".$value.'<br/>';
				}


				$auditsend = array(
				  'function'   => 'RATES ADDED',
				  'description'=> $audit_data,
				  'userid'     => $this->session->userdata('userid'),
				  'ip'   => getenv("REMOTE_ADDR"),
				  'pcname' => $audit_term,
				);

				$result = $this->functions->apiv1($auditsend,"insert_auditlog");

				$link = base_url().'rates';
				echo "<script type='text/javascript'>alert('add successful');window.location = ('$link') </script>";
                         
			}
      
			
    	}


		/*get area*/
		$auditsend = array();
		$json = $this->functions->apiv1($auditsend,"area_details");
		$data["termarea"] = $json;



		/*get menu*/
		/*$auditsend = array();
		$json = $this->functions->apiv1($auditsend,"menu_details");
		$data["menu"] = $json;*/

		
		$data['title'] = 'Dashboard';
		$data['page'] = 'Add Rates';
		$data['fname'] = 'Juan';
		$data['lname'] = 'Dela Cruz';


		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		//$this->load->view('components/cards');
		$this->load->view('pages/addrate_view');
	}

	public function editrate($id)
	{
		/*get area*/
		$auditsend = array();
		$json = $this->functions->apiv1($auditsend,"area_details");
		$data["termarea"] = $json;

    	/*get menus*/
		/*$auditsend = array();
		$json = $this->functions->apiv1($auditsend,"menu_details");
		$data["menu"] = $json;*/

		/*get rate*/
		$auditsend = array();
		$json = $this->functions->apiv1($auditsend,"get_parking_rates&rate_id=$id");
		$userdata = $json[0];
		$data["query"] = $userdata;


		$data['title'] = 'Dashboard';
		$data['page'] = 'Edit Rates';
		$data['fname'] = 'Juan';
		$data['lname'] = 'Dela Cruz';

	 
		$this->load->helper(array('form', 'url'));
	    $this->load->library('form_validation');



	    if ($this->input->post('submit')) 
    	{ 
    	
			$this->form_validation->set_rules('rate_code', 'Rate Code', 'required');
			$this->form_validation->set_rules('inithour', 'Initial Hour', 'numeric');
    
	
			if($this->form_validation->run() == TRUE)
			{

			
				$rate_code   =   $this->input->post('rate_code');
				$inithour   =   $this->input->post('inithour');
				$initcharge   =   $this->input->post('initcharge');
				$suchour   =   $this->input->post('suchour');
				$succharge   =   $this->input->post('succharge');
				$oncharge   =   $this->input->post('oncharge');
				$lostcharge   =   $this->input->post('lostcharge');
				$type   =   $this->input->post('type');
				$discount   =   $this->input->post('discount');
				$rate_status   =   $this->input->post('rate_status');
			
				$datasend =array(
				    	  'rate_id'     => $id,
				          'rate_code'     => $rate_code,
                          'initcharge_hour'     => $inithour,                         
                          'initcharge'     => $initcharge,
                          'succharge_hour'     => $suchour,
                          'succharge'       => $succharge,
                          'oncharge'         => $oncharge,
                          'lostcharge'  => $lostcharge,
                          'member_type'  => $type,
                          'discount'  => $discount,
                          'rate_status'  => $rate_status,

				);

				//print_r($datasend);
				$result = $this->functions->apiv1($datasend,"edit_parking_rates");

				$audit_data = "";
				$audit_data .= 'userid: '.$id.'<br/>';
				$audit_term = gethostname();
				//$audit_term = gethostbyaddr($_SERVER['REMOTE_ADDR']);
				$audit_ip = $_SERVER['REMOTE_ADDR'];

				foreach ($userdata as $key => $value) {
					if(isset($datasend[$key]))
						if($datasend[$key] != $value)
							$audit_data .= "$key: ".$value.' to '.$datasend[$key].'<br/>';
				}
				//print_r($audit_data);
				$auditsend = array(
					'function'   => 'RATE EDIT',
				    'description'=> $audit_data,
				    'userid'     => $this->session->userdata('userid'),
				    'ip'   => getenv("REMOTE_ADDR"),
		  			'pcname' => $audit_term,
				);

				$result = $this->functions->apiv1($auditsend,"insert_auditlog");

				
 				$link = base_url().'rates';

 				echo "<script type='text/javascript'>alert('update successful');window.location = ('$link') </script>";
				

			
                         
			}
      

			
    	}
		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		$this->load->view('pages/editrate_view');

	}

}