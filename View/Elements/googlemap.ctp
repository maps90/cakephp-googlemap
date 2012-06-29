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
	$config = array('container_id' => $containerId);
	$this->GoogleMap->configureMapMarkers($markers);
	$this->GoogleMap->configureMapStyles($styles);
	$this->GoogleMap->renderScript($config);
?>
<div id="<?php echo $parentId; ?>" class="<?php echo $parentStyle; ?>">
	<div id="<?php echo $containerId; ?>" class="<?php echo $containerStyle; ?>"/>
</div>
