<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends CI_Controller {

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




		/**/
		$data['title'] = 'Dashboard';
		$data['page'] = 'Area';
		$data['fname'] = $this->session->userdata('firstname');
		$data['lname'] = $this->session->userdata('lastname');

		/**/
		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		$this->load->view('pages/area_view');
	
	}

	public function addarea()
	{

		$this->load->helper(array('form', 'url'));
	    $this->load->library('form_validation');

		$data['area_code'] = $this->input->post('area_code');	
		$data['area_name'] = $this->input->post('area_name');
		$data['payment_gracehour'] = $this->input->post('payment_gracehour');
		$data['payment_graceminute'] = $this->input->post('payment_graceminute');
		$data['entry_gracehour'] = $this->input->post('entry_gracehour');
		$data['entry_graceminute'] = $this->input->post('entry_graceminute');
		$data['cutoffhour'] = $this->input->post('cutoffhour');
		$data['cutoffminute'] = $this->input->post('cutoffminute');	

	    if ($this->input->post('submit')) 
    	{ 
    	
			$this->form_validation->set_rules('area_code', 'Area Code', 'required');
    
	
			if($this->form_validation->run() == TRUE)
			{

			
				$area_code   =   $this->input->post('area_code');
				$area_name   =   $this->input->post('area_name');
				$payment_gracehour   =   $this->input->post('payment_gracehour');
				$payment_graceminute   =   $this->input->post('payment_graceminute');
				$entry_gracehour   =   $this->input->post('entry_gracehour');
				$entry_graceminute   =   $this->input->post('entry_graceminute');
				$cutoffhour   =   $this->input->post('cutoffhour');
				$cutoffminute   =   $this->input->post('cutoffminute');
			
				$datasend =array(
				          'area_code'     => $area_code,
                          'area_name'  => $area_name,
                          'payment_gracehour'     => $payment_gracehour,                         
                          'payment_graceminute'     => $payment_graceminute,
                          'entry_gracehour'     => $entry_gracehour,
                          'entry_graceminute'       => $entry_graceminute,
                          'cutoffhour'         => $cutoffhour,
                          'cutoffminute'  => $cutoffminute,


				);

				$result = $this->functions->apiv1($datasend,"add_parking_area");
				

				$audit_data = "";
				//$audit_term = gethostbyaddr($_SERVER['REMOTE_ADDR']);
				$audit_term = gethostname();
				$audit_ip = $_SERVER['REMOTE_ADDR'];

				foreach ($datasend as $key => $value) {

						$audit_data .= "$key: ".$value.'<br/>';
				}


				$auditsend = array(
				  'function'   => 'AREA ADDED',
				  'description'=> $audit_data,
				  'userid'     => $this->session->userdata('userid'),
				  'ip'   => getenv("REMOTE_ADDR"),
				  'pcname' => $audit_term,
				);

				$result = $this->functions->apiv1($auditsend,"insert_auditlog");

				
 				$link = base_url().'area';

 				echo "<script type='text/javascript'>alert('Add successful');window.location = ('$link') </script>";
				

			
                         
			}
      

			
    	}



		/**/
		$data['title'] = 'Dashboard';
		$data['page'] = 'Area';
		$data['fname'] = $this->session->userdata('firstname');
		$data['lname'] = $this->session->userdata('lastname');

		/**/
		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		$this->load->view('pages/addarea_view');
	
	}

	public function editarea($id)
	{


		/*get rate*/
		$auditsend = array();
		$json = $this->functions->apiv1($auditsend,"get_parking_area&area_id=$id");
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
    	
			$this->form_validation->set_rules('area_code', 'Area Code', 'required');
    
	
			if($this->form_validation->run() == TRUE)
			{

			
				$area_code   =   $this->input->post('area_code');
				$area_name   =   $this->input->post('area_name');
				$payment_gracehour   =   $this->input->post('payment_gracehour');
				$payment_graceminute   =   $this->input->post('payment_graceminute');
				$entry_gracehour   =   $this->input->post('entry_gracehour');
				$entry_graceminute   =   $this->input->post('entry_graceminute');
				$cutoffhour   =   $this->input->post('cutoffhour');
				$cutoffminute   =   $this->input->post('cutoffminute');
			
				$datasend =array(
				    	  'area_id'     => $id,
				          'area_code'     => $area_code,
                          'area_name'  => $area_name,
                          'payment_gracehour'     => $payment_gracehour,                         
                          'payment_graceminute'     => $payment_graceminute,
                          'entry_gracehour'     => $entry_gracehour,
                          'entry_graceminute'       => $entry_graceminute,
                          'cutoffhour'         => $cutoffhour,
                          'cutoffminute'  => $cutoffminute,


				);

		
				$result = $this->functions->apiv1($datasend,"edit_parking_area");
				$audit_data = "";
				$audit_data .= 'userid: '.$id.'<br/>';
				$audit_term =  gethostname();
				//$audit_term = gethostbyaddr($_SERVER['REMOTE_ADDR']);
				//$audit_term = "";
				$audit_ip = $_SERVER['REMOTE_ADDR'];

				foreach ($userdata as $key => $value) {
					if(isset($datasend[$key]))
						if($datasend[$key] != $value)
							$audit_data .= "$key: ".$value.' to '.$datasend[$key].'<br/>';
				}

				$auditsend = array(
					'function'   => 'AREA EDIT',
				    'description'=> $audit_data,
				    'userid'     => $this->session->userdata('userid'),
				    'ip'   => getenv("REMOTE_ADDR"),
		  			'pcname' => $audit_term,
				);

				$result = $this->functions->apiv1($auditsend,"insert_auditlog");

				
 				$link = base_url().'area';

 				echo "<script type='text/javascript'>alert('update successful');window.location = ('$link') </script>";
				

			
                         
			}
      

			
    	}



		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		$this->load->view('pages/editarea_view');
	}
}