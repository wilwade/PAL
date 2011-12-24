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
		$this->load->library('Form');
		$this->load->model('Setup');
	}

	/**
	 * Welcome to PAL
	 * Next to configure the database server
	 * 
	 * @return page
	 */
	public function index()
	{
		return $this->database_permissions();
	}
	
	/**
	 * Setup permissions to the database
	 * 
	 * @return page
	 */
	public function database_permissions()
	{
		//Ok time to setup the form for the various values.
		
		$this->form
			->open()
			->html('<p>' . $this->lang->line('setup_database_instructions') . '</p>')
			->text('hostname', 'Hostname', 'required', 'localhost')
			->text('username', 'Database Username', 'required', '')
			->password('password', 'Database Password', 'required')
			->text('database', 'Unique Database Name', 'required', 'PAL_database')
			->text('dbprefix', 'Database Prefix (leave blank for none)', '', '')
			->submit('Continue Setup', 'setup_db_permissions');
			
		$data['form'] = $this->form->get();
		
		if($this->form->valid)
		{
			$post = $this->form->get_post();
			
			if($this->Setup->setup_initial_database($post))
			{
				//Ok we are good. Go on to initial setup
			}
		}		
		
		$this->template->write_view('content', 'forms', $data);
		$this->template->render();
		
		//$this->config->set_item('set', 'value');
	}
}

/* End of file setup.php */
/* Location: ./application/controllers/setup.php */