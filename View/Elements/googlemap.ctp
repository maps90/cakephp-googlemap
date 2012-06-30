<!-- Example of rendering map in a view or element -->
<?php
	/*
	 * Examples of adding marker
	 */
	$defaultMarkers = array(
		array(
			'markerTitle' => 'Example Marker',
			'markerLat' => -6.211032,
			'markerLong' => 106.845097,
		),
	);
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
?>
<div id="<?php echo $parentId; ?>" class="<?php echo $parentStyle; ?>">
	<div id="<?php echo $containerId; ?>" class="<?php echo $containerStyle; ?>"/>
</div>
