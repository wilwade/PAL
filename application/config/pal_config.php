<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Access Password MD5
|--------------------------------------------------------------------------
| Currently PAL is a single user system. Here we store the current password
|
*/
$config['pal_password']	= '';
$config['pal_password_salt']	= '';

/*
|--------------------------------------------------------------------------
| CSS Color Classes
|--------------------------------------------------------------------------
| Events can be colored so that they have different looks and then are also
| sortable on the export.
|
| Here is the list of CSS classes that are to be used and the basic color
| name associated with them for dropdown lists.
|
| aqua, black, blue, fuchsia, gray, grey, green, lime, maroon, navy, olive,
| purple, red, silver, teal, white, and yellow
|
*/
$config['pal_colors'] = array(
		'black' => 'black',
		'blue' => 'blue',
		'green' => 'green',
		'red' => 'red',
		'yellow' => 'yellow',
		'purple' => 'purple',
		'teal' => 'teal',
		'gray' => 'gray',
	);
