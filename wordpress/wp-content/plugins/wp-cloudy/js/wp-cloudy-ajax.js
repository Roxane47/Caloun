jQuery(document).ready(function(){
	var wpc_weather_id = document.getElementsByClassName('wpc-weather-id');
	for(var i = 0; i < wpc_weather_id.length; i++) {	
		jQuery.ajax({
			url : wpcAjax,
			method : 'POST',
			data : {
				action: 'wpc_get_my_weather',
				wpc_param : wpc_weather_id[i].attributes.data_id.value,
				wpc_param2 : wpc_weather_id[i].attributes.data_map.value,
				wpc_param3 : wpc_weather_id[i].attributes.data_detect_geolocation.value,
				wpc_param4 : wpc_weather_id[i].attributes.data_manual_geolocation.value,
				wpc_param5 : wpc_weather_id[i].attributes.data_wpc_lat.value,
				wpc_param6 : wpc_weather_id[i].attributes.data_wpc_lon.value,
				wpc_param7 : wpc_weather_id[i].attributes.data_wpc_city_id.value,
				wpc_param8 : wpc_weather_id[i].attributes.data_wpc_city_name.value,
				wpc_param9 : wpc_weather_id[i].attributes.data_custom_font.value,
				wpc_param10 : wpc_weather_id[i].attributes.data_post_id.value,
			},
			success : function( data ) {                    
				if ( data.success ) {
					jQuery( '#wpc-weather-id-' + data.data.weather ).append( data.data.html );
				} else {
					console.log( data.data );
				}
			},
			beforeSend: function(){
		       jQuery(".wpc-loading-spinner").show();
		       jQuery("#wpc-weather").hide();
		    },
		    complete: function(){
		       jQuery(".wpc-loading-spinner").hide();
		       jQuery("#wpc-weather").show();
		    },
		});
	}
});