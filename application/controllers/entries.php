<?php

if ( ! defined('BASEPATH'))
	exit('No direct script access allowed');

class Entries extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->lang->load('entries');
		$this->load->database();
		$this->load->library('session');

		if( ! $this->session->userdata('pal_login'))
		{
			//Not Logged in!
			return redirect('welcome/login');
		}

		$this->load->library('Message');
		$this->load->model('Entry');
		//$this->load->library('Form');
	}

	/**
	 * Return to the basic page
	 *
	 * @return redirect
	 */
	public function index()
	{
		return redirect('events');
	}

	/**
	 * Add a log entry
	 *
	 * @return page
	 */
	public function add($event_id = FALSE)
	{
		//If $event_id is false, then we need to go away
		if($event_id === FALSE)
		{
			return redirect('events');
		}

		$this->load->library('Form');

		$this->form
			->open('entries/add/' . $event_id)
			//date changer
			->textarea('comments', $this->lang->line('entries_form_comments'))
			->submit($this->lang->line('entries_form_add_submit'), 'add_new_entry');

		$data['form'] = $this->form->get();

		if ($this->form->valid)
		{
			$post = $this->form->get_post();

			$this->Entry->create($event_id, FALSE, $post['comments']);
			$this->Entry->save();

			//Ok return to main
			return redirect('events');

		}

		$data['title'] = $this->lang->line('entries_add_title');
		$this->template->write_view('content', 'forms', $data);
		$this->template->render();
	}

	/**
	 * Edit a log entry
	 *
	 * @return page
	 */
	public function edit($entry_id = FALSE)
	{
		//If $event_id is false, then we need to go away
		if($entry_id === FALSE)
		{
			return redirect('events');
		}

		$this->Entry->get($entry_id);

		$this->load->library('Form');

		$this->load->model('Event');

		$events = array();

		foreach($this->Event->get_all_events() as $event)
		{
			$events[$event->event_id] = $event->event_name;
		}

		$this->form
			->open('entries/edit/' . $entry_id)
			//date changer
			->select('event_id', $events, $this->lang->line('entries_form_event'), 'required',$this->Entry->event_id)
			->textarea('comments', $this->lang->line('entries_form_comments'), '',$this->Entry->comments)
			->submit($this->lang->line('entries_form_add_submit'), 'add_new_entry');

		$data['form'] = $this->form->get();

		if ($this->form->valid)
		{
			$post = $this->form->get_post();

			$this->Entry->set_timestamp($post['date']);
			$this->Entry->event_id = $post['event_id'][0];
			$this->Entry->comments = $post['comments'];

			$this->Entry->save();

			//Ok return to main
			return redirect('events');

		}

		$data['title'] = $this->lang->line('entries_edit_title');
		$this->template->write_view('content', 'forms', $data);
		$this->template->render();
	}

	/**
	 * Page that shows your history
	 * TODO: Add filtering options?
	 *
	 * @return page
	 */
	public function history()
	{
		$data['entries'] = $this->Entry->get_all_entries();

		$this->load->model('Event');
		$data['events'] = $this->Event->get_all_events(TRUE);

		//Show View
		$data['title'] = $this->lang->line('entries_history_title');
		$this->template->write_view('content', 'history_view', $data);
		$this->template->render();
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */