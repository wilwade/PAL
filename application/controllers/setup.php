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
		//TODO There needs to be a message here about what you will need
		//Perhaps a little about the system and a link to the github page.
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
				//Ok we are good. Add the database to the autoload
				$autoload = $this->config->item('libraries');
				$autoload[] = 'database';
				$this->config->set_item('libraries', $autoload);
				
				//Go on to password setup
				redirect('setup/password');
			}
		}		
		$data['title'] = ''; 
		$this->template->write_view('content', 'forms', $data);
		$this->template->render();	
	}
	
	/**
	 * Setup the password
	 * 
	 * @return page
	 */
	public function password()
	{
		$this->form
			->open()
			->html('<p>' . $this->lang->line('setup_password_instructions') . '</p>')
			->password('password1', 'Password', 'required')
			->password('password2', 'Repeat Password', 'required')
			->submit('Continue Setup', 'setup_password');
			
		$data['form'] = $this->form->get();
		
		if($this->form->valid)
		{
			$post = $this->form->get_post();
			
			if($post['password1'] === $post['password2'])
			{
				//Ok we have matching passwords
				
				//Generate Salt
				$salt = uniqid('', TRUE);
				$this->config->set_item('pal_password_salt', $salt);
				
				//Set password
				$this->config->set_item('pal_password', crypt($post['password1'], $salt));
				
				//Ok and we are off and running!
				redirect('');
			}
			else
			{
				//TODO Show a message about the passwords not being the same.
			}		
		
		$data['title'] = ''; 
		$this->template->write_view('content', 'forms', $data);
		$this->template->render();
	}
}

/* End of file setup.php */
/* Location: ./application/controllers/setup.php */