<?php
	$parentId = !empty($parentId)?
		$parentId : 'map-element';
	$parentStyle = !empty($parentStyle)?
		$parentStyle : 'map-element';
	$containerId = !empty($containerId)?
		$containerId : 'map-canvas';
	$containerStyle = !empty($containerStyle)?
		$containerStyle : 'map-canvas';
	$markers = !empty($markers)?
		$markers : array();
	$styles = !empty($styles)?
		$styles : array();
	/*
	 * Examples of setting map style
	 */
	$styles = array(
		'roadmap',
		'terrain',
		'satellite',
		'hybrid',
	);
	$args = array('container_id' => $containerId);
	$this->GoogleMap->configureMapMarkers($markers);
	$this->GoogleMap->configureMapStyles($styles);
	$this->GoogleMap->renderScript($args);
?>
<div id="<?php echo $parentId; ?>" class="<?php echo $parentStyle; ?>">
	<div id="<?php echo $containerId; ?>" class="<?php echo $containerStyle; ?>"/>
</div>
