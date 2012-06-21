<?php
	$containerId == isset($containerId)?
		$containerId : 'mapcanvas';
	$containerStyle == isset($containerStyle)?
		$containerId : 'mapcanvas';
	$args = array('container' => $containerId);
	$this->GoogleMap->renderScript($args);
?>
<div id="map-element" class="map-element">
	<?php
		echo $this->Html->div(
			$containerStyle,
			'',
			array('id' => $containerId)
		);
	?>
</div>
