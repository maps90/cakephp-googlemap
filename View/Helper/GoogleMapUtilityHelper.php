<?php

App::uses('AppHelper', 'View/Helper');

class GoogleMapUtilityHelper extends AppHelper {

	public function __construct(View $view, $settings = array()) {
		parent::__construct($view, $settings);
		if (is_array($settings)) {
			$settings = array_map('strtolower', $settings);
		}
	}
}
