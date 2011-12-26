<?php

if ( ! defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * Entry Model
 *
 * Working with Entry Table
 *
 * @author willmwade
 * @version 1.0
 */
class Entry extends CI_Model
{

	private $entry_id		= -1;
	public $event_id		= -1;
	public $comments		= '';
	public $date			= NULL;
	public $timestamp		= -1;

	function __constructor()
	{
		parent::__construct();
	}

	/**
	 * Get an entry
	 *
	 * @param int $entry_id Id of the Entry
	 *
	 * @return Entry
	 */
	public function get($entry_id)
	{
		$this->db
			->select()
			->where('entry_id', $entry_id);
		$query = $this->db->get('entry');
		if($query-> num_rows() === 0)
		{
			return FALSE;
		}

		$row = $query->row();

		$this->entry_id		= (int)$row->entry_id;
		$this->event_id		= (int)$row->event_id;
		$this->comments		= (String)$row->comments;
		$this->date			= new DateTime(NULL, $this->config->item('timezone'));
		$this->date->setTimestamp($row->timestamp);
		$this->timestamp	= (int)$row->timestamp;

		return $this;
	}

	/**
	 * Return the current entry id
	 *
	 * @return int
	 */
	public function get_entry_id()
	{
		return $this->entry_id;
	}

	/**
	 * Return all the current entrys
	 *
	 * TODO: Only return the ones for the current user
	 *
	 * @return array
	 */
	public function get_all_entries()
	{
		$this->db
			->select()
			->order_by('timestamp', 'DESC');
		$query = $this->db->get('entry');
		if($query-> num_rows() === 0)
		{
			return FALSE;
		}

		$entries = array();

		foreach($query->result() as $row)
		{
			$entry->entry_id		= (int)$row->entry_id;
			$entry->event_id		= (int)$row->event_id;
			$entry->comments		= (String)$row->comments;
			$entry->date			= new DateTime(NULL, $this->config->item('timezone'));
			$entry->date->setTimestamp($row->timestamp);

			$entries[] = $entry;
			unset($entry);
		}

		return $entries;
	}

	/**
	 * Set the timestamp.
	 *
	 * @param string $local_time_string strtotime parsable local time string.
	 *
	 * @return Entry
	 */
	public function set_timestamp($local_time_string = 'now')
	{
		date_default_timezone_set($this->config->item('timezone'));
		$this->timestamp = strtotime($local_time_string);
		$this->date = new DateTime(NULL, $this->config->item('timezone'));
		$this->date->setTimestamp($row->timestamp);
		return $this;
	}

	/**
	 * Take the changes to the Entry and save them to the db
	 *
	 * @return Entry
	 */
	public function save()
	{
		if($this->entry_id === -1)
		{
			//This is a new entry. Insert Please
			$this->db->insert('entry', $this);
			$this->entry_id = $this->db->insert_id();
			return $this;
		}
		else
		{
			$this->db->update($this->entry_id, $this);
			return $this;
		}
	}

	/**
	 * Create a new Entry based on the following
	 *
	 * @param string $event_id Event id to connect to the entry
	 * @param int	 $timestring Time string, empty for now.
	 * @param string $comments Comments for the entry
	 *
	 *
	 * @return Entry
	 */
	public function create($event_id, $timestring = 'now', $comments = '')
	{
		$this->set_timestamp($timestring);

		$this->event_id		= (int)$event_id;
		$this->comments		= (String)$comments;


		return $this;
	}
}