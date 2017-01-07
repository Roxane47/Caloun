<?php
// To prevent calling the plugin directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Please don&rsquo;t call the plugin directly. Thanks :)';
	exit;
}
///////////////////////////////////////////////////////////////////////////////////////////////////
//WPC Options Panel
///////////////////////////////////////////////////////////////////////////////////////////////////		
//Bypass Unit
function get_admin_bypass_unit() {
	$wpc_admin_bypass_unit_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_admin_bypass_unit_option ) ) {
		foreach ($wpc_admin_bypass_unit_option as $key => $wpc_admin_bypass_unit_value)
			$options[$key] = $wpc_admin_bypass_unit_value;
		 if (isset($wpc_admin_bypass_unit_option['wpc_basic_bypass_unit'])) { 
		 	return $wpc_admin_bypass_unit_option['wpc_basic_bypass_unit'];
		 }
	}
};

function get_admin_unit() {
	$wpc_admin_unit_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_unit_option ) ) {
		foreach ($wpc_admin_unit_option as $key => $wpc_admin_unit_value)
			$options[$key] = $wpc_admin_unit_value;
		if (isset($wpc_admin_unit_option['wpc_basic_unit'])) { 
			return $wpc_admin_unit_option['wpc_basic_unit'];
		}
	}
};

function get_unit($attr) {
	$id = (int)$_POST['wpc_param'];
	$wpc_unit_value = get_post_meta($id,'_wpcloudy_unit',true);
	return $wpc_unit_value;
};

function get_bypass_unit($attr) {
	if (get_admin_unit() && (get_admin_bypass_unit())) {
		return get_admin_unit(); 
	}
	else {
		return get_unit($attr);
	}
}	
//Bypass Date format
function get_admin_bypass_date() {
	$wpc_admin_bypass_date_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_admin_bypass_date_option ) ) {
		foreach ($wpc_admin_bypass_date_option as $key => $wpc_admin_bypass_date_value)
			$options[$key] = $wpc_admin_bypass_date_value;
		 if (isset($wpc_admin_bypass_date_option['wpc_basic_bypass_date'])) { 
		 	return $wpc_admin_bypass_date_option['wpc_basic_bypass_date'];
		 }
	}
};

function get_admin_date() {
	$wpc_admin_date_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_date_option ) ) {
		foreach ($wpc_admin_date_option as $key => $wpc_admin_date_value)
			$options[$key] = $wpc_admin_date_value;
		if (isset($wpc_admin_date_option['wpc_basic_date'])) { 
			return $wpc_admin_date_option['wpc_basic_date'];
		}
	}
};

function get_date($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_date_value = get_post_meta($id,'_wpcloudy_date_format',true);
		return $wpc_date_value;
};

function get_bypass_date($attr) {
	if (get_admin_date() && (get_admin_bypass_date())) {
		return get_admin_date(); 
	}
	else {
		return get_date($attr);
	}
}	
//Bypass Forecast Days
function get_admin_bypass_forecast_nd() {
	$wpc_admin_bypass_forecast_nd_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_admin_bypass_forecast_nd_option ) ) {
		foreach ($wpc_admin_bypass_forecast_nd_option as $key => $wpc_admin_bypass_forecast_nd_value)
			$options[$key] = $wpc_admin_bypass_forecast_nd_value;
		if (isset($wpc_admin_bypass_forecast_nd_option['wpc_display_bypass_forecast_nd'])) {
			return $wpc_admin_bypass_forecast_nd_option['wpc_display_bypass_forecast_nd'];
		}
	}
};

function get_admin_forecast_nd() {
	$wpc_admin_forecast_nd_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_forecast_nd_option ) ) {
		foreach ($wpc_admin_forecast_nd_option as $key => $wpc_admin_forecast_nd_value)
			$options[$key] = $wpc_admin_forecast_nd_value;
		if (isset($wpc_admin_forecast_nd_option['wpc_display_forecast_nd'])) {
			return $wpc_admin_forecast_nd_option['wpc_display_forecast_nd'];
		}
	}
};

function get_forecast_nd($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_forecast_nd_value = get_post_meta($id,'_wpcloudy_forecast_nd',true);
		return $wpc_forecast_nd_value;
};

function get_bypass_forecast_nd($attr) {
	if (get_admin_forecast_nd() && (get_admin_bypass_forecast_nd())) {
		return get_admin_forecast_nd(); 
	}
	else {
		return get_forecast_nd($attr);
	}
}	

//Bypass Forecast Precipitations
function get_admin_bypass_forecast_precipitations() {
	$wpc_display_forecast_precipitations_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_display_forecast_precipitations_option ) ) {
		foreach ($wpc_display_forecast_precipitations_option as $key => $wpc_display_forecast_precipitations_value)
			$options[$key] = $wpc_display_forecast_precipitations_value;
		if (isset($wpc_display_forecast_precipitations_option['wpc_display_forecast_precipitations'])) {
			return $wpc_display_forecast_precipitations_option['wpc_display_forecast_precipitations'];
		}
	}
};
function get_display_forecast_precipitations($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpcloudy_forecast_precipitations_value = get_post_meta($id,'_wpcloudy_forecast_precipitations',true);
		return $wpcloudy_forecast_precipitations_value;
};

function get_bypass_forecast_precipitation($attr) {
	if (get_admin_bypass_forecast_precipitations()) {
		return get_admin_bypass_forecast_precipitations(); 
	}
	else {
		return get_display_forecast_precipitations($attr);
	}
}

//Bypass link to OpenWeatherMap
function get_admin_display_owm_link() {
	$wpc_admin_display_owm_link_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_admin_display_owm_link_option ) ) {
		foreach ($wpc_admin_display_owm_link_option as $key => $wpc_admin_display_owm_link_value)
			$options[$key] = $wpc_admin_display_owm_link_value;
		if (isset($wpc_admin_display_owm_link_option['wpc_display_owm_link'])) {
			return $wpc_admin_display_owm_link_option['wpc_display_owm_link'];
		}
	}
};
function get_display_owm_link($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpcloudy_display_owm_link_value = get_post_meta($id,'_wpcloudy_owm_link',true);
		return $wpcloudy_display_owm_link_value;
};

function get_bypass_owm_link($attr) {
	if (get_admin_display_owm_link()) {
		return get_admin_display_owm_link(); 
	}
	else {
		return get_display_owm_link($attr);
	}
}

//Bypass display update date
function get_admin_display_last_udpate() {
	$wpc_admin_display_last_udpate_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_admin_display_last_udpate_option ) ) {
		foreach ($wpc_admin_display_last_udpate_option as $key => $wpc_admin_display_last_udpate_value)
			$options[$key] = $wpc_admin_display_last_udpate_value;
		if (isset($wpc_admin_display_last_udpate_option['wpc_display_last_update'])) {
			return $wpc_admin_display_last_udpate_option['wpc_display_last_update'];
		}
	}
};
function get_display_last_udpate($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpcloudy_display_last_update_value = get_post_meta($id,'_wpcloudy_last_update',true);
		return $wpcloudy_display_last_update_value;
};

function get_bypass_last_update($attr) {
	if (get_admin_display_last_udpate()) {
		return get_admin_display_last_udpate(); 
	}
	else {
		return get_display_last_udpate($attr);
	}
}
//Disables CSS3 animations
function get_admin_disable_css3_anims() {
	$wpc_admin_disable_css3_anims_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_admin_disable_css3_anims_option ) ) {
		foreach ($wpc_admin_disable_css3_anims_option as $key => $wpc_admin_disable_css3_anims_value)
			$options[$key] = $wpc_admin_disable_css3_anims_value;
		if (isset($wpc_admin_disable_css3_anims_option['wpc_advanced_disable_css3_anims'])) {
			return $wpc_admin_disable_css3_anims_option['wpc_advanced_disable_css3_anims'];
		}
	}
};
function get_disable_css3_anims($wpc_id) {
		$wpcloudy_disable_anims_value = get_post_meta($wpc_id,'_wpcloudy_disable_anims',true);
		return $wpcloudy_disable_anims_value;
};

function get_bypass_disable_css3_anims($wpc_id) {
	if (get_admin_disable_css3_anims()) {
		return get_admin_disable_css3_anims();
	}
	else {
		return get_disable_css3_anims($wpc_id);
	}
}

//Fluid design
function get_admin_display_fluid() {
	$wpc_admin_display_fluid_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_admin_display_fluid_option ) ) {
		foreach ($wpc_admin_display_fluid_option as $key => $wpc_admin_display_fluid_value)
			$options[$key] = $wpc_admin_display_fluid_value;
		if (isset($wpc_admin_display_fluid_option['wpc_display_fluid'])) {
			return $wpc_admin_display_fluid_option['wpc_display_fluid'];
		}
	}
};
function get_display_fluid($wpc_id) {
		$id = (int)$_POST['wpc_param'];
		$wpcloudy_display_fluid_value = get_post_meta($id,'_wpcloudy_fluid',true);
		return $wpcloudy_display_fluid_value;
};
function get_bypass_display_fluid($wpc_id) {
	if (get_admin_display_fluid()) {
		return get_admin_display_fluid();
	}
	else {
		return get_display_fluid($wpc_id);
	}
}

//Fluid design, min width
function get_admin_display_fluid_width() {
	$wpc_admin_display_fluid_width_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_admin_display_fluid_width_option ) ) {
		foreach ($wpc_admin_display_fluid_width_option as $key => $wpc_admin_display_fluid_width_value)
			$options[$key] = $wpc_admin_display_fluid_width_value;
		if (isset($wpc_admin_display_fluid_width_option['wpc_display_fluid_width'])) {
			return $wpc_admin_display_fluid_width_option['wpc_display_fluid_width'];
		}
	}
};
function get_display_fluid_width($wpc_id) {
		$id = (int)$_POST['wpc_param'];
		$wpcloudy_display_fluid_width_value = get_post_meta($id,'_wpcloudy_fluid_width',true);
		return $wpcloudy_display_fluid_width_value;
};
function get_bypass_display_fluid_width($wpc_id) {
	if (get_admin_display_fluid_width()) {
		return get_admin_display_fluid_width();
	}
	else {
		return get_display_fluid_width($wpc_id);
	}
}

//Loads Map JS From...
function get_admin_map_js() {
	$wpc_admin_map_js_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_admin_map_js_option ) ) {
		foreach ($wpc_admin_map_js_option as $key => $wpc_admin_map_js_value)
			$options[$key] = $wpc_admin_map_js_value;
		if (isset($wpc_admin_map_js_option['wpc_map_js'])) {
			return $wpc_admin_map_js_option['wpc_map_js'];
		}
	}
};
//Bypass Map
function get_admin_bypass_map() {
	$wpc_admin_bypass_map_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_admin_bypass_map_option ) ) {
		foreach ($wpc_admin_bypass_map_option as $key => $wpc_admin_bypass_map_value)
			$options[$key] = $wpc_admin_bypass_map_value;
		if (isset($wpc_admin_bypass_map_option['wpc_map_display'])) {
			return $wpc_admin_bypass_map_option['wpc_map_display'];
		}
	}
};

function get_map($wpc_id) {
		$wpc_map_value = get_post_meta($wpc_id,'_wpcloudy_map',true);
		
		if ($wpc_map_value == 'yes') {
			return $wpc_map_value;
		}
};

function get_bypass_map($wpc_id) {
	if (get_admin_bypass_map()) {
		return get_admin_bypass_map(); 
	}
	else {
		return get_map($wpc_id);
	}
};

//Disables weather cache
function get_admin_disable_cache() {
	$wpc_admin_disable_cache_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_admin_disable_cache_option ) ) {
		foreach ($wpc_admin_disable_cache_option as $key => $wpc_admin_disable_cache_value)
			$options[$key] = $wpc_admin_disable_cache_value;
		if (isset($wpc_admin_disable_cache_option['wpc_advanced_disable_cache'])) {
			return $wpc_admin_disable_cache_option['wpc_advanced_disable_cache'];
		}
	}
};

//Time cache refresh
function get_admin_cache_time() {
	$wpc_admin_cache_time_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_admin_cache_time_option ) ) {
		foreach ($wpc_admin_cache_time_option as $key => $wpc_admin_cache_time_value)
			$options[$key] = $wpc_admin_cache_time_value;
		if (isset($wpc_admin_cache_time_option['wpc_advanced_cache_time'])) {
			return $wpc_admin_cache_time_option['wpc_advanced_cache_time'];
		}
	}
};

//API Key
function get_admin_api_key() {
	$wpc_admin_api_key_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_admin_api_key_option ) ) {
		foreach ($wpc_admin_api_key_option as $key => $wpc_admin_api_key_value)
			$options[$key] = $wpc_admin_api_key_value;
		if (isset($wpc_admin_api_key_option['wpc_advanced_api_key'])) {
			return $wpc_admin_api_key_option['wpc_advanced_api_key'];
		}
	}
};
			
function wpc_get_api_key() {
	if (get_admin_api_key() != '') {
		return get_admin_api_key();
	}
	else {
		return '46c433f6ba7dd4d29d5718dac3d7f035';
	}
}

//Bypass Background Color
function get_admin_color_background() {
	$wpc_admin_bg_color_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_bg_color_option ) ) {
		foreach ($wpc_admin_bg_color_option as $key => $wpc_admin_bg_color_value)
			$options[$key] = $wpc_admin_bg_color_value;
		if (isset($wpc_admin_bg_color_option['wpc_advanced_bg_color'])) {
			return $wpc_admin_bg_color_option['wpc_advanced_bg_color'];
		}
	}
};

function get_color_background($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_bg_color_value = get_post_meta($id,'_wpcloudy_meta_bg_color',true);
		return $wpc_bg_color_value;
};

function get_bypass_color_background($attr) {
	if (get_admin_color_background()) {
		return get_admin_color_background(); 
	}
	else {
		return get_color_background($attr);
	}
}

//Bypass Text Color
function get_admin_color_text() {
	$wpc_admin_text_color_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_text_color_option ) ) {
		foreach ($wpc_admin_text_color_option as $key => $wpc_admin_text_color_value)
			$options[$key] = $wpc_admin_text_color_value;
		if (isset($wpc_admin_text_color_option['wpc_advanced_text_color'])) {
			return $wpc_admin_text_color_option['wpc_advanced_text_color'];
		}
	}
};

function get_color_text($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_text_color_value = get_post_meta($id,'_wpcloudy_meta_txt_color',true);
		return $wpc_text_color_value;
};

function get_bypass_color_text($attr) {
	if (get_admin_color_text()) {
		return get_admin_color_text(); 
	}
	else {
		return get_color_text($attr);
	}
}

//Bypass Border Color
function get_admin_color_border() {
	$wpc_admin_color_border_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_color_border_option ) ) {
		foreach ($wpc_admin_color_border_option as $key => $wpc_admin_color_border_value)
			$options[$key] = $wpc_admin_color_border_value;
		if (isset($wpc_admin_color_border_option['wpc_advanced_border_color'])) {
			return $wpc_admin_color_border_option['wpc_advanced_border_color'];
		}
	}
};

function get_color_border($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_color_border_value = get_post_meta($id,'_wpcloudy_meta_border_color',true);
		return $wpc_color_border_value;
};

function get_bypass_color_border($attr) {
	if (get_admin_color_border()) {
		return get_admin_color_border(); 
	}
	else {
		return get_color_border($attr);
	}
}

//Bypass Current weather
function get_admin_display_current_weather() {
	$wpc_admin_display_current_weather_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_display_current_weather_option ) ) {
		foreach ($wpc_admin_display_current_weather_option as $key => $wpc_admin_display_current_weather_value)
			$options[$key] = $wpc_admin_display_current_weather_value;
		if (isset($wpc_admin_display_current_weather_option['wpc_display_current_weather'])) {
			return $wpc_admin_display_current_weather_option['wpc_display_current_weather'];
		}
	}
};

function get_display_current_weather($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_display_current_weather_value = get_post_meta($id,'_wpcloudy_current_weather',true);
		return $wpc_display_current_weather_value;
};

function get_bypass_display_current_weather($attr) {
	if (get_admin_display_current_weather()) {
		return get_admin_display_current_weather(); 
	}
	else {
		return get_display_current_weather($attr);
	}
}

//Bypass Short condition
function get_admin_display_weather() {
	$wpc_admin_display_weather_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_display_weather_option ) ) {
		foreach ($wpc_admin_display_weather_option as $key => $wpc_admin_display_weather_value)
			$options[$key] = $wpc_admin_display_weather_value;
		if (isset($wpc_admin_display_weather_option['wpc_display_weather'])) {
			return $wpc_admin_display_weather_option['wpc_display_weather'];
		}
	}
};

function get_display_weather($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_display_weather_value = get_post_meta($id,'_wpcloudy_weather',true);
		return $wpc_display_weather_value;
};

function get_bypass_display_weather($attr) {
	if (get_admin_display_weather()) {
		return get_admin_display_weather(); 
	}
	else {
		return get_display_weather($attr);
	}
}

//Bypass Sunrise - sunset
function get_admin_display_sunrise_sunset() {
	$wpc_admin_display_sunrise_sunset_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_display_sunrise_sunset_option ) ) {
		foreach ($wpc_admin_display_sunrise_sunset_option as $key => $wpc_admin_display_sunrise_sunset_value)
			$options[$key] = $wpc_admin_display_sunrise_sunset_value;
		if (isset($wpc_admin_display_sunrise_sunset_option['wpc_display_sunrise_sunset'])) {
			return $wpc_admin_display_sunrise_sunset_option['wpc_display_sunrise_sunset'];
		}
	}
};

function get_display_sunrise_sunset($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_display_sunrise_sunset_value = get_post_meta($id,'_wpcloudy_sunrise_sunset',true);
		return $wpc_display_sunrise_sunset_value;
};

function get_bypass_display_sunrise_sunset($attr) {
	if (get_admin_display_sunrise_sunset()) {
		return get_admin_display_sunrise_sunset(); 
	}
	else {
		return get_display_sunrise_sunset($attr);
	}
}

//Bypass display temperatures unit
function get_admin_display_temp_unit() {
	$wpc_admin_display_temp_unit_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_display_temp_unit_option ) ) {
		foreach ($wpc_admin_display_temp_unit_option as $key => $wpc_admin_display_temp_unit_value)
			$options[$key] = $wpc_admin_display_temp_unit_value;
		if (isset($wpc_admin_display_temp_unit_option['wpc_display_date_temp_unit'])) {
			return $wpc_admin_display_temp_unit_option['wpc_display_date_temp_unit'];
		}
	}
};

function get_display_temp_unit($attr) {
	$id = (int)$_POST['wpc_param'];
	$wpc_display_temp_unit_value = get_post_meta($id,'_wpcloudy_display_temp_unit',true);
	return $wpc_display_temp_unit_value;
};

function get_bypass_display_temp_unit($attr) {
	if (get_admin_display_temp_unit()) {
		return get_admin_display_temp_unit(); 
	}
	else {
		return get_display_temp_unit($attr);
	}
}

//Bypass Wind
function get_admin_display_wind() {
	$wpc_admin_display_wind_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_display_wind_option ) ) {
		foreach ($wpc_admin_display_wind_option as $key => $wpc_admin_display_wind_value)
			$options[$key] = $wpc_admin_display_wind_value;
		if (isset($wpc_admin_display_wind_option['wpc_display_wind'])) {
			return $wpc_admin_display_wind_option['wpc_display_wind'];
		}
	}
};

function get_display_wind($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_display_wind_value = get_post_meta($id,'_wpcloudy_wind',true);
		return $wpc_display_wind_value;
};

function get_bypass_display_wind($attr) {
	if (get_admin_display_wind()) {
		return get_admin_display_wind(); 
	}
	else {
		return get_display_wind($attr);
	}
}

//Bypass Humidity
function get_admin_display_humidity() {
	$wpc_admin_display_humidity_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_display_humidity_option ) ) {
		foreach ($wpc_admin_display_humidity_option as $key => $wpc_admin_display_humidity_value)
			$options[$key] = $wpc_admin_display_humidity_value;
		if (isset($wpc_admin_display_humidity_option['wpc_display_humidity'])) {
			return $wpc_admin_display_humidity_option['wpc_display_humidity'];
		}
	}
};

function get_display_humidity($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_display_humidity_value = get_post_meta($id,'_wpcloudy_humidity',true);
		return $wpc_display_humidity_value;
};

function get_bypass_display_humidity($attr) {
	if (get_admin_display_humidity()) {
		return get_admin_display_humidity(); 
	}
	else {
		return get_display_humidity($attr);
	}
}

//Bypass Pressure
function get_admin_display_pressure() {
	$wpc_admin_display_pressure_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_display_pressure_option ) ) {
		foreach ($wpc_admin_display_pressure_option as $key => $wpc_admin_display_pressure_value)
			$options[$key] = $wpc_admin_display_pressure_value;
		if (isset($wpc_admin_display_pressure_option['wpc_display_pressure'])) {
			return $wpc_admin_display_pressure_option['wpc_display_pressure'];
		}
	}
};

function get_display_pressure($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_display_pressure_value = get_post_meta($id,'_wpcloudy_pressure',true);
		return $wpc_display_pressure_value;
};

function get_bypass_display_pressure($attr) {
	if (get_admin_display_pressure()) {
		return get_admin_display_pressure(); 
	}
	else {
		return get_display_pressure($attr);
	}
}

//Bypass Cloudiness
function get_admin_display_cloudiness() {
	$wpc_admin_display_cloudiness_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_display_cloudiness_option ) ) {
		foreach ($wpc_admin_display_cloudiness_option as $key => $wpc_admin_display_cloudiness_value)
			$options[$key] = $wpc_admin_display_cloudiness_value;
		if (isset($wpc_admin_display_cloudiness_option['wpc_display_cloudiness'])) {
			return $wpc_admin_display_cloudiness_option['wpc_display_cloudiness'];
		}
	}
};

