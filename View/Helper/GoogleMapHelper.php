<?php

App::uses('AppHelper', 'View/Helper');

class GoogleMapHelper extends AppHelper {

	public $helpers = array(
		'Js',
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
			$settings = array_map('strtolower', $settings);
		}
	}

	public function renderScript($config = null, $options = null, $styles = null, $markers = null) {
		$this->_handleParameters($config, $options, $styles, $markers);
		$this->_initializeMapScript();
	}

	protected function _initializeMapScript() {
		$script =<<<EOF
		var initializeMap = function() {
			GoogleMap.Map.initialize();
		}
		var initializeStyle = function() {
			GoogleMap.Style.parse($this->_styles);
		}
EOF;
		$this->Js->buffer($script);

		if ($this->useDefaultMarker && !empty($this->_markers)) {
			$script =<<<EOF
		var initializeMarker = function() {
			GoogleMap.Marker.populate($this->_markers);
		}
EOF;
			$this->Js->buffer($script);
			$script =<<<EOF
		$(document).ready(function() {
			initializeStyle();
			initializeMap();
			initializeMarker();
		});
EOF;
		} else {
			$script =<<<EOF
		$(document).ready(function() {
			initializeStyle();
			initializeMap();
		});
		}
		$this->Js->buffer($script);
		$this->Js->writeBuffer(array(
			'inline' => false,
			'onDomReady' => false,
		));
	}

	protected function _handleParameters($config, $options, $styles, $markers) {
		if (!empty($config)) {
			$args = array_map('strtolower', $config);
			$this->_parseAndSaveConfig($config);
		}
		if (!empty($options)) {
			$options = array_map('strtolower', $options);
			$this->_parseAndSaveOptions($options);
		}
		if (!empty($styles)) {
			$this->configureMapStyles($styles);
		}
		if (!empty($markers)) {
			$this->configureMapMarkers($markers);
		}
		$this->Js->writeBuffer(array(
			'inline' => false,
			'onDomReady' => false,
		));
	}

	public function configureMapStyles($styles) {
		$this->_styles = json_encode($styles);
	}

	public function configureMapMarkers($markers) {
		$this->_markers = json_encode($markers);
	}

	protected function _parseAndSaveConfig($config) {
		if (!is_array($config)) {
			return false;
		}
		if (array_key_exists('container_id', $config)) {
			$this->container = $config['container_id'];
		}
		$script =<<<EOF
		GoogleMap.Map.config = {
			container: '$this->container'
		}
EOF;
		$this->Js->buffer($script);
	}

	protected function _parseAndSaveOptions($options) {
		if (!is_array($options)) {
			return false;
		}
		if (array_key_exists('zoom', $options)) {
			$this->zoom = $options['zoom'];
		}
		if (array_key_exists('center_lat', $options)) {
			$this->centerLat= $options['center_lat'];
		}
		if (array_key_exists('center_long', $options)) {
			$this->centerLong= $options['center_long'];
		}
		$script =<<<EOF
		GoogleMap.Option.options = {
			center: new google.maps.LatLng($this->centerLat, $this->centerLong),
			zoom: $this->zoom,
			mapTypeControlOptions: {
				mapTypeIds: GoogleMap.Style.stylesIds
			}
		};
EOF;
		$this->Js->buffer($script);
	}
}
