<?php

if ( ! defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * Event Model
 *
 * Working with Event Table
 *
 * @author willmwade
 * @version 1.0
 */
class Event extends CI_Model
{

	private $event_id		= -1;
    private $event_name	= '';
    private $color			= '';
	private $description   = '';

	function __constructor()
	{
		parent::__construct();
	}

	/**
	 * Get an event
	 *
	 * @param int $event_id Id of the Event
	 *
	 * @return Event
	 */
	function get($event_id)
	{
		$this->db
			->select()
			->where('event_id', $event_id);
		$query = $this->db->get('event');
		if($query-> num_rows() === 0)
		{
			return FALSE;
		}

		$row = $query->row();

		$this->event_id		= (int)$row->event_id;
		$this->event_name	= (String)$row->event_name;
		$this->color		= (String)$row->color;
		$this->description	= (String)$row->description;

		return $this;
	}

	/**
	 * Return all the current events
	 *
	 * TODO: Only return the ones for the current user
	 *
	 * @return array
	 */
	function get_all_events()
	{
		$this->db
			->select()
			->order_by('event_name');
		$query = $this->db->get('event');
		if($query-> num_rows() === 0)
		{
			return FALSE;
		}

		$events = array();

		foreach($query->result() as $row)
		{
			$event->event_id	= (int)$row->event_id;
			$event->event_name	= (String)$row->event_name;
			$event->color		= (String)$row->color;
			$event->description	= (String)$row->description;

			$events[] = $event;
		}

		return $events;
	}

	/**
	 * Take the changes to the Event and save them to the db
	 *
	 * @return Event
	 */
	public function save()
	{
		if($this->event_id === -1)
		{
			//This is a new entry. Insert Please
			unset($this->event_id);
			$this->db->insert('event', $this);
			$this->event_id = $this->db->last_insert_id();
			return $this;
		}
		else
		{
			$this->db->update($this->event_id, $this);
			return $this;
		}
	}

	/**
	 * Create a new Event based on the following
	 *
	 * @param string $event_name name of the event
	 * @param string $color color category for the event
	 * @param string $description description of the event
	 *
	 * @return Event
	 */
	public function create($event_name, $color = '', $description = '')
	{
		$this->event_name	= (String)$event_name;
		$this->color		= (String)$color;
		$this->description	= (String)$description;
		return $this;
	}
}