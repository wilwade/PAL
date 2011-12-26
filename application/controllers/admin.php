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

	/**
	 * Change Password
	 *
	 * @return page
	 */
	public function password()
	{
		$this->lang->load('setup');
		$this->load->library('Form');
		$this->form
			->open()
			->html('<p>' . $this->lang->line('setup_password_instructions') . '</p>')
			->password('password1', 'Password', 'required')
			->password('password2', 'Repeat Password', 'required')
			->submit('Save Password', 'setup_password');//TODO Lang

		$data['form'] = $this->form->get();

		if($this->form->valid)
		{
			$post = $this->form->get_post();

			if($post['password1'] === $post['password2'])
			{
				//Ok we have matching passwords
				//Set password
				$config['pal_password'] = crypt($post['password1'], $this->config->item('pal_password_salt'));

				$this->load->model('Setup_db');
				//Write it to the files
				$this->Setup_db->write_pal_config($config);

				//Ok and we are off and running!
				return redirect('admin');
			}
			else
			{
				//TODO Show a message about the passwords not being the same.
			}
		}

		$data['title'] = 'Setup Password';//TODO Lang
		$this->template->write_view('content', 'forms', $data);
		$this->template->render();
	}

	public function logout()
	{
		$this->session->sess_destroy();
		return redirect('');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */