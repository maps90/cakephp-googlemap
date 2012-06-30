<?php

App::uses('AppHelper', 'View/Helper');

class GoogleMapUtilityHelper extends AppHelper {

	public $helpers = array('Js');

	protected $_clusterOptions = array(
		'gridSize' => 50,
		'maxZoom' => 15,
	);

	public function __construct(View $view, $settings = array()) {
		parent::__construct($view, $settings);
		if (is_array($settings)) {
			$settings = array_map('strtolower', $settings);
		}
	}

	public function renderClusterScript($options = null) {
		$this->setClusterOptions($options);
		$this->_renderInitializeCluster();
		$this->_renderCluster();
	}

	protected function _renderCluster() {
		$script =<<<EOF
		$(document).ready(function() {
			GoogleMap.Cluster.cluster = new MarkerClusterer(
				GoogleMap.map,
				GoogleMap.Marker.markers,
				GoogleMap.Cluster.options
			);
		});
EOF;
		$this->Js->buffer($script);
		$this->Js->writeBuffer(array(
			'inline' => false,
			'onDomReady' => false,
		));
	}

	protected function _renderInitializeCluster() {
		$gridSize = $this->_clusterOptions['gridSize'];
		$maxZoom = $this->_clusterOptions['maxZoom'];
		$script =<<<EOF
		GoogleMap.Cluster.options = {
			gridSize: $gridSize,
			maxZoom: $maxZoom
		};
EOF;
		$this->Js->buffer($script);
	}

	public function setClusterOptions($options) {
		if (empty($options)) {
			return false;
		}
		$this->_clusterOptions = $options;
	}
}
