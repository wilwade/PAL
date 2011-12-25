<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->lang->load('welcome');
		$this->load->database();
		$this->load->library('session');
		$this->load->library('Message');
		$this->load->library('Form');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Basically a login screen.
	 *
	 * @return page
	 */
	public function index()
	{
		$this->form
			->open()
			->html('<p>' . $this->lang->line('welcome_login') . '</p>')
			->password('password', 'Password', 'required')
			->submit('Login', 'login');

		$data['form'] = $this->form->get();

		if($this->form->valid)
		{
			$post = $this->form->get_post();

			$salt = $this->config->item('pal_password_salt');

			if(crypt($post['password'], $salt) === $this->config->set_item('pal_password'))
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

		$data['title'] = '';
		$this->template->write_view('content', 'forms', $data);
		$this->template->render();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */