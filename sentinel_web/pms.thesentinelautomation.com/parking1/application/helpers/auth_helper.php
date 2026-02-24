<?php

Class Auth
{
	 /*
	 	@param : none
	 	@return : bool
		@details : checks if the user_id session is set. used all over Lagos :)
	  */



		static function is_loggedin()
		{
			$CI = & get_instance();
			if ($CI->session->has_userdata('userid') != '')
			{
				
				return TRUE;
			}
			else
			{

				return FALSE;
			}
			
		}

		static function test()
		{
			$CI = & get_instance();
			print_r($CI->session->all_userdata());
			//print_r($CI->session->userdata('userid'));
			
		}


	/*
	 	@param : none
	 	@return : bool
		@details : Logs out the only possible account admin. I like that guy :)
	  */
		static function Logout()
		{


			$CI = & get_instance();
			unset($_SESSION['userid']);
			unset($_SESSION['previous_url']);
			$CI->session->sess_destroy();

			redirect(site_url(''));

		}

		/*
	 	@param : array()
	 	@return : bool
		@details : I jst login if the data matches the hardcoded guy. admin. 
	  */
		static function Menu($menu = array())
		{
			$CI = & get_instance();
			//print_r($menu);
			$CI->session->set_userdata($menu);
			//print_r($CI->session->all_userdata());


		}
		static function Login($data = array())
		{
			$CI = & get_instance();
			$CI->session->set_userdata($data);
		}

		/*
			@param : string
		@details : Used to set a session so as to rember where the hell u are coming from if not logged in :)
		 */
		static function Bounce($uri_string = '')
		{
			$CI = & get_instance();
			$CI->session->set_userdata('previous_url', $uri_string);
			redirect(site_url());
		}

	}