function get_display_cloudiness($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_display_cloudiness_value = get_post_meta($id,'_wpcloudy_cloudiness',true);
		return $wpc_display_cloudiness_value;
};

function get_bypass_display_cloudiness($attr) {
	if (get_admin_display_cloudiness()) {
		return get_admin_display_cloudiness(); 
	}
	else {
		return get_display_cloudiness($attr);
	}
}

//Bypass Precipitation
function get_admin_display_precipitation() {
	$wpc_admin_display_precipitation_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_display_precipitation_option ) ) {
		foreach ($wpc_admin_display_precipitation_option as $key => $wpc_admin_display_precipitation_value)
			$options[$key] = $wpc_admin_display_precipitation_value;
		if (isset($wpc_admin_display_precipitation_option['wpc_display_precipitation'])) {
			return $wpc_admin_display_precipitation_option['wpc_display_precipitation'];
		}
	}
};

function get_display_precipitation($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_display_precipitation_value = get_post_meta($id,'_wpcloudy_precipitation',true);
		return $wpc_display_precipitation_value;
};

function get_bypass_display_precipitation($attr) {
	if (get_admin_display_precipitation()) {
		return get_admin_display_precipitation(); 
	}
	else {
		return get_display_precipitation($attr);
	}
}

//Bypass Hour Forecast
function get_admin_display_hour_forecast() {
	$wpc_admin_display_hour_forecast_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_display_hour_forecast_option ) ) {
		foreach ($wpc_admin_display_hour_forecast_option as $key => $wpc_admin_display_hour_forecast_value)
			$options[$key] = $wpc_admin_display_hour_forecast_value;
		if (isset($wpc_admin_display_hour_forecast_option['wpc_display_hour_forecast'])) {
			return $wpc_admin_display_hour_forecast_option['wpc_display_hour_forecast'];
		}
	}
};

function get_display_hour_forecast($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_display_hour_forecast_value = get_post_meta($id,'_wpcloudy_hour_forecast',true);
		return $wpc_display_hour_forecast_value;
};

function get_bypass_display_hour_forecast($attr) {
	if (get_admin_display_hour_forecast()) {
		return get_admin_display_hour_forecast(); 
	}
	else {
		return get_display_hour_forecast($attr);
	}
}

//Bypass Range Hours Forecast
function get_admin_bypass_hour_forecast_nd() {
	$wpc_admin_bypass_hour_forecast_nd_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_admin_bypass_hour_forecast_nd_option ) ) {
		foreach ($wpc_admin_bypass_hour_forecast_nd_option as $key => $wpc_admin_bypass_hour_forecast_nd_value)
			$options[$key] = $wpc_admin_bypass_hour_forecast_nd_value;
		if (isset($wpc_admin_bypass_hour_forecast_nd_option['wpc_display_bypass_hour_forecast_nd'])) {
			return $wpc_admin_bypass_hour_forecast_nd_option['wpc_display_bypass_hour_forecast_nd'];
		}
	}
};
function get_admin_display_hour_forecast_nd() {
	$wpc_admin_display_hour_forecast_nd_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_display_hour_forecast_nd_option ) ) {
		foreach ($wpc_admin_display_hour_forecast_nd_option as $key => $wpc_admin_display_hour_forecast_nd_value)
			$options[$key] = $wpc_admin_display_hour_forecast_nd_value;
		if (isset($wpc_admin_display_hour_forecast_nd_option['wpc_display_hour_forecast_nd'])) {
			return $wpc_admin_display_hour_forecast_nd_option['wpc_display_hour_forecast_nd'];
		}
	}
};

function get_display_hour_forecast_nd($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_display_hour_forecast_nd_value = get_post_meta($id,'_wpcloudy_hour_forecast_nd',true);
		return $wpc_display_hour_forecast_nd_value;
};

function get_bypass_display_hour_forecast_nd($attr) {
	if (get_admin_display_hour_forecast_nd() && (get_admin_bypass_hour_forecast_nd())) {
		return get_admin_display_hour_forecast_nd(); 
	}
	else {
		return get_display_hour_forecast_nd($attr);
	}
}

//Bypass Today Date + Min-Max Temp
function get_admin_bypass_temp() {
	$wpc_display_temperature_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_display_temperature_option ) ) {
		foreach ($wpc_display_temperature_option as $key => $wpc_display_temperature_value)
			$options[$key] = $wpc_display_temperature_value;
		if (isset($wpc_display_temperature_option['wpc_display_bypass_temperature'])) {
			return $wpc_display_temperature_option['wpc_display_bypass_temperature'];
		}
	}
};

function get_admin_display_temp() {
	$wpc_admin_display_temperature_min_max_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_display_temperature_min_max_option ) ) {
		foreach ($wpc_admin_display_temperature_min_max_option as $key => $wpc_admin_display_temperature_min_max_value)
			$options[$key] = $wpc_admin_display_temperature_min_max_value;
		if (isset($wpc_admin_display_temperature_min_max_option['wpc_display_temperature_min_max'])) {
			return $wpc_admin_display_temperature_min_max_option['wpc_display_temperature_min_max'];
		}
	}
};

function get_display_temp($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_display_temperature_min_max_value = get_post_meta($id,'_wpcloudy_temperature_min_max',true);
		return $wpc_display_temperature_min_max_value;
};

function get_bypass_temp($attr) {
	if (get_admin_display_temp() && get_admin_bypass_temp()) {
		return get_admin_display_temp(); 
	}
	else {
		return get_display_temp($attr);
	}
};

