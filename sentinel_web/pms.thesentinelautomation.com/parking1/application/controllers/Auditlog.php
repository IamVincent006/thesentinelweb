<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auditlog extends CI_Controller {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('functions');

		if(!Auth::is_loggedin())
			Auth::Bounce($this->uri->uri_string());
	}

	public function index()
	{
		
		$data['title'] = 'Dashboard';
		$data['page'] = 'home';
		$data['fname'] = $this->session->userdata('firstname');
		$data['lname'] = $this->session->userdata('lastname');


		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		//$this->load->view('components/cards');
		$this->load->view('pages/auditlog_view');
	}

}