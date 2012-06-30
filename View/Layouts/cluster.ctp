<?php
/*
 * Layout example for using Google Map plugin
 *
 * @author Raymond Lagonda <raymond.lagonda@gmail.com>
 */
?>
<!DOCTYPE html>
<html> 
<head> 
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" /> 
	<style type="text/css"> 
		html { height: 100% } 
		body { height: 100%; margin: 0; padding: 0 } 
		#map-canvas { height: 100%; width: 100%; } 
		#map-element { height: 600px; width: 800px; } 
	</style> 
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBCMz1P5mlxTsffeNk8muoky-QDKcz0eeo&sensor=false"></script> 
	<?php 
		echo $this->Html->charset(); 
		echo $this->Layout->meta(); 
		echo $this->Layout->feed();
		echo $this->Html->script(array(
				'jquery/jquery.min',
				'GoogleMap.googlemap',
				'GoogleMap.markerclusterer',
			)
		);
		echo $scripts_for_layout;
	?>
</head> 
<body>
	<div class="container-map-content"><?php echo $this->fetch('content'); ?></div>
</body> 
</html>
