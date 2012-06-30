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
	GoogleMap.map = new google.maps.Map(document.getElementById(GoogleMap.Map.config.container), GoogleMap.Option.options);
	GoogleMap.Style.setToMap();
	GoogleMap.map.setMapTypeId(GoogleMap.Style.stylesIds[0]);
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

GoogleMap.Option.options;

GoogleMap.namespace('GoogleMap.Style');

GoogleMap.Style.styles = new Array();

GoogleMap.Style.stylesIds = new Array();

GoogleMap.Style.parse = function(params) {
	for (styleName in params) {
		if (params[styleName] == 'roadmap' ||
			params[styleName] == 'satellite' ||
			params[styleName] == 'hybrid' ||
			params[styleName] == 'terrain'
		) {
			GoogleMap.Style.stylesIds.push(GoogleMap.Style.defaultStyle[params[styleName]]);
			continue;
		}
		GoogleMap.Style.stylesIds.push(styleName);
		GoogleMap.Style.styles.push(new google.maps.StyledMapType(
			params[styleName],
			{ name: styleName }
		));
	}
}

GoogleMap.Style.setToMap = function() {
	var ids = GoogleMap.Style.stylesIds;
	var styles = GoogleMap.Style.styles;
	for (var idx=0;idx<ids.length;idx++) {
		if (ids[idx] == 'roadmap' ||
			ids[idx] == 'satellite' ||
			ids[idx] == 'hybrid' ||
			ids[idx] == 'terrain'
		) {
			continue;
		}
		GoogleMap.map.mapTypes.set(ids[idx], styles[idx]);
	}
}

GoogleMap.Style.defaultStyle = {
	roadmap: google.maps.MapTypeId.ROADMAP,
	satellite: google.maps.MapTypeId.SATELLITE,
	terrain: google.maps.MapTypeId.TERRAIN,
	hybrid: google.maps.MapTypeId.HYBRID,
}
