<?php

App::uses('AppHelper', 'View/Helper');

class GoogleMapHelper extends AppHelper {

	public $helpers = array(
		'Js',
		'GoogleMap.GoogleMapUtility',
	);

	protected $_markerDefault = true;

	protected $_markerCluster = false;

	protected $_config = array(
		'container_id' => 'map-canvas'
	);

	protected $_options = array(
		'center_lat' => -6.192438,
		'center_long' => 106.847534,
		'zoom' => 9,
	);

	protected $_styles = array(
		'roadmap',
		'satellite',
	);

	protected $_markers = array();

	public function __construct(View $view, $settings = array()) {
		parent::__construct($view, $settings);
		if (is_array($settings)) {
			$settings = array_map('strtolower', $settings);
		}
	}

	public function renderScript($config = null, $options = null, $styles = null, $markers = null) {
		$this->_setParameters($config, $options, $styles, $markers);
		$this->_renderInitializeScript();
		$this->_renderMap();
	}

	protected function _renderMap() {
		$script =<<<EOF
		var initializeMap = function() {
			GoogleMap.Map.initialize();
		}
		var initializeStyle = function() {
			GoogleMap.Map.setStyle();
		}
EOF;
		$this->Js->buffer($script);
		if (!empty($this->_markers) && $this->_markerDefault) {
			$script =<<<EOF
		var initializeMarker = function() {
			GoogleMap.Map.setMarker();
		}
EOF;
			$this->Js->buffer($script);
		}
		$script =<<<EOF
		$(document).ready(function() {
			initializeMap();
			initializeStyle();
			if (typeof initializeMarker !== "undefined") {
				initializeMarker();
			}
		});
EOF;
		$this->Js->buffer($script);
		$this->Js->writeBuffer(array(
			'inline' => false,
			'onDomReady' => false,
		));
	}

	protected function _renderInitializeScript() {
		$this->_bufferSetConfig();
		$this->_bufferSetStyles();
		$this->_bufferSetOptions();
		if (!empty($this->_markers)) {
			$this->_bufferSetMarkers();
		}
		$this->Js->writeBuffer(array(
			'inline' => false,
			'onDomReady' => false,
		));
	}

	protected function _bufferSetConfig() {
		$container = $this->_config['container_id'];
		$script =<<<EOF
		GoogleMap.Map.config = {
			container: '$container'
		}
EOF;
		$this->Js->buffer($script);
	}

	protected function _bufferSetOptions() {
		$zoom = $this->_options['zoom'];
		$centerLat = $this->_options['center_lat'];
		$centerLong = $this->_options['center_long'];
		$script =<<<EOF
		GoogleMap.Option.options = {
			center: new google.maps.LatLng($centerLat, $centerLong),
			zoom: $zoom,
			mapTypeControlOptions: {
				mapTypeIds: GoogleMap.Style.stylesIds
			}
		};
EOF;
		$this->Js->buffer($script);
	}

	protected function _bufferSetStyles() {
		$this->_styles = json_encode($this->_styles);
		$script =<<<EOF
		GoogleMap.Style.parse($this->_styles);
EOF;
		$this->Js->buffer($script);
	}

	protected function _bufferSetMarkers() {
		$this->_markers = json_encode($this->_markers);
		$script =<<<EOF
		GoogleMap.Marker.populate($this->_markers);
EOF;
		$this->Js->buffer($script);
	}

	protected function _setParameters($config, $options, $styles, $markers) {
		$this->setMapConfig($config);

		$this->setMapOptions($options);

		$this->setMapStyles($styles);

		$this->setMapMarkers($markers);
	}

	public function setMapStyles($styles) {
		if (empty($styles)) {
			return false;
		}
		$this->_styles = $styles;
	}

	public function setMapMarkers($markers) {
		if (empty($markers)) {
			return false;
		}
		$this->_markers = $markers;
	}

	public function setMapConfig($config) {
		if (empty($config)) {
			return false;
		}
		$this->_config = $config;
	}

	public function setMapOptions($options) {
		if (empty($options)) {
			return false;
		}
		$this->_options = $options;
	}
}
