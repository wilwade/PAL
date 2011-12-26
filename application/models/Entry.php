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
	private $event_id		= -1;
	private $comments		= '';
	private $date			= '';
	private $timestamp		= -1;

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
	function get($entry_id)
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
		$this->date			= new DateTime($row->timestamp, $this->Config->item('timestamp'));
		$this->timestamp	= (int)$row->timestamp;

		return $this;
	}

	/**
	 * Return all the current entrys
	 *
	 * TODO: Only return the ones for the current user
	 *
	 * @return array
	 */
	function get_all_entries()
	{
		$this->db
			->select()
			->order_by('entry_name');
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
			$entry->date			= new DateTime($row->timestamp, $this->Config->item('timestamp'));
			$entry->timestamp		= (int)$row->timestamp;

			$entries[] = $entry;
		}

		return $entries;
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
			unset($this->entry_id);
			$this->db->insert('entry', $this);
			$this->entry_id = $this->db->last_insert_id();
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
	 * @param int	 $timestamp UTC time for the event, defaults to gmmktime
	 * @param string $comments Comments for the entry
	 *
	 *
	 * @return Entry
	 */
	public function create($event_id, $timestamp = FALSE, $comments = '')
	{
		if($timestamp === FALSE)
		{
			//Set to now.
			$timestamp = time();
		}
		$this->event_id		= (int)$event_id;
		$this->comments		= (String)$comments;
		$this->date			= new DateTime($timestamp, $this->Config->item('timestamp'));
		$this->timestamp	= $timestamp;
		return $this;
	}
}