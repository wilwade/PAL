<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Testing Setup the database and configure for the server.
 *
 */
class Setup_test extends Setup {
	
	function __construct()
	{
		parent::__construct();
		$this->lang->load('setup');
		$this->load->library('unit_test');
	}

	/**
	 * Setup the database and configure for the server.
	 *
	 * 
	 */
	public function index()
	{
		
	}
}

/* End of file setup.php */
/* Location: ./application/controllers/setup.php */