//Bypass Length Days Names

function get_admin_bypass_length_days_names() {
	$wpc_display_bypass_short_days_names_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_display_bypass_short_days_names_option ) ) {
		foreach ($wpc_display_bypass_short_days_names_option as $key => $wpc_display_bypass_short_days_names_value)
			$options[$key] = $wpc_display_bypass_short_days_names_value;
		if (isset($wpc_display_bypass_short_days_names_option['wpc_display_bypass_short_days_names'])) {
			return $wpc_display_bypass_short_days_names_option['wpc_display_bypass_short_days_names'];
		}
	}
};

function get_admin_display_length_days_names() {
	$wpc_display_short_days_names_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_display_short_days_names_option ) ) {
		foreach ($wpc_display_short_days_names_option as $key => $wpc_display_short_days_names_value)
			$options[$key] = $wpc_display_short_days_names_value;
		if (isset($wpc_display_short_days_names_option['wpc_display_short_days_names'])) {
			return $wpc_display_short_days_names_option['wpc_display_short_days_names'];
		}
	}
};

function get_display_length_days_names($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpcloudy_short_days_names_value = get_post_meta($id,'_wpcloudy_short_days_names',true);
		return $wpcloudy_short_days_names_value;
};

function get_bypass_length_days_names($attr) {
	if (get_admin_bypass_length_days_names() && get_admin_display_length_days_names()) {
		return get_admin_display_length_days_names(); 
	}
	else {
		return get_display_length_days_names($attr);
	}
};

//Bypass Todays date format

function get_admin_bypass_date_temp() {
	$wpc_display_bypass_date_temp_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_display_bypass_date_temp_option ) ) {
		foreach ($wpc_display_bypass_date_temp_option as $key => $wpc_display_bypass_date_temp_value)
			$options[$key] = $wpc_display_bypass_date_temp_value;
		if (isset($wpc_display_bypass_date_temp_option['wpc_display_bypass_date_temp'])) {
			return $wpc_display_bypass_date_temp_option['wpc_display_bypass_date_temp'];
		}
	}
};

function get_admin_display_date_temp() {
	$wpc_display_date_temp_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_display_date_temp_option ) ) {
		foreach ($wpc_display_date_temp_option as $key => $wpc_display_date_temp_value)
			$options[$key] = $wpc_display_date_temp_value;
		if (isset($wpc_display_date_temp_option['wpc_display_date_temp'])) {
			return $wpc_display_date_temp_option['wpc_display_date_temp'];
		}
	}
};

function get_display_date_temp($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpcloudy_date_temp_value = get_post_meta($id,'_wpcloudy_date_temp',true);
		return $wpcloudy_date_temp_value;
};

function get_bypass_display_date_temp($attr) {
	if (get_admin_bypass_date_temp() && get_admin_display_date_temp()) {
		return get_admin_display_date_temp(); 
	}
	else {
		return get_display_date_temp($attr);
	}
};

//Bypass Forecast

function get_admin_display_forecast() {
	$wpc_admin_display_forecast_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_display_forecast_option ) ) {
		foreach ($wpc_admin_display_forecast_option as $key => $wpc_admin_display_forecast_value)
			$options[$key] = $wpc_admin_display_forecast_value;
			if (isset($wpc_admin_display_forecast_option['wpc_display_forecast'])) {
			return $wpc_admin_display_forecast_option['wpc_display_forecast'];
		}
	}
};

function get_display_forecast($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_display_forecast_value = get_post_meta($id,'_wpcloudy_forecast',true);
		return $wpc_display_forecast_value;
};

function get_bypass_display_forecast($attr) {
	if (get_admin_display_forecast()) {
		return get_admin_display_forecast(); 
	}
	else {
		return get_display_forecast($attr);
	}
};

//Bypass Weather Size

function get_admin_bypass_size() {
	$wpc_admin_bypass_size_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_admin_bypass_size_option ) ) {
		foreach ($wpc_admin_bypass_size_option as $key => $wpc_admin_bypass_size_value)
			$options[$key] = $wpc_admin_bypass_size_value;
		if (isset($wpc_admin_bypass_size_option['wpc_advanced_bypass_size'])) {
			return $wpc_admin_bypass_size_option['wpc_advanced_bypass_size'];
		}
	}
};

function get_admin_size() {
	$wpc_admin_size_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_size_option ) ) {
		foreach ($wpc_admin_size_option as $key => $wpc_admin_size_value)
			$options[$key] = $wpc_admin_size_value;
		if (isset($wpc_admin_size_option['wpc_advanced_size'])) {
			return $wpc_admin_size_option['wpc_advanced_size'];
		}
	}
};

function get_size($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_size_value = get_post_meta($id,'_wpcloudy_size',true);
		return $wpc_size_value;
};

function get_bypass_size($attr) {
	if (get_admin_unit() && (get_admin_bypass_size())) {
		return get_admin_size(); 
	}
	else {
		return get_size($attr);
	}
};



//Bypass Map Height
function get_admin_bypass_map_height() {
	$wpc_admin_bypass_map_height_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_admin_bypass_map_height_option ) ) {
		foreach ($wpc_admin_bypass_map_height_option as $key => $wpc_admin_bypass_map_height_value)
			$options[$key] = $wpc_admin_bypass_map_height_value;
		if (isset($wpc_admin_bypass_map_height_option['wpc_map_height'])) {
			return $wpc_admin_bypass_map_height_option['wpc_map_height'];
		}
	}
};

