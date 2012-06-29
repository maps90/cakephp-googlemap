<?php

App::uses('AppHelper', 'View/Helper');

class GoogleMapHelper extends AppHelper {

	public $helpers = array(
		'Html',
		'GoogleMap.GoogleMapUtility',
	);

	public $container;

	public $centerLat = -6.192438;
	
	public $centerLong = 106.847534;

	public $zoom = 9;

	public $useDefaultMarker = true;

	protected $_markers = array();

	protected $_styles = array();

	public function __construct(View $view, $settings = array()) {
		parent::__construct($view, $settings);
		if (is_array($settings)) {
			$args = array_map('strtolower', $settings);
			$this->_parseAndSaveArgs($args);
		}
	}

	public function renderScript($config = null, $options = null, $styles = null, $markers = null) {
		$this->_handleParameters($config, $options, $styles, $markers);
		$this->_initializeMapScript();
	}

	protected function _initializeMapScript() {
		$scriptInitialize =<<<EOF
		function initializeMap() {
			GoogleMap.Map.initialize();
		}

		function initializeStyle() {
			GoogleMap.Style.parse($this->_styles);
		}

		$(document).ready(function() {
			initializeStyle();
			initializeMap();
			initializeMarker();
		});
EOF;
		echo $this->Html->scriptBlock($script, array(
			'inline' => false,
		));
	}

	protected function _parseAndSaveArgs($args = array()) {
		if (!is_array($args)) {
			return false;
		}
		if (array_key_exists('container_id', $args)) {
			$this->container = $args['container_id'];
		}
		if (array_key_exists('zoom', $args)) {
			$this->zoom= $args['zoom'];
		}
	}
}
