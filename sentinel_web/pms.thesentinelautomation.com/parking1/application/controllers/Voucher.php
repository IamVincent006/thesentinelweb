<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voucher extends CI_Controller {
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
		$this->load->view('pages/voucher_view');
	
	}


	public function addvoucher()
	{
		$id = 1;

		/*get rate*/
		$data = array();

		$data['dc_name']   =   $this->input->post('dc_name');
		//$data['dc_amount']   =   $this->input->post('dc_amount');
		$data['dc_desc']   =   $this->input->post('dc_desc');
		$data['dccode']   =   $this->input->post('dccode');
		$data['ratetype'] =  $this->input->post('ratetype');



		$data['title'] = 'Dashboard';
		$data['page'] = 'Edit Rates';
		$data['fname'] = 'Juan';
		$data['lname'] = 'Dela Cruz';

	 
		$this->load->helper(array('form', 'url'));
	    $this->load->library('form_validation');

	    if ($this->input->post('submit')) 
    	{ 
    	
			$this->form_validation->set_rules('dc_name', 'Name', 'required');
    
	
			if($this->form_validation->run() == TRUE)
			{

			
				$dc_name   =   $this->input->post('dc_name');
				$dc_amount   =   $this->input->post('ratetype');
				//$dc_amount   =   $this->input->post('dc_amount');
				$dc_desc   =   $this->input->post('dc_desc');
				$dccode   =   $this->input->post('dccode');
			
				$datasend =array(
						  'dc_id'     => $id,
				    	  'dc_name'     => $dc_name,
				          'dc_amount'     => $dc_amount,
                          'dc_desc'  => $dc_desc,
                          'dccode'     => "",                         

				);

		
				$result = $this->functions->apiv1($datasend,"add_parking_voucher");
				$audit_data = "";
				$audit_data .= 'Voucher: '.$id.'<br/>';
				$audit_term =  gethostname();
				$audit_ip = $_SERVER['REMOTE_ADDR'];

				foreach ($datasend as $key => $value) {
						$audit_data .= "$key: ".$value.'<br/>';
				}

				$auditsend = array(
					'function'   => 'Voucher Add',
				    'description'=> $audit_data,
				    'userid'     => $this->session->userdata('userid'),
				    'ip'   => getenv("REMOTE_ADDR"),
		  			'pcname' => $audit_term,
				);

				$result = $this->functions->apiv1($auditsend,"insert_auditlog");

				
 				$link = base_url().'voucher';
 				echo "<script type='text/javascript'>alert('Add Successful');window.location = ('$link') </script>";
				

			
                         
			}
      

			
    	}



    	$data["rates"] = $this->functions->apiv1(array(),"Rates");


		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		$this->load->view('pages/addvoucher_view');
	}



	public function editvoucher($id)
	{


		/*get voucher*/
		$auditsend = array();
		$json = $this->functions->apiv1($auditsend,"get_parking_voucher&dcid=$id");
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
    	
			$this->form_validation->set_rules('dc_name', 'Name', 'required');
    
	
			if($this->form_validation->run() == TRUE)
			{

			
				$dc_name   =   $this->input->post('dc_name');
				$dc_amount   =   $this->input->post('ratetype');
				$dc_desc   =   $this->input->post('dc_desc');
				$dccode   =   $this->input->post('dccode');
			
				$datasend =array(
						  'dc_id'     => $id,
				    	  'dc_name'     => $dc_name,
				          'dc_amount'     => $dc_amount,
                          'dc_desc'  => $dc_desc,
                          'dccode'     => $dccode,                         

				);

		
				$result = $this->functions->apiv1($datasend,"edit_parking_voucher");
				$audit_data = "";
				$audit_data .= 'Voucher: '.$id.'<br/>';
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
					'function'   => 'Voucher EDIT',
				    'description'=> $audit_data,
				    'userid'     => $this->session->userdata('userid'),
				    'ip'   => getenv("REMOTE_ADDR"),
		  			'pcname' => $audit_term,
				);

				$result = $this->functions->apiv1($auditsend,"insert_auditlog");

				
 				$link = base_url().'voucher';

 				echo "<script type='text/javascript'>alert('update successful');window.location = ('$link') </script>";
				

			
                         
			}
      

			
    	}


	    $data["rates"] = $this->functions->apiv1(array(),"Rates");


		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		$this->load->view('pages/editvoucher_view');
	}


	
	
}