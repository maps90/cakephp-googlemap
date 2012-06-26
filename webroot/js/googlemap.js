if (typeof GoogleMap == "undefined") {
	var GoogleMap= {};
	GoogleMap.namespace = function() {
		var a=arguments, o=null, i, j, d;
		for (i=0; i<a.length; i=i+1) {
			d=a[i].split(".");
			o=window;
			for (j=0; j<d.length; j=j+1) {
				o[d[j]]=o[d[j]] || {};
				o=o[d[j]];
			}
		}
		return o;
	}
}

GoogleMap.map;

GoogleMap.namespace('GoogleMap.Map');

GoogleMap.Map.config;

GoogleMap.Map.initialize = function() {
	var container = GoogleMap.Map.config.container;

	GoogleMap.map = new google.maps.Map(document.getElementById(container), GoogleMap.Option.params);
}

GoogleMap.namespace('GoogleMap.Marker');

GoogleMap.Marker.markers = new Array();

GoogleMap.Marker.populate = function(params) {
	for (var i=0;i<params.length;i++) {
		GoogleMap.Marker.add(params[i]);
	}
}

GoogleMap.Marker.add = function(params) {
	var latLng = new google.maps.LatLng(params.markerLat, params.markerLong);
	var marker = new google.maps.Marker({
		position: latLng,
		title: params.markerTitle,
		icon: params.markerIcon,
	});
	marker.setMap(GoogleMap.map);
	GoogleMap.Marker.markers.push(marker);
}

GoogleMap.namespace('GoogleMap.Option');

GoogleMap.Option.params;

GoogleMap.namespace('GoogleMap.Util');
