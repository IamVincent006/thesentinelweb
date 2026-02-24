<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

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

		/*content details*/
		$data['title'] = 'Dashboard';
		$data['page'] = 'Users';
		$data['fname'] = $this->session->userdata('firstname');
		$data['lname'] = $this->session->userdata('lastname');

		//call pages*/
		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		$this->load->view('pages/users_view');
	}

	public function adduser()
	{

		$this->load->helper(array('form', 'url'));
	  $this->load->library('form_validation');

		$data['firstname'] = $this->input->post('firstname');	
		$data['lastname'] = $this->input->post('lastname');	
		$data['username'] = $this->input->post('username');	
		$data['password'] = $this->input->post('password');
		$data['confirmpword'] = $this->input->post('confirmpword');	
		$data['usertype'] = $this->input->post('usertype');


	    if ($this->input->post('submit')) 
    	{

			$this->form_validation->set_rules('firstname', 'First Name', 'required');
			$this->form_validation->set_rules('lastname', 'First Name', 'required');
			$this->form_validation->set_rules('username', 'User Name', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('confirmpword', 'Confirm Password', 'required');
			$this->form_validation->set_rules('confirmpword', 'Confirm Password', 'required|matches[password]');
	
			if($this->form_validation->run() == TRUE)
			{
				/*check user exist*/

				$datasend =  array(
					 'username'     => $this->input->post('username'),
				);
				$userexist = $this->functions->apiv1($datasend,"check_user_exist");
				if(count($userexist)==0)
				{

							/*add user*/
							$datasend =  array(
			  						  'firstname'     => $this->input->post('firstname'),
                      'lastname'     => $this->input->post('lastname'),                         
                      'username'     => $this->input->post('username'),
                      'password'     => $this->input->post('password'),
                      'userlevel'  => $this->input->post('usertype'),                 
								);
							$result = $this->functions->apiv1($datasend,"add_parking_users");

							/*inserlog*/
						

		          $audit_data = "";
		          //$audit_term = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		          $audit_term = gethostname();
		          $audit_ip = $_SERVER['REMOTE_ADDR'];

		          foreach ($datasend as $key => $value) {
						if($key == "password")
							$audit_data .= "$key: ******".'<br/>';
						else
							$audit_data .= "$key: ".$value.'<br/>';
		          		//
		          }


		         	$auditsend = array(
		        	  'function'   => 'USER ADDED',
		            'description'=> $audit_data,
		            'userid'     => $this->session->userdata('userid'),
		            'ip'   => getenv("REMOTE_ADDR"),
				  			'pcname' => $audit_term,
							);

							$result = $this->functions->apiv1($auditsend,"insert_auditlog");
							
							$link = base_url().'users';
			 				echo "<script type='text/javascript'>alert('add successful');window.location = ('$link') </script>";
        }
        else
        {
						$this->session->set_flashdata(ERROR, '<p class="error">Username Already Exist</p>');
        }                 


			}
      

			
    	}

   	/////////////////////////////////////////////////////////////////////////
		//get userlevel
		$auditsend = array();
		$json = $this->functions->apiv1($auditsend,"userlevel_details");
		$data["userlevel"] = $json;


		/*get menus*/
		/*$auditsend = array();
		$json = $this->functions->apiv1($auditsend,"menu_details");
		$data["menu"] = $json;*/

		
		$data['title'] = 'Dashboard';
		$data['page'] = 'Add Users';
		$data['fname'] = $this->session->userdata('firstname');
		$data['lname'] = $this->session->userdata('lastname');



		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		$this->load->view('pages/adduser_view');
	}
	public function logoutuser()
	{
				$datasend =  array(
				 	  	'userid'     => 2,                
				);
				$result = $this->functions->apiv1($datasend,"userlogout");

	}


	public function edituser($id)
	{
	 
    	/////////////////////////////////////////////////////////////////////////
		//get userlevel
		$auditsend = array();
		$json = $this->functions->apiv1($auditsend,"userlevel_details");
		$data["userlevel"] = $json;



		//////////////////////////////////////////////////////////////////////////
		$auditsend = array();
		$json = $this->functions->apiv1($auditsend,"get_userinfo&userid=$id");
		$userdata = $json[0];	
		$data["query"] = $userdata;


		/*get menus*/
		/*$auditsend = array();
		$json = $this->functions->apiv1($auditsend,"menu_details");
		$data["menu"] = $json;*/

		
		$data['title'] = 'Dashboard';
		$data['page'] = 'Edit Users';
		$data['fname'] = $this->session->userdata('firstname');
		$data['lname'] = $this->session->userdata('lastname');



		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		/*$data['firstname'] = $this->input->post('firstname');	
		$data['lastname'] = $this->input->post('lastname');	
		$data['username'] = $this->input->post('username');	
		$data['password'] = $this->input->post('password');
		$data['confirmpword'] = $this->input->post('confirmpword');	
		$data['userlevel'] = $this->input->post('userlevel');*/



	    if ($this->input->post('submit')) 
    	{



	

			$this->form_validation->set_rules('firstname', 'First Name', 'required');
			$this->form_validation->set_rules('lastname', 'First Name', 'required');
			$this->form_validation->set_rules('username', 'User Name', 'required');


			if(!empty($this->input->post('password')))
			{
				$this->form_validation->set_rules('password', 'Password', 'required');
				$this->form_validation->set_rules('confirmpword', 'Confirm Password', 'required');
				$this->form_validation->set_rules('confirmpword', 'Confirm Password', 'required|matches[password]');
			}

	
			if($this->form_validation->run() == TRUE)
			{
				
				/*edit user*/
				$datasend =  array(
					 	  'userid'     => $id,
					      'firstname'     => $this->input->post('firstname'),
                'lastname'     => $this->input->post('lastname'),                         
                'username'     => $this->input->post('username'),
                'password'     => $this->input->post('password'),
                'userlevel'  => $this->input->post('userlevel'),  
                'status'  => $this->input->post('userstatus'),                
					);
				$result = $this->functions->apiv1($datasend,"edit_parking_users");
				/*audit log*/

				//print_r($result);


          $audit_data = "";
          $audit_data .= 'userid: '.$id.'<br/>';
          //$audit_term = gethostbyaddr($_SERVER['REMOTE_ADDR']);
          $audit_term = gethostname();
          $audit_ip = $_SERVER['REMOTE_ADDR'];

          foreach ($userdata as $key => $value) {
						if(isset($datasend[$key]))
							if($datasend[$key] != $value)
								if($key == "password")
									$audit_data .= "$key: ".$value.' to ******<br/>';
								else
									$audit_data .= "$key: ".$value.' to '.$datasend[$key].'<br/>';
          }



          $auditsend = array(
          	'function'   => 'USER EDIT',
            'description'=> $audit_data,
            'userid'     => $this->session->userdata('userid'),
            'ip'   => getenv("REMOTE_ADDR"),
		  			'pcname' => $audit_term,
					);

				$result = $this->functions->apiv1($auditsend,"insert_auditlog");

			

				$link = base_url().'users';

 				echo "<script type='text/javascript'>alert('update successful');window.location = ('$link') </script>";
                         
			}
      

			
    	}

		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		$this->load->view('pages/edituser_view');

	}

}