function get_map_height($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_map_height_value = get_post_meta($id,'_wpcloudy_map_height',true);
		return $wpc_map_height_value;
};

function get_bypass_map_height($attr) {
	if (get_admin_bypass_map_height()) {
		return get_admin_bypass_map_height(); 
	}
	else {
		return get_map_height($attr);
	}
};

//Bypass Layers opacity
function get_admin_bypass_map_opacity() {
	$wpc_admin_bypass_map_opacity_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_admin_bypass_map_opacity_option ) ) {
		foreach ($wpc_admin_bypass_map_opacity_option as $key => $wpc_admin_bypass_map_opacity_value)
			$options[$key] = $wpc_admin_bypass_map_opacity_value;
		if (isset($wpc_admin_bypass_map_opacity_option['wpc_map_bypass_opacity'])) {	
			return $wpc_admin_bypass_map_opacity_option['wpc_map_bypass_opacity'];
		}
	}
};

function get_admin_map_opacity() {
	$wpc_admin_map_opacity_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_map_opacity_option ) ) {
		foreach ($wpc_admin_map_opacity_option as $key => $wpc_admin_map_opacity_value)
			$options[$key] = $wpc_admin_map_opacity_value;
		if (isset($wpc_admin_map_opacity_option['wpc_map_opacity'])) {	
			return $wpc_admin_map_opacity_option['wpc_map_opacity'];
		}
	}
};

function get_map_opacity($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_map_opacity_value = get_post_meta($id,'_wpcloudy_map_opacity',true);
		return $wpc_map_opacity_value;
};

function get_bypass_map_opacity($attr) {
	if (get_admin_map_opacity() && (get_admin_bypass_map_opacity())) {
		return get_admin_map_opacity(); 
	}
	else {
		return get_map_opacity($attr);
	}
};

//Bypass Zoom Map
function get_admin_bypass_map_zoom() {
	$wpc_admin_bypass_map_zoom_option = get_option("wpc_option_name");
	if ( ! empty ( $wpc_admin_bypass_map_zoom_option ) ) {
		foreach ($wpc_admin_bypass_map_zoom_option as $key => $wpc_admin_bypass_map_zoom_value)
			$options[$key] = $wpc_admin_bypass_map_zoom_value;
		if (isset($wpc_admin_bypass_map_zoom_option['wpc_map_bypass_zoom'])) {
			return $wpc_admin_bypass_map_zoom_option['wpc_map_bypass_zoom'];
		}
	}
};

function get_admin_map_zoom() {
	$wpc_admin_map_zoom_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_map_zoom_option ) ) {
		foreach ($wpc_admin_map_zoom_option as $key => $wpc_admin_map_zoom_value)
			$options[$key] = $wpc_admin_map_zoom_value;
		if (isset($wpc_admin_map_zoom_option['wpc_map_zoom'])) {
			return $wpc_admin_map_zoom_option['wpc_map_zoom'];
		}	
	}
};

function get_map_zoom($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_map_zoom_value = get_post_meta($id,'_wpcloudy_map_zoom',true);
		return $wpc_map_zoom_value;
};

function get_bypass_map_zoom($attr) {
	if (get_admin_map_zoom() && (get_admin_bypass_map_zoom())) {
		return get_admin_map_zoom(); 
	}
	else {
		return get_map_zoom($attr);
	}
};

//Zoom wheel
function get_admin_map_zoom_wheel() {
	$wpc_admin_map_zoom_wheel_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_map_zoom_wheel_option ) ) {
		foreach ($wpc_admin_map_zoom_wheel_option as $key => $wpc_admin_map_zoom_wheel_value)
			$options[$key] = $wpc_admin_map_zoom_wheel_value;
		if (isset($wpc_admin_map_zoom_wheel_option['wpc_map_zoom_wheel'])) {
			return $wpc_admin_map_zoom_wheel_option['wpc_map_zoom_wheel'];
		}	
	}
};

function get_map_zoom_wheel($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_map_zoom_wheel_value = get_post_meta($id,'_wpcloudy_map_zoom_wheel',true);
		return $wpc_map_zoom_wheel_value;
};

function get_bypass_map_zoom_wheel($attr) {
	if (get_admin_map_zoom_wheel()) {
		return get_admin_map_zoom_wheel(); 
	}
	else {
		return get_map_zoom_wheel($attr);
	}
};


//Bypass Layers stations
function get_admin_map_layers_stations() {
	$wpc_admin_map_layers_stations_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_map_layers_stations_option ) ) {
		foreach ($wpc_admin_map_layers_stations_option as $key => $wpc_admin_map_layers_stations_value)
			$options[$key] = $wpc_admin_map_layers_stations_value;
		if (isset($wpc_admin_map_layers_stations_option['wpc_map_layers_stations'])) {
			return $wpc_admin_map_layers_stations_option['wpc_map_layers_stations'];
		}
	}
};

function get_map_layers_stations($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_map_layers_stations_value = get_post_meta($id,'_wpcloudy_map_stations',true);
		return $wpc_map_layers_stations_value;
};

function get_bypass_map_layers_stations($attr) {
	if (get_admin_map_layers_stations()) {
		return get_admin_map_layers_stations(); 
	}
	else {
		return get_map_layers_stations($attr);
	}
};

//Bypass Layers clouds
function get_admin_map_layers_clouds() {
	$wpc_admin_map_layers_clouds_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_map_layers_clouds_option ) ) {
		foreach ($wpc_admin_map_layers_clouds_option as $key => $wpc_admin_map_layers_clouds_value)
			$options[$key] = $wpc_admin_map_layers_clouds_value;
		if (isset($wpc_admin_map_layers_clouds_option['wpc_map_layers_clouds'])) {
			return $wpc_admin_map_layers_clouds_option['wpc_map_layers_clouds'];
		}
	}
};

