<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terminals extends CI_Controller {

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
		//get menu*/
		/*$auditsend = array();
		$json = $this->functions->apiv1($auditsend,"menu_details");
		$data["menu"] = $json;*/


		$data['title'] = 'Dashboard';
		$data['page'] = 'terminal';
		$data['fname'] = $this->session->userdata('firstname');
		$data['lname'] = $this->session->userdata('lastname');



		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		//$this->load->view('components/cards');
		$this->load->view('pages/terminals_view');
	}


	public function addterminal()
	{

		$this->load->helper(array('form', 'url'));
	    $this->load->library('form_validation');

		$data['termname'] = $this->input->post('termname');
		$data['termIP'] = $this->input->post('termIP');	
		$data['area_code'] = $this->input->post('area_code');	
		$data['docnum'] = $this->input->post('docnum');	
		$data['termtype'] = $this->input->post('termtype');
		$data['termarea'] = $this->input->post('termarea');	
		$data['termcnt'] = $this->input->post('termcnt');
		$data['termreceipt'] = $this->input->post('termreceipt');
		$data['termtellerlogID'] = $this->input->post('termtellerlogID');
		$data['termparkid'] = $this->input->post('termparkid');



	    if ($this->input->post('submit')) 
    	{

			$this->form_validation->set_rules('termname', 'Terminal Name', 'required');
			$this->form_validation->set_rules('termIP', 'Terminal IP', 'required|valid_ip');
			$this->form_validation->set_rules('area_code', 'Document Code', 'required');
			$this->form_validation->set_rules('docnum', 'Document Number', 'required');
			$this->form_validation->set_rules('termcnt', 'ID Count', 'required');



	
			if($this->form_validation->run() == TRUE)
			{

				$datasend =  array(
  						  'termname'     => $this->input->post('termname'),
  						  'termIP'     => $this->input->post('termIP'),
                          'area_code'     => $this->input->post('area_code'),                         
                          'docnum'     => $this->input->post('docnum'),
                          'termtype'     => $this->input->post('termtype'),
                          'termarea'  => $this->input->post('termarea'),  
                          'termcnt'  => $this->input->post('termcnt'),  
                          'termrefund'  => "1",
                          'termvoid'  => "1",
                          'termreceipt'  => $this->input->post('termreceipt'),  
                          'termtellerlogID'  => $this->input->post('termtellerlogID'),  
                          'termparkid'  => $this->input->post('termparkid'),                 
					);
				print_r($datasend);
				$auditsend = array();
				$json = $this->functions->apiv1($datasend,"add_parking_terminals");
			

				/*inserlog*/
				$audit_data = "";
				//$audit_term = gethostbyaddr($_SERVER['REMOTE_ADDR']);
				$audit_term = gethostname();
				$audit_ip = $_SERVER['REMOTE_ADDR'];

				foreach ($datasend as $key => $value) {

						$audit_data .= "$key: ".$value.'<br/>';
				}


				$auditsend = array(
				  'function'   => 'TERMINAL ADDED',
				  'description'=> $audit_data,
				  'userid'     => $this->session->userdata('userid'),
				  'ip'   => getenv("REMOTE_ADDR"),
		  		  'pcname' => $audit_term,
				);

				$result = $this->functions->apiv1($auditsend,"insert_auditlog");

			

				$link = base_url().'terminals';

 				echo "<script type='text/javascript'>alert('add successful');window.location = ('$link') </script>";
                         
			}
      

			
    	}

    	/////////////////////////////////////////////////////////////////////////
		//get userlevel
		$auditsend = array();
		$json = $this->functions->apiv1($auditsend,"area_details");
		$data["termarea"] = $json;

		//get menu*/
		/*$auditsend = array();
		$json = $this->functions->apiv1($auditsend,"menu_details");
		$data["menu"] = $json;*/


		$data['title'] = 'Dashboard';
		$data['page'] = 'Add Terminals';
		$data['fname'] = $this->session->userdata('firstname');
		$data['lname'] = $this->session->userdata('lastname');

		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		//$this->load->view('components/cards');
		$this->load->view('pages/addterminal_view');
	}
	public function editterminal($id)
	{
	
    	/////////////////////////////////////////////////////////////////////////
		/*TERMINAL AREA*/
		$auditsend = array();
		$json = $this->functions->apiv1($auditsend,"area_details");
		$data["termarea"] = $json;

		/*get menu*/
		/*$auditsend = array();
		$json = $this->functions->apiv1($auditsend,"menu_details");
		$data["menu"] = $json;*/


		//////////////////////////////////////////////////////////////////////////
		$auditsend = array();
		$json = $this->functions->apiv1($auditsend,"get_terminal_details&terminalid=$id");
		$userdata = $json[0];
		$data["query"] = $userdata;

		
		$data['title'] = 'Dashboard';
		$data['page'] = 'Add Terminals';
		$data['fname'] = $this->session->userdata('firstname');
		$data['lname'] = $this->session->userdata('lastname');


		$this->load->helper(array('form', 'url'));
	    $this->load->library('form_validation');



	    if ($this->input->post('submit')) 
    	{

			$this->form_validation->set_rules('termname', 'Terminal Name', 'required');
			$this->form_validation->set_rules('termIP', 'Terminal IP', 'required|valid_ip');
			$this->form_validation->set_rules('area_code', 'Document Code', 'required');
			$this->form_validation->set_rules('docnum', 'Document Number', 'required');
			$this->form_validation->set_rules('termcnt', 'ID Count', 'required');


		
	
			if($this->form_validation->run() == TRUE)
			{

				$datasend =  array(
						  'termid'     => $id,
  						  'termname'     => $this->input->post('termname'),
  						  'termIP'     => $this->input->post('termIP'),
                          'area_code'     => $this->input->post('area_code'),                         
                          'docnum'     => $this->input->post('docnum'),
                          'termtype'     => $this->input->post('termtype'),
                          'termarea'  => $this->input->post('termarea'),  
                          'termcnt'  => $this->input->post('termcnt'),  
                          'termreceipt'  => $this->input->post('termreceipt'),  
                          'termtellerlogID'  => $this->input->post('termtellerlogID'),  
                          'termparkid'  => $this->input->post('termparkid'),                 
					);

				$json = $this->functions->apiv1($datasend,"update_parking_terminals");



				$audit_data = "";
				$audit_data .= 'userid: '.$id.'<br/>';
				//$audit_term = gethostbyaddr($_SERVER['REMOTE_ADDR']);
				$audit_term = gethostname();
				$audit_ip = $_SERVER['REMOTE_ADDR'];

				foreach ($userdata as $key => $value) {
					if(isset($datasend[$key]))
						if($datasend[$key] != $value)
							$audit_data .= "$key: ".$value.' to '.$datasend[$key].'<br/>';
					//$audit_data .= "$key: ".$value.' to '.'<br/>';
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


			
				$link = base_url().'terminals';

 				echo "<script type='text/javascript'>alert('add successful');window.location = ('$link') </script>";
                         
			}
      		
			
			
    	}

		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		$this->load->view('pages/editterminal_view');
	}

}