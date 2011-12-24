<?php

/**
 * Setup Model
 * 
 * Functions for setting up the database.
 *
 * @author willmwade
 * @version 1.0
 */
class Setup extends CI_Model {

	function __constructor()
	{

	}

	/**
	* Setup the initial database configuration.
	*
	* @param array $config the initial configuration array 
	*
	* @return bool
	*/	
	public function setup_initial_database($config)
	{
		$this->_database_config($config);
		
		$this->load->database();		
		$this->load->dbforge();
		
		//TODO: check for existing database first...
		if( ! $this->dbforge->create_database($config['database']))
		{
			return FALSE;
		}
		
		if( ! $this->_create_tables())
		{
			return FALSE;
		}
		
		return TRUE;
	}
	
	/**
	* Setup the initial database configuration.
	*
	* @param array $config the initial configuration array 
	*
	* @return void
	*/		
	private function _database_config($config)
	{
		$this->config->set_item('hostname', $config['hostname']);
		$this->config->set_item('username', $config['username']);
		$this->config->set_item('password', $config['password']);
		$this->config->set_item('database', $config['database']);
		$this->config->set_item('dbprefix', $config['dbprefix']);
	}
	
	/**
	* Setup the initial database tables.
	* 
	* TODO: Add multiuser system
	*
	* @return bool
	*/		
	private function _create_tables()
	{
		$event = array(
         'event_id' => array(
             'type' => 'INT',
             'constraint' => 10, 
             'unsigned' => TRUE,
             'auto_increment' => TRUE
                           ),
         'event_name' => array(
             'type' => 'VARCHAR',
             'constraint' => '256',
                           ),
         'color' => array(
             'type' =>'VARCHAR',
             'constraint' => '24',
             'null' => TRUE,
                           ),
         'description' => array(
                'type' => 'TEXT',
                'null' => TRUE,
                           ),
       );
		$this->dbforge->add_field($event); 
		$this->dbforge->add_key('event_id', TRUE);
		if( ! $this->dbforge->create_table('event'))
		{
			show_error('Error creating event table.');
			return FALSE;
		}
		
		$entry = array(
         'entry_id' => array(
             'type' => 'INT',
             'constraint' => 10, 
             'unsigned' => TRUE,
             'auto_increment' => TRUE
                           ),
         'event_id' => array(
             'type' => 'INT',
             'constraint' => 10, 
             'unsigned' => TRUE,
             'null' => TRUE,
                           ),
         'event_name' => array(
             'type' => 'INT',
             'unsigned' => TRUE,
             'constraint' => 14,
                           ),
         'comments' => array(
                'type' => 'TEXT',
                'null' => TRUE,
                           ),
       );
		$this->dbforge->add_field($entry); 
		$this->dbforge->add_key('event_id', TRUE);
		$this->dbforge->add_key('entry_id', TRUE);
		if( ! $this->dbforge->create_table('entry'))
		{
			show_error('Error creating entry table.');
			return FALSE;
		}
		
		return TRUE;
		
	}
}