function get_map_layers_clouds($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_map_layers_clouds_value = get_post_meta($id,'_wpcloudy_map_clouds',true);
		return $wpc_map_layers_clouds_value;
};

function get_bypass_map_layers_clouds($attr) {
	if (get_admin_map_layers_clouds()) {
		return get_admin_map_layers_clouds(); 
	}
	else {
		return get_map_layers_clouds($attr);
	}
};

//Bypass Layers precipitations
function get_admin_map_layers_precipitation() {
	$wpc_admin_map_layers_precipitation_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_map_layers_precipitation_option ) ) {
		foreach ($wpc_admin_map_layers_precipitation_option as $key => $wpc_admin_map_layers_precipitation_value)
			$options[$key] = $wpc_admin_map_layers_precipitation_value;
		if (isset($wpc_admin_map_layers_precipitation_option['wpc_map_layers_precipitation'])) {
			return $wpc_admin_map_layers_precipitation_option['wpc_map_layers_precipitation'];
		}
	}
};

function get_map_layers_precipitation($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_map_layers_precipitation_value = get_post_meta($id,'_wpcloudy_map_precipitation',true);
		return $wpc_map_layers_precipitation_value;
};

function get_bypass_map_layers_precipitation($attr) {
	if (get_admin_map_layers_precipitation()) {
		return get_admin_map_layers_precipitation(); 
	}
	else {
		return get_map_layers_precipitation($attr);
	}
};

//Bypass Layers snow
function get_admin_map_layers_snow() {
	$wpc_admin_map_layers_snow_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_map_layers_snow_option ) ) {
		foreach ($wpc_admin_map_layers_snow_option as $key => $wpc_admin_map_layers_snow_value)
			$options[$key] = $wpc_admin_map_layers_snow_value;
		if (isset($wpc_admin_map_layers_snow_option['wpc_map_layers_snow'])) {
			return $wpc_admin_map_layers_snow_option['wpc_map_layers_snow'];
		}
	}
};

function get_map_layers_snow($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_map_layers_snow_value = get_post_meta($id,'_wpcloudy_map_snow',true);
		return $wpc_map_layers_snow_value;
};

function get_bypass_map_layers_snow($attr) {
	if (get_admin_map_layers_snow()) {
		return get_admin_map_layers_snow(); 
	}
	else {
		return get_map_layers_snow($attr);
	}
};

//Bypass Layers wind
function get_admin_map_layers_wind() {
	$wpc_admin_map_layers_wind_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_map_layers_wind_option ) ) {
		foreach ($wpc_admin_map_layers_wind_option as $key => $wpc_admin_map_layers_wind_value)
			$options[$key] = $wpc_admin_map_layers_wind_value;
		if (isset($wpc_admin_map_layers_wind_option['wpc_map_layers_wind'])) {
			return $wpc_admin_map_layers_wind_option['wpc_map_layers_wind'];
		}
	}
};

function get_map_layers_wind($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_map_layers_wind_value = get_post_meta($id,'_wpcloudy_map_wind',true);
		return $wpc_map_layers_wind_value;
};

function get_bypass_map_layers_wind($attr) {
	if (get_admin_map_layers_wind()) {
		return get_admin_map_layers_wind(); 
	}
	else {
		return get_map_layers_wind($attr);
	}
};

//Bypass Layers temperature
function get_admin_map_layers_temperature() {
	$wpc_admin_map_layers_temperature_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_map_layers_temperature_option ) ) {
		foreach ($wpc_admin_map_layers_temperature_option as $key => $wpc_admin_map_layers_temperature_value)
			$options[$key] = $wpc_admin_map_layers_temperature_value;
		if (isset($wpc_admin_map_layers_temperature_option['wpc_map_layers_temperature'])) {
			return $wpc_admin_map_layers_temperature_option['wpc_map_layers_temperature'];
		}
	}
};

function get_map_layers_temperature($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_map_layers_temperature_value = get_post_meta($id,'_wpcloudy_map_temperature',true);
		return $wpc_map_layers_temperature_value;
};

function get_bypass_map_layers_temperature($attr) {
	if (get_admin_map_layers_temperature()) {
		return get_admin_map_layers_temperature(); 
	}
	else {
		return get_map_layers_temperature($attr);
	}
};

//Bypass Layers pressure
function get_admin_map_layers_pressure() {
	$wpc_admin_map_layers_pressure_option = get_option("wpc_option_name");

	if ( ! empty ( $wpc_admin_map_layers_pressure_option ) ) {
		foreach ($wpc_admin_map_layers_pressure_option as $key => $wpc_admin_map_layers_pressure_value)
			$options[$key] = $wpc_admin_map_layers_pressure_value;
		if (isset($wpc_admin_map_layers_pressure_option['wpc_map_layers_pressure'])) {
			return $wpc_admin_map_layers_pressure_option['wpc_map_layers_pressure'];
		}
	}
};

function get_map_layers_pressure($attr) {
		$id = (int)$_POST['wpc_param'];
		$wpc_map_layers_pressure_value = get_post_meta($id,'_wpcloudy_map_pressure',true);
		return $wpc_map_layers_pressure_value;
};

function get_bypass_map_layers_pressure($attr) {
	if (get_admin_map_layers_pressure()) {
		return get_admin_map_layers_pressure(); 
	}
	else {
		return get_map_layers_pressure($attr);
	}
};
