<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Setup the database and configure for the server.
 *
 */
class Setup extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->lang->load('setup');
	}

	/**
	 * Welcome to PAL
	 * Next to configure the database server
	 * 
	 * @return page
	 */
	public function index()
	{
		
	}
	
	/**
	 * Setup permissions to the database
	 * 
	 * @return page
	 */
	public function database_permissions()
	{
		//$this->config->set_item('set', 'value');
	}
}

/* End of file setup.php */
/* Location: ./application/controllers/setup.php */