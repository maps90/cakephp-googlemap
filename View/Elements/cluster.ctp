<!-- Example of rendering map in a view or element -->
<?php
/*
 * Examples of adding marker
 */
	$defaultMarkers = array();
	for ($idx=0;$idx<50;$idx++) {
		$title = sprintf('Marker %s',$idx);
		$lat = -7 + mt_rand() / mt_getrandmax() * (-5 - -7);
		$long = 104 + mt_rand() / mt_getrandmax() * (107 - 104);
		$push = array(
			'markerTitle' => $title,
			'markerLat' => $lat,
			'markerLong' => $long,
		);
		array_push($defaultMarkers, $push);
	}

/*
 * Examples of setting map style
 */
	$defaultStyles = array(
		'roadmap',
		'terrain',
		'satellite',
		'hybrid',
	);

/*
 * Examples of setting map config
 */
	$config = array('container_id' => $containerId);

/*
 * Examples of setting map options
 */
	$options = array(
		'center_lat' => -6.192438,
		'center_long' => 106.847534,
		'zoom' => 9,
	);

	$parentId = !empty($parentId)?
		$parentId : 'map-element';
	$parentStyle = !empty($parentStyle)?
		$parentStyle : 'map-element';
	$containerId = !empty($containerId)?
		$containerId : 'map-canvas';
	$containerStyle = !empty($containerStyle)?
		$containerStyle : 'map-canvas';
	$markers = !empty($markers)?
		$markers : $defaultMarkers;
	$styles = !empty($styles)?
		$styles : $defaultStyles;
	$this->GoogleMap->renderScript($config, $options, $styles, $markers);
	$this->GoogleMapUtility->renderClusterScript();
?>
<div id="<?php echo $parentId; ?>" class="<?php echo $parentStyle; ?>">
	<div id="<?php echo $containerId; ?>" class="<?php echo $containerStyle; ?>"/>
</div>
