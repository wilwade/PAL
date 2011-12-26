<?php

if ( ! defined('BASEPATH'))
	exit('No direct script access allowed');

class Events extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->lang->load('events');
		$this->load->database();
		$this->load->library('session');
		$this->load->library('Message');
		$this->load->model('Event');
		//$this->load->library('Form');
	}

	/**
	 * Index. Check for session, pass to event or login.
	 *
	 * @return redirect
	 */
	public function index()
	{
		if($this->session->userdata('pal_login'))
		{
			//Continue to the main events page
			return redirect('events');
		}

		//Go to login page
		return $this->login();
	}

	/**
	 * Basically a login screen.
	 *
	 * @return page
	 */
	public function login()
	{
		$this->form
			->open('welcome/login')
			->html('<p>' . $this->lang->line('welcome_login') . '</p>')
			->password('password', 'Password', 'required')
			->submit('Login', 'login');

		$data['form'] = $this->form->get();

		if ($this->form->valid)
		{
			$post = $this->form->get_post();

			$salt = $this->config->item('pal_password_salt');

			if (crypt($post['password'], $salt) === $this->config->set_item('pal_password'))
			{
				//Login Successful!
				//Setup the session to remember that we are logged in
				$this->session->set_userdata('pal_login', TRUE);

				//Continue to the main events page
				return redirect('events');
			}
			else
			{
				//TODO Show a message about incorrect password.
			}
		}

		$data['title'] = 'Login to PAL';
		$this->template->write_view('content', 'forms', $data);
		$this->template->render();
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */