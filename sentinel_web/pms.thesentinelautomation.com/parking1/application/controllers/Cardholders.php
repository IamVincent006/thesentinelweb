<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cardholders extends CI_Controller {

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


		$data['title'] = 'Dashboard';
		$data['page'] = 'cardholder';
		$data['fname'] = $this->session->userdata('firstname');
		$data['lname'] = $this->session->userdata('lastname');


		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		$this->load->view('pages/cardholders_view');
	}
	public function addcardholder()
	{



		$this->load->helper(array('form', 'url'));
	  	$this->load->library('form_validation');

		$data['cardserial'] = $this->input->post('cardserial');	
		$data['ratetype'] = $this->input->post('ratetype');	
		$data['platenum'] = $this->input->post('platenum');	
		$data['firstname'] = $this->input->post('firstname');
		$data['lastname'] = $this->input->post('lastname');	
		$data['cardvalidity'] = $this->input->post('cardvalidity');


	    if ($this->input->post('submit')) 
    	{

			$this->form_validation->set_rules('cardserial', 'Cardserial', 'required');
			$this->form_validation->set_rules('platenum', 'Plate Number', 'required');
			$this->form_validation->set_rules('firstname', 'Firt Name', 'required');
			$this->form_validation->set_rules('lastname', 'Last Name', 'required');
			$this->form_validation->set_rules('cardvalidity', 'Valid Date', 'required');
			if($this->form_validation->run() == TRUE)
			{

				$datasend =  array(
					 'cardserial'     => $this->input->post('cardserial'),
				);	

				$cardexist = $this->functions->apiv1($datasend,"check_cardholder");

				//print_r($cardexist);
				//return;
				if(count($cardexist)==0)
				{	
					/*add user*/
					$datasend =  array(
						
							  'area_id'     => $this->input->post('area_id'),
							  'cardserial'     => $this->input->post('cardserial'),
							  'ratetype'     => $this->input->post('ratetype'),  
		                      'platenum'     => $this->input->post('platenum'),                         
		                      'firstname'     => $this->input->post('firstname'),
		                      'lastname'     => $this->input->post('lastname'),
		                      'cardvalidity'  => $this->input->post('cardvalidity'),                 
						);
					$result = $this->functions->apiv1($datasend,"insert_cardholder");


					/*inserlog*/
						
					$audit_data = "";
					//$audit_term = gethostbyaddr($_SERVER['REMOTE_ADDR']);
					$audit_term = gethostname();
					foreach ($datasend as $key => $value) {

						$audit_data .= "$key: ".$value.'<br/>';
					}

					$auditsend = array(
						'function'   => 'CARDHOLDER ADDED',
						'description'=> $audit_data,
						'userid'     => $this->session->userdata('userid'),
						'ip'   => getenv("REMOTE_ADDR"),
						'pcname' => $audit_term,
					);

					$result = $this->functions->apiv1($auditsend,"insert_auditlog");


					$link = base_url().'cardholders';
					echo "<script type='text/javascript'>alert('add successful');window.location = ('$link') </script>";

				}
				else
				{
					$this->session->set_flashdata(ERROR, '<p class="error">Cardserial Already Exist</p>');
				}








			}

    	}


		/*get area*/
		$data["termarea"] = $this->functions->apiv1(array(),"area_details");

		/*get rates*/
    	$data["rates"] = $this->functions->apiv1(array(),"Rates");

		$data['title'] = 'Dashboard';
		$data['page'] = 'cardholder';
		$data['fname'] = $this->session->userdata('firstname');
		$data['lname'] = $this->session->userdata('lastname');


		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		$this->load->view('pages/addcardholder_view');
	}
	public function editcardholder($id)
	{
		$this->load->helper(array('form', 'url'));
	  	$this->load->library('form_validation');


		$json = $this->functions->apiv1(array(),"get_cardholder&id=$id");
		$carddata = $json[0];	
		$data["query"] = $carddata;

		

	    if ($this->input->post('submit')) 
    	{

			$this->form_validation->set_rules('cardserial', 'Cardserial', 'required');
			$this->form_validation->set_rules('platenum', 'Plate Number', 'required');
			$this->form_validation->set_rules('firstname', 'Firt Name', 'required');
			$this->form_validation->set_rules('lastname', 'Last Name', 'required');
			$this->form_validation->set_rules('cardvalidity', 'Valid Date', 'required');
			if($this->form_validation->run() == TRUE)
			{

				$datasend =  array(
					 'cardserial'     => $this->input->post('cardserial'),
				);	

				//$cardexist = $this->functions->apiv1($datasend,"check_cardholder");

				//print_r($cardexist);
				//return;
				//if(count($cardexist)==0)
				//{	
					/*add user*/
					$datasend =  array(
							  'id'     => $id,
							  'area_id'     => $this->input->post('area_id'),
							  'cardserial'     => $this->input->post('cardserial'),
							  'ratetype'     => $this->input->post('ratetype'),  
		                      'platenum'     => $this->input->post('platenum'),                         
		                      'firstname'     => $this->input->post('firstname'),
		                      'lastname'     => $this->input->post('lastname'),
		                      'cardvalidity'  => $this->input->post('cardvalidity'),                 
						);
					$result = $this->functions->apiv1($datasend,"update_cardholder");


					/*inserlog*/
						
					$audit_data = "";
					//$audit_term = gethostbyaddr($_SERVER['REMOTE_ADDR']);
					$audit_term = gethostname();
					foreach ($carddata as $key => $value) {
						if(isset($datasend[$key]))
							if($datasend[$key] != $value)
								$audit_data .= "$key: ".$value.' to '.$datasend[$key].'<br/>';
          			}

					$auditsend = array(
						'function'   => 'CARDHOLDER EDIT',
						'description'=> $audit_data,
						'userid'     => $this->session->userdata('userid'),
						'ip'   => getenv("REMOTE_ADDR"),
						'pcname' => $audit_term,
					);

					$result = $this->functions->apiv1($auditsend,"insert_auditlog");


					$link = base_url().'cardholders';
					echo "<script type='text/javascript'>alert('update successful');window.location = ('$link') </script>";

				//}
				//else
				//{
				//	$this->session->set_flashdata(ERROR, '<p class="error">Cardserial Already Exist</p>');
				//}








			}

    	}











		/*get area*/
		$data["termarea"] = $this->functions->apiv1(array(),"area_details");
		/*get rates*/
    	$data["rates"] = $this->functions->apiv1(array(),"Rates");

    	
		$data['title'] = 'Dashboard';
		$data['page'] = 'cardholder';
		$data['fname'] = $this->session->userdata('firstname');
		$data['lname'] = $this->session->userdata('lastname');


		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		$this->load->view('pages/editcardholder_view');

	}


}