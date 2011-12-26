<?php

if ( ! defined('BASEPATH'))
	exit('No direct script access allowed');

class Admin extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->lang->load('admin');
		$this->load->database();
		$this->load->library('session');
		$this->load->library('Message');

		if( ! $this->session->userdata('pal_login'))
		{
			//Not Logged in!
			return redirect('welcome/login');
		}

	}

	/**
	 * Index. Link to all the different admin stuff
	 *
	 * @return page
	 */
	public function index()
	{
		//Load page
		$data['title'] = $this->lang->line('admin_index_title');
		$this->template->write_view('content', 'admin_listing', $data);
		$this->template->render();
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */