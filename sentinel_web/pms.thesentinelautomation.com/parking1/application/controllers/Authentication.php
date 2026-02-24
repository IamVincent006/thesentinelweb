<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Authentication extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->function = new Functions();	
		  $this->load->model('functions');

	}


	public function index()
	{

		if(Auth::is_loggedin()){
			redirect(site_url('home'));
		}





		$this->load->helper(array('form', 'url'));
	    $this->load->library('form_validation');

		$data['username'] = $this->input->post('username');	




	    if ($this->input->post('submit')) 
    	{
  

			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
	
			if($this->form_validation->run() == TRUE)
			{
			
				

				$datasend =  array(
					  'username'     => $this->input->post('username'),
					  'password'     => $this->input->post('password'),                  
					);
					
				//$opts = $this->functions->postheader($datasend);
				//$context  = stream_context_create($opts);
				//$url = rtrim(api_url(), "/")."get_userverification";
				//$result = file_get_contents($url, false, $context);
				//$json_data = json_decode($result, true);
				$json_data = $this->functions->apiv1($datasend,"get_userverification");
				//print_r($datasend);
				//print_r(api_url());
				//return;
				if(count($json_data) >= 1)
				{	
					/*session menu*/
					$datasend = array();
					$menu['menu'] = $this->functions->apiv1($datasend,"menu_details");
					Auth::Menu($menu);



					Auth::login($json_data[0]);

					$this->load->library('user_agent');

					if ($this->agent->is_browser())
					{
						$agent = $this->agent->browser().' '.$this->agent->version();
					}
					elseif ($this->agent->is_robot())
					{
						$agent = $this->agent->robot();
					}
					elseif ($this->agent->is_mobile())
					{
						$agent = $this->agent->mobile();
					}
					else
					{
						$agent = 'Unidentified User Agent';
					}
				
			


					$datasend =  array(
						'ip'     => getenv("REMOTE_ADDR"),
						'host'     => $agent . " " . $this->agent->platform(),   
						'userid'     => $json_data["data"][0]["userid"],                
					);
										
					//$opts = $this->functions->postheader($datasend);
					//$context  = stream_context_create($opts);
					//$url = rtrim(api_url(), "/")."update_userverification_log";
					//$result = file_get_contents($url, false, $context);
					//$json_data = json_decode($result, true);
					$this->functions->apiv1($datasend,"update_userverification_log");
					//print_r($json_data);

					if($this->session->userdata('previous_url')) {
							redirect(site_url($this->session->userdata('previous_url')));
					} else {
							redirect(site_url('home'));
					}
				}
				else
				{	
					$this->session->set_flashdata(ERROR, '<p class="error">Invalid Username/Password</p>');
				}

			}
		
		}
	


	

		$this->load->view('components/header',$data);
		$this->load->view('pages/login_view');
		
	
	}

	public function logout()
	{
		$datasend =  array(
		 	  	'userid'     => $_SESSION['userid'],                
		);
		$result = $this->functions->apiv1($datasend,"userlogout");

		Auth::logout();
	}
}