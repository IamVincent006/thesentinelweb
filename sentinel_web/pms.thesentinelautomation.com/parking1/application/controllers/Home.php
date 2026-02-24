<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('functions');


		if(!Auth::is_loggedin())
		{

			/*$datasend =  array(
		 	  	'userid'     => $_SESSION['userid'],                
			);
			$result = $this->functions->apiv1($datasend,"userlogout");
			print_r("QQQQQ");
			print_r($_SESSION['userid']);*/
			Auth::Bounce($this->uri->uri_string());
		}

	}

	public function index()
	{


		$auditsend = array();
		$json = $this->functions->apiv1($auditsend,"area_details");
		$data["termarea"] = $json;

		$data['title'] = 'Dashboard';
		$data['page'] = 'home';
		$data['fname'] = $this->session->userdata('firstname');
		$data['lname'] = $this->session->userdata('lastname');



		//$this->load->view('template', $data);
		//$this->load->view('template');

		$this->load->view('components/header');
		$this->load->view('components/sidenav',$data);
		//$this->load->view('components/cards');
		$this->load->view('pages/index_view');
	}
	public function slotsdetails($areaid)
	{

		$datasend =array(
		          'areaid'     => $areaid,             
		);

		$results = $this->functions->apiv1($datasend,"get_slots");
		//print_r($results);
		$data = '';
		foreach($results as $key => $value)
		{
			$data .= '<div class="col-sm-3">';
			$data .= '<div class="card">';
			$data .= '<div class="card-body">';
			$data .= ' <h1 class="card-title">' . ($value['slotcount'] - $value['occupiedslot']) .'</h1>';
			$data .= '<p class="card-text">"Available Parking Slot"</p>';
			$data .= '</div>';
			$data .= ' <a class="card-links" href="#"><div class="card-footer">'.$value['description'].'</div></a>';
			$data .= '</div>';
			$data .= '</div>';
			
		}

	

		//$data['cards'] = $cards;

		print_r($data);
	}

}












