<?php
/*
Plugin Name: My Geo Posts Free
Plugin URI: http://www.mindstien.com/
Version: 1.2
Author: Mindstien Technologies
Author URI: http://www.mindstien.com/
Description: Display Geo Posts data of visitor like city, state, country almost anywhere on your wordpress site using shortcodes and php codes to personalize your wordpress site/content. Using ipinfodb.com (you need to signup for api key) or geoplugin.com, both are free service.
License: GNU General Public License v2
 */

// Include plugin actions
global $mygeo_data;
add_filter('widget_text', 'do_shortcode');
add_filter('widget_title', 'do_shortcode');
add_filter('gettext', 'do_shortcode');
add_filter('wp_title', 'do_shortcode');
add_filter('single_post_title', 'do_shortcode');
add_filter('sanitize_title', 'do_shortcode');
add_filter('the_title', 'do_shortcode');


require_once 'inc/core.php';
require_once 'inc/shortcodes.php';
require_once 'inc/signup.php';


add_action('admin_menu', 'mgpf_create_menu');

function mgpf_create_menu() {

	//create new top-level menu
	add_menu_page('Mindstien Geo Posts Settings', 'Geo Posts', 'administrator', __FILE__, 'mgpf_settings_page',plugins_url('/inc/images/geo_small.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'mgpf_save_settings' );
}


function mgpf_save_settings() {
	if (isset( $_POST['mgpf_noncename'] ) AND wp_verify_nonce( $_POST['mgpf_noncename'], plugin_basename( __FILE__ )))
	{
		//global $mgpf_geo_data;
		$mgpf_geo_data = array();
		$mgpf_geo_data['service'] = $_POST['mgpf_geo_service'];
		$mgpf_geo_data['api'] = trim($_POST['mgpf_api']);
		
		update_option('mgpf_geo_data',$mgpf_geo_data);
		
		echo "<div class='updated'><p style='font-weight:bold;'>Settings Updated</p></div>";
	
	}
}

function mgpf_settings_page() {
?>
<div class="wrap">
	<div class="icon32" id="aicon-options-general"><img src='<?php echo plugins_url('/inc/images/geo_large.png', __FILE__); ?>'></div>
	<?php mgpf_get_options(); 
	global $mgpf_geo_data;
	?>
<h2>Mindstien Geo Posts Settings</h2>

<form method="post" >
    <?php wp_nonce_field( plugin_basename( __FILE__ ), 'mgpf_noncename' ); ?>
	<table class="form-table">
        <tr valign="top">
        <th scope="row">Select Geo Posts Service</th>
        <td>
			<input <?php checked('api',$mgpf_geo_data['service']); ?> type="radio" name="mgpf_geo_service" value="api" /> <a target="_blank" href="http://ipinfodb.com/register.php">IPInfoDB</a>
			<div class='description'>You need to register for an API key and enter it in the field below. This has more accurate data than GeoPlugin.com and it will continue to get better.</div>
			<input <?php checked('none',$mgpf_geo_data['service']); ?> type="radio" name="mgpf_geo_service" value="none" /> GeoPlugin.com
			<div class='description'>Dont need any api, just select and forget. Less accurate than IpInfoDB.com and sometime dont work due to heavy load on geoplugin.com server</div>
		</td>
        </tr>
         
        <tr valign="top" id='api_row' style='display:none;'>
        <th scope="row">IPInfoDB API Key:</th>
        <td><input type="text" name="mgpf_api" value="<?php echo $mgpf_geo_data['api']; ?>" /></td>
        </tr>
        
        
    </table>
    
    <?php submit_button(); ?>

</form>

<script>
	jQuery('document').ready (function(){
		
		if(jQuery('[name="mgpf_geo_service"]:checked').val()=='api')
			jQuery('#api_row').show(300);
		
		jQuery('[name="mgpf_geo_service"]').change(function(){
			if(jQuery('[name="mgpf_geo_service"]:checked').val()=='api')
				jQuery('#api_row').show(300);
			else
				jQuery('#api_row').hide(300);
		});
		
	});
</script>
	<?php mgpf_signup(); ?>
</div>
<?php }

function mgpf_get_options()
{
	global $mgpf_geo_data;
	$mgpf_geo_data = get_option('mgpf_geo_data');
	if(!is_array($mgpf_geo_data))
	{
		$mgpf_geo_data = array();
		$mgpf_geo_data['service'] = 'none';
		$mgpf_geo_data['api'] = '';
	}
}

function mgpf_get_geo_location(){
	    mgpf_get_options();
		global $mgpf_geo_data;
		$ip = getenv('REMOTE_ADDR');
		
      // Check if "cache" cookie is set   
      if(isset($_COOKIE['mgpf_geo_coockie'])) {
	      $mdata = unserialize(stripslashes(base64_decode($_COOKIE['mgpf_geo_coockie'])));
         if($mdata->ipAddress == $ip && $mdata->service == $mgpf_geo_data['service'])
	         return $mdata;     
	   }
		
      if($mgpf_geo_data['service'] == 'api')
	       return mgpf_ipinfodb_get_geo_location($ip);
	    else 
	       return mgpf_geoplugin_get_geo_location($ip);
	}
	
	function mgpf_ipinfodb_get_geo_location($ip) {
			global $mgpf_geo_data;
			//echo $mgpf_geo_data['api'];
			if(empty($mgpf_geo_data['api']))
			{
				return false;
			}
		    $mindstien = wp_remote_get("http://api.ipinfodb.com/v3/ip-city/?key=".$mgpf_geo_data['api']."&ip=$ip&format=json");
		    //print_r($mindstien);die('one');
		    if(is_wp_error($mindstien) || 200 != $mindstien['response']['code'])
		    {
		    	//wp_die('Could not get Country information.','Covert Geo Targeter Error');
		    	// MIGHT WANT TO SET DEFAULTS.
		    	return false;
		    }

			$mindstien = json_decode($mindstien['body']);
			$mdata = new stdClass();	
			$mdata->service = "api";
			$mdata->ipAddress = $mindstien->ipAddress;
			$mdata->countryCode = $mindstien->countryCode;
			$mdata->countryName = ucwords(strtolower($mindstien->countryName));
			$mdata->zipCode = $mindstien->zipCode;
			$mdata->latitude = $mindstien->latitude;
			$mdata->longitude = $mindstien->longitude;
			$mdata->regionName = $mindstien->regionName == '-' ? '' : ucwords(strtolower($mindstien->regionName));
			$mdata->cityName = $mindstien->cityName == '-' ? '' : ucwords(strtolower($mindstien->cityName));
			
			setcookie('mgpf_geo_coockie',base64_encode(serialize($mdata)),time()+60*60*24*30,COOKIEPATH);
			
		   return $mdata;
	}
	
   function mgpf_geoplugin_get_geo_location($ip){
            
   	    $mindstien = wp_remote_get("http://www.geoplugin.net/php.gp?ip=$ip");
   	    //print_r($mindstien);die('two');
   	    if(is_wp_error($mindstien) || 200 != $mindstien['response']['code'])
   	    {
   	    	//wp_die('Could not get Country information.','Covert Geo Targeter Error');
   	    	// MIGHT WANT TO SET DEFAULTS.
   	    	return false;
   	    }

   		$mindstien = unserialize($mindstien['body']);
		$mdata = new stdClass();	
         $mdata->service = "none";
         $mdata->ipAddress = $mindstien['geoplugin_request'];
         $mdata->countryCode = $mindstien['geoplugin_countryCode'];
         $mdata->countryName = $mindstien['geoplugin_countryName'];
         $mdata->regionName = $mindstien['geoplugin_regionName'];
         $mdata->cityName = $mindstien['geoplugin_city'];
		 $mdata->zipCode = $mindstien['geoplugin_areaCode'];
		$mdata->latitude = $mindstien['geoplugin_latitude'];
		$mdata->longitude = $mindstien['geoplugin_longitude'];
		
   		
   		setcookie('mgpf_geo_coockie',base64_encode(serialize($mdata)),time()+60*60*24*30,COOKIEPATH);
   	    return $mdata;
   }
   

//add_action('init','mgpf_init');

function mgpf_init()
{
	if(!is_admin())
	{
		mgpf_get_geo_location();
		//print_r(mgpf_get_geo_location());
		//die();
	}
}


?>