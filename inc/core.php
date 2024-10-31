<?php
session_start();

if(!is_admin())
	add_action ('init','my_geo_free_init_front');

function my_geo_free_init_front()
{
	my_geo_get_geo_data();
	
}	
	
function my_geo_is_valid_visitor(){
	return true;
	//check if visitor is not bot, like googlebot
	if (strpos($_SERVER['HTTP_USER_AGENT'],'bot') == false)
		return true;
	return false;
}


function my_geo_get_geo_data()
{
	//die(ucwords(strtolower('CHIRAG')));
	global $mygeo_data;
	$temp = mgpf_get_geo_location();
	$mygeo_data = Array(
			"city"=>$temp->cityName,
			"country_code"=>$temp->countryCode,
			"country_name"=>$temp->countryName,
			"region"=>$temp->regionName,
			"postal_code"=>$temp->zipCode,
			"latitude"=>$temp->latitude,
			"longitude"=>$temp->longitude,
		);
	
}
?>