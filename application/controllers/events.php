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

		if( ! $this->session->userdata('pal_login'))
		{
			//Not Logged in!
			return redirect('welcome/login');
		}

		$this->load->library('Message');
		$this->load->model('Event');
		//$this->load->library('Form');
	}

	/**
	 * Show the basic listing of event buttons
	 * Also:
	 * Admin Button
	 * History Button
	 *
	 * @return page
	 */
	public function index()
	{
		//Get the listing of all possible events.
		$data['events'] = $this->Event->get_all_events();

		//Show View
		$data['title'] = $this->lang->line('events_main_title');
		$this->template->write_view('content', 'events_view', $data);
		$this->template->render();
	}

	/**
	 * Add an event
	 *
	 * @return page
	 */
	public function add()
	{
		if($this->input->post('cancel'))
		{
			return redirect('events');
		}
		
		$this->load->library('Form');

		$colors = array();

		foreach($this->config->item('pal_colors') as $color)
		{
			$colors[$color] = $color;
		}

		$this->form
			->open('events/add')
			->text('event_name', $this->lang->line('events_form_name'), 'required')
			->select('color', $colors, $this->lang->line('events_form_color')) //Select colors
			->textarea('description', $this->lang->line('events_form_description'))
			->submit($this->lang->line('events_form_add_submit'), 'add_new_event');

		$data['form'] = $this->form->get();

		if ($this->form->valid)
		{
			$post = $this->form->get_post();

			$this->Event->create($post['event_name'], $post['color'][0], $post['description']);
			$this->Event->save();

			//Ok return to main
			return redirect('events');

		}

		$data['title'] = $this->lang->line('events_add_title');
		$this->template->write_view('content', 'forms', $data);
		$this->template->render();
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */