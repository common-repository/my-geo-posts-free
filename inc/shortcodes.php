<?php
add_shortcode('mygeo_city','mygeo_city');
add_shortcode('mygeo_country_code','mygeo_country_code');
add_shortcode('mygeo_country_name','mygeo_country_name');
add_shortcode('mygeo_region','mygeo_region');
add_shortcode('mygeo_latitude','mygeo_latitude');
add_shortcode('mygeo_longitude','mygeo_longitude');
add_shortcode('mygeo_postal_code','mygeo_postal_code');




function mygeo_city($attr)
{
	global $mygeo_data;
	$data = shortcode_atts( array(
        'default' => ''
    ), $attr );
	if(trim($mygeo_data['city'])!='')
		return $mygeo_data['city'];
	else
		return $data['default'];
	
}

function mygeo_country_code($attr)
{
	global $mygeo_data;
	$data = shortcode_atts( array(
        'default' => ''
    ), $attr );
	if(trim($mygeo_data['country_code'])!='')
		return $mygeo_data['country_code'];
	else
		return $data['default'];
}

function mygeo_country_name($attr)
{
	global $mygeo_data;
	$data = shortcode_atts( array(
        'default' => ''
    ), $attr );
	if(trim($mygeo_data['country_name'])!='')
		return $mygeo_data['country_name'];
	else
		return $data['default'];
	
}

function mygeo_region($attr)
{
	global $mygeo_data;
	$data = shortcode_atts( array(
        'default' => ''
    ), $attr );
	if(trim($mygeo_data['region'])!='')
		return $mygeo_data['region'];
	else
		return $data['default'];
	
}


function mygeo_latitude($attr)
{
	global $mygeo_data;
	$data = shortcode_atts( array(
        'default' => ''
    ), $attr );
	if(trim($mygeo_data['latitude'])!='')
		return $mygeo_data['latitude'];
	else
		return $data['default'];
	
}

function mygeo_longitude($attr)
{
	global $mygeo_data;
	$data = shortcode_atts( array(
        'default' => ''
    ), $attr );
	if(trim($mygeo_data['longitude'])!='')
		return $mygeo_data['longitude'];
	else
		return $data['default'];
	
}

function mygeo_postal_code($attr)
{
	global $mygeo_data;
	$data = shortcode_atts( array(
        'default' => ''
    ), $attr );
	if(trim($mygeo_data['postal_code'])!='')
		return $mygeo_data['postal_code'];
	else
		return $data['default'];
	
}


?>
