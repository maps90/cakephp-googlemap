<?php

class GoogleMapSchema extends CakeSchema {
	var $name = 'GoogleMap';

	public $marker = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'latitude' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'longitude' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'indexes' => array(
			'id' => array('column' => array('id'), 'unique' => true),
		),
	);

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}
}
