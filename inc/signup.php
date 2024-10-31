<?php
add_action('wp_ajax_mgpf_signup', 'mgpf_signup_callback');

function mgpf_signup_callback() {
	
	$url = "http://mindstien.com/plugin_frame.php";
	$response = wp_remote_post( $url, array(
	'method' => 'POST',
	'timeout' => 45,
	'redirection' => 5,
	'httpversion' => '1.0',
	'blocking' => true,
	'headers' => array(),
	'body' => array(
		'action'=>'plugin_signup_form',
		'plugin_name'=>$sunrise->name,
		'name' => $_POST['name'], 
		'email' => $_POST['email'],
		'admin_email'=>get_bloginfo('admin_email'),
		'blog'=>get_bloginfo('url')
		),
	'cookies' => array()
    )
	);
	//print_r($response);
	if( is_wp_error( $response ) ) {
	   $error_message = $response->get_error_message();
	   echo "Something went wrong: $error_message";
	} else {
		update_option('mgpf_signup','atrue');
		echo "done";
	}
	die(); // this is required to return a proper result
}

function mgpf_signup()
{
	
	if(get_option('mgpf_signup')!="atrue") :?>
	<script>
	jQuery(document).ready(function(){

		jQuery('#mgpf_form').submit(function(){
			var data = {
				action: 'mgpf_signup',
				name:jQuery('#mgpf_YMP1').val(),
				email:jQuery('#mgpf_YMP0').val()
			};
			
			jQuery('#mgpf_form_title').html("Please wait....");
			
			// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
			jQuery.post(ajaxurl, data, function(response) {
				console.log(response);
				if(response=='done')
				{
					
					jQuery('#mgpf_form_title').html("Please check your inbox for Confirmation Link.....");
					setTimeout(function(){
					  jQuery('#mgpf_signup_form').hide(1000);
					}, 3000);
				}
				else
				{
					jQuery('#mgpf_form_title').html("Unknown error occured, please try again...");
				}
			});
			return false;
		});
	
	});
	</script>
	<div id='mgpf_signup_form' style="border:1px solid darkpink" class='error'>
		<h2 id='mgpf_form_title' style='color:darkred;text-shadow:2px -1px pink;'><img src="<?php echo plugins_url('/images/newsletter.png', __FILE__); ?>" style='float:left;margin:5px'> Newsletter Signup...</h2>
		<strong>to get latest product launch and upgrade informations in inbox</strong>
		<form id='mgpf_form'>
			<p>
			<strong>Name : </strong>
			<input type="text" id="mgpf_YMP1" size="20" /> 
			<strong>Email :</strong>
			<input type="text" id="mgpf_YMP0" size="20" /> 
			<input style="margin-bottom:-20px;" type="image" src="<?php echo plugins_url('/images/new_sub_button.png', __FILE__); ?>" value="Submit"  />
			</p>
		</form>
	</div>
	
	<?php endif; ?>
	
	<IFRAME SRC="http://www.mindstien.com/plugin_frame.php?id=geo_post_free" width="100%" height="2000px" style="overflow: hidden;" id="mgpf_frame" marginheight="0" frameborder="0" ></iframe>
	<?php
}

?>