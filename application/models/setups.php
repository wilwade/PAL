<?php

/**
 * Setup Model
 *
 * Functions for setting up the database.
 *
 * @author willmwade
 * @version 1.0
 */
class Setups extends CI_Model
{

	function __constructor()
	{
		parent::__construct();
	}

	/**
	 * Take the current pal configuration and write it to the pal file
	 * Also write out the encryption key to config
	 *
	 * @return void
	 */
	public function write_pal_config($config)
	{
		$this->_write_out_config('pal_config', $config);

		$this->_write_out_config('config', $config);
	}

	/**
	 * A little fuction to save the intial setup configuration
	 *
	 * @param string $file name of the config to write to
	 * @param array $change_array array of changes to make
	 *
	 * @return void
	 */
	private function _write_out_config($file, $change_array)
	{
		$path = APPPATH . "config/{$file}.php";
		$file = file_get_contents($path);

		foreach ($change_array AS $item => $value)
		{
			$file = preg_replace('/(\$config\[(\'|\"){1}' . $item . '(\'|\"){1}\])(\s|\t)*=?(\s|\t)*(\'|\"){0,1}.*(\'|\"){1}(\s)*;/ix', '$config[\'' . $item . '\'] = \'' . $value . '\' ;', $file);
		}
		file_put_contents($path, $file);
	}

	/**
	* Setup the initial database configuration.
	*
	* @param array $config the initial configuration array
	*
	* @return void
	*/
	public function database_config($config)
	{
		$path = APPPATH . 'config/database.php';
		$file = file_get_contents($path);

		foreach ($config AS $item => $value)
		{
			$file = preg_replace('/(\$db\[\'default\'\]\[(\'|\"){1}' . $item . '(\'|\"){1}\])(\s|\t)*=?(\s|\t)*(\'|\"){0,1}.*(\'|\"){1}(\s)*;/ix', '$db[\'default\'][\'' . $item . '\'] = \'' . $value . '\' ;', $file);
		}

		file_put_contents($path, $file);
	}

	/**
	 * Setup the initial database tables.
	 *
	 * TODO: Add multiuser system
	 *
	 * @return bool
	 */
	public function create_tables()
	{
		$this->load->database();
		$this->load->dbforge();

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
				'type' => 'VARCHAR',
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
		if ( ! $this->dbforge->create_table('event'))
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
		if ( ! $this->dbforge->create_table('entry'))
		{
			show_error('Error creating entry table.');
			return FALSE;
		}

		return TRUE;
	}
}