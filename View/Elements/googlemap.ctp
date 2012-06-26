<?php
	$parentId = !empty($parentId)?
		$parentId : 'map-element';
	$parentStyle = !empty($parentStyle)?
		$parentStyle : 'map-element';
	$containerId = !empty($containerId)?
		$containerId : 'mapcanvas';
	$containerStyle = !empty($containerStyle)?
		$containerStyle : 'mapcanvas';
	$markers = !empty($markers)?
		$markers : array();
	$args = array('container' => $containerId);
	$this->GoogleMap->configureMapMarkers($markers);
	$this->GoogleMap->renderScript($args);
?>
<div id="<?php echo $parentId; ?>" class="<?php echo $parentStyle; ?>">
	<div id="<?php echo $containerId; ?>" class="<?php echo $containerStyle; ?>"/>
</div>
