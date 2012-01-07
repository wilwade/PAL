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
		if($this->input->post('cancel'))
		{
			return redirect('events');
		}

		//If $event_id is false, then we need to go away
		if($event_id === FALSE)
		{
			return redirect('events');
		}

		$this->load->model('Event');

		$event = $this->Event->get($event_id);

		$this->load->library('Form');

		$date = new DateTime('now', $this->config->item('timezone'));
		$hours = array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12');
		$minutes = array('00' => '00', '05' => '05', '10' => '10', '15' => '15', '20' => '20', '25' => '25', '30' => '30', '35' => '35', '40' => '40', '45' => '45', '50' => '50', '55' => '55');
		$ampm = array('am' => 'AM', 'pm' => 'PM');

		$this->form
			->html("<h2>{$event->event_name}</h2>")
			->open('entries/add/' . $event_id)
			->text('date', $this->lang->line('entries_form_date'), 'required', $date->format('Y-m-d'), array(
				'type' => 'date',
				)) //Date
			->select(
				'hour',
				$hours,
				$this->lang->line('entries_form_time'),
				$date->format('g'),
				'required',
					array(
					'class' => 'form_time',
					)
				) //Date
			->select(
				'minute',
				$minutes,
				'',
				floor($date->format('i') / 5) * 5,
				'required',
					array(
					'class' => 'form_time',
					)
				) //Date
			->select(
				'ampm',
				$ampm,
				'',
				$date->format('a'),
				'required',
					array(
					'class' => 'form_time',
					)
				) //Date
			->textarea('comments', $this->lang->line('entries_form_comments'))
			->submit($this->lang->line('entries_form_add_submit'), 'add_new_entry')
			->submit($this->lang->line('cancel'), 'cancel');

		$data['form'] = $this->form->get();

		if ($this->form->valid)
		{
			$post = $this->form->get_post();

			$this->Entry->create($event_id, "{$post['date']} {$post['hour'][0]}:{$post['minute'][0]} {$post['ampm'][0]}", $post['comments']);
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
		if($this->input->post('cancel'))
		{
			return redirect('entries/history');
		}
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

		$hours = array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12');
		$minutes = array('00' => '00', '05' => '05', '10' => '10', '15' => '15', '20' => '20', '25' => '25', '30' => '30', '35' => '35', '40' => '40', '45' => '45', '50' => '50', '55' => '55');
		$ampm = array('am' => 'AM', 'pm' => 'PM');
		$this->form
			->html("<h2>{$events[$this->Entry->event_id]}</h2>")
			->open('entries/edit/' . $entry_id)
			->text('date', $this->lang->line('entries_form_date'), 'required', $this->Entry->date->format('Y-m-d'), array(
				'type' => 'date',
				)) //Date
			->select(
				'hour',
				$hours,
				$this->lang->line('entries_form_time'),
				$this->Entry->date->format('g'),
				'required',
					array(
					'class' => 'form_time',
					)
				) //Date
			->select(
				'minute',
				$minutes,
				'',
				floor($this->Entry->date->format('i') / 5) * 5,
				'required',
					array(
					'class' => 'form_time',
					)
				) //Date
			->select(
				'ampm',
				$ampm,
				'',
				$this->Entry->date->format('a'),
				'required',
					array(
					'class' => 'form_time',
					)
				) //Date
			->select('event_id', $events, $this->lang->line('entries_form_event'), $this->Entry->event_id, 'required')
			->textarea('comments', $this->lang->line('entries_form_comments'), '',$this->Entry->comments)
			->submit($this->lang->line('entries_form_edit_submit'), 'add_new_entry')
			->submit($this->lang->line('cancel'), 'cancel');

		$data['form'] = $this->form->get();

		if ($this->form->valid)
		{
			$post = $this->form->get_post();

			$this->Entry->set_timestamp("{$post['date']} {$post['hour'][0]}:{$post['minute'][0]} {$post['ampm'][0]}");
			$this->Entry->event_id = $post['event_id'][0];
			$this->Entry->comments = $post['comments'];

			$this->Entry->save();

			//Ok return to main
			return redirect('entries/history');

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
	public function history($page = 0)
	{
		$data['page_next'] = $page + 1;
		$data['page_previous'] = $page - 1;

		$page = $page * 20;
		$data['entries'] = $this->Entry->get_all_entries(20, $page);

		$data['next'] = count($data['entries']) === 20 ? TRUE : FALSE;
		$data['previous'] = (int)$page === 0 ? FALSE : TRUE;

		$this->load->model('Event');
		$data['events'] = $this->Event->get_all_events(TRUE);

		//Show View
		$data['title'] = $this->lang->line('entries_history_title');
		$this->template->write_view('content', 'history_view', $data);
		$this->template->render();
	}

	/**
	 * Delete an entry
	 *
	 * @param int $entry_id id to delete
	 *
	 * @return redirect
	 */
	public function delete($entry_id)
	{
		$this->Entry->delete($entry_id);
		return redirect('entries/history');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
