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

	public function renderScript($args = null) {
		if (!empty($args)) {
			$args = array_map('strtolower', $args);
			$this->_parseAndSaveArgs($args);
		}
		$this->_initializeMapScript();
	}

	public function configureMapMarkers($markers) {
		$this->_markers = json_encode($markers);
	}

	public function configureMapStyles($styles = null) {
		if (empty($styles)) {
			if (!empty($this->_styles)) {
				$this->_styles = json_encode($this->_styles);
			}
			return;
		}
		$this->_styles = json_encode($styles);
	}

	protected function _initializeMapScript() {
		$script =<<<EOF
		function initializeMap() {
			GoogleMap.Option.options= {
				center: new google.maps.LatLng($this->centerLat, $this->centerLong),
				zoom: $this->zoom,
				mapTypeControlOptions: {
					mapTypeIds: GoogleMap.Style.stylesIds
				}
			};
			GoogleMap.Map.config = {
				container: '$this->container'
			}
			GoogleMap.Map.initialize();
		}

		function initializeMarker() {
			GoogleMap.Marker.populate($this->_markers);
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
