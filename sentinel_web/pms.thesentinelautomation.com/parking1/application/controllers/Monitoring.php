<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('functions');
		if(!Auth::is_loggedin())
			Auth::Bounce($this->uri->uri_string());
	}

	public function index()
	{
		/*$url = rtrim(api_url(), "/")."menu_details";
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);
		$data["menu"] = $json_data["data"];*/
		
	
		$data['title'] = 'Dashboard';
		$data['page'] = 'monitoring';
		$data['fname'] = $this->session->userdata('firstname');
		$data['lname'] = $this->session->userdata('lastname');

		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		//$this->load->view('components/cards');
		$this->load->view('pages/monitoring_view');
	}

}