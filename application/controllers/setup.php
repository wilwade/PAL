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
		$this->load->model('Setups');
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

			$config = $post;

			unset($config['setup_db_permissions']);
			unset($config['database']);

			$this->Setups->database_config($config);

			$this->load->database();
			$this->load->dbforge();

			$continue = TRUE;

			if($this->dbforge->create_database($post['database']))
			{
				//Save the db name
				$this->Setups->database_config(array('database' => $post['database']));

				//Redirect to setup the tables
				return redirect('setup/create_tables');
			}

			//TODO Show error
		}
		$data['title'] = 'Setup Database';
		$this->template->write_view('content', 'forms', $data);
		$this->template->render();
	}

	/**
	 * Create the Database Tables
	 */
	public function create_tables()
	{
		if($this->Setups->create_tables())
		{
			//Go on to password setup
			return redirect('setup/password');
		}

		//TODO Show Error
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
				$config['pal_password_salt'] = $config['encryption_key'] = $salt;

				//Set password
				$config['pal_password'] = crypt($post['password1'], $salt);

				//Write it to the files
				$this->Setups->write_pal_config($config);

				//Ok and we are off and running!
				return redirect('');
			}
			else
			{
				//TODO Show a message about the passwords not being the same.
			}
		}

		$data['title'] = 'Setup Password';
		$this->template->write_view('content', 'forms', $data);
		$this->template->render();
	}

}

/* End of file setup.php */
/* Location: ./application/controllers/setup.php */