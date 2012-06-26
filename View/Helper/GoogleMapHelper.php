<?php

App::uses('AppHelper', 'View/Helper');

class GoogleMapHelper extends AppHelper {

	public $helpers = array('Html');

	public $container;

	public $centerLat = -6.192438;
	
	public $centerLong = 106.847534;

	public $apiKey;

	public $zoom = 9;

	protected $_markers = array();

	public function __construct(View $view, $settings = array()) {
		parent::__construct($view, $settings);
		if (is_array($settings)) {
			$args = array_map('strtolower', $settings);
			$this->_parseAndSaveArgs($args);
		}
	}

	public function renderScript($args = null) {
		if (!empty($args)) {
			$args = array_map('strtolower', $args);
			$this->_parseAndSaveArgs($args);
		}
		$this->_initializeMapScript();
	}

	public function configureMapOptions($args = null) {
		$args = array_map('strtolower', $args);
		$script =<<<EOF
		GoogleMap.Option.params = {
			center: new google.maps.LatLng($this->centerLat, $this->centerLong),
			zoom: $this->zoom,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
EOF;
		echo $this->Html->scriptBlock($script, array('inline' => false));
	}

	public function configureMapSettings($args = null) {
		$args = array_map('strtolower', $args);
		$this->_parseAndSaveArgs($args);
		$script =<<<EOF
		GoogleMap.Option.params = {
			container: '$this->container';
		}
EOF;
		echo $this->Html->scriptBlock($script, array('inline' => false));
	}

	public function configureMapMarkers($markers = null) {
		$this->_markers = json_encode($markers);
	}

	protected function _initializeMapScript() {
		$script =<<<EOF
		function initializeMap() {
			GoogleMap.Option.params = {
				center: new google.maps.LatLng($this->centerLat, $this->centerLong),
				zoom: $this->zoom,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			GoogleMap.Map.config = {
				container: '$this->container'
			}
			GoogleMap.Map.initialize();
		}

		function initializeMarker() {
			GoogleMap.Marker.populate($this->_markers);
		}

		$(document).ready(function() {
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
		if (array_key_exists('container', $args)) {
			$this->container = $args['container'];
		}
	}
}
