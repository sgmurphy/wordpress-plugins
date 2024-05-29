<?php
/*
 * Protect WP-Admin (C)
 * @register_install_hook()
 * @register_uninstall_hook()
 * */
?>
<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $getPwaOptions;
/** Get all options value */
if(!function_exists('get_pwa_setting_options')):
function get_pwa_setting_options() {
		global $wpdb;
		$pwaOptions = $wpdb->get_results("SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE 'pwa_%'");
								
		foreach ($pwaOptions as $option) {
			$pwaOptions[$option->option_name] =  $option->option_value;
		}
		return $pwaOptions;	
	}
endif;	

GLOBAL  $getPwaOptions;
$getPwaOptions = get_pwa_setting_options();
if(isset($getPwaOptions['pwa_active']) && '1'==$getPwaOptions['pwa_active'])
{
add_action('login_enqueue_scripts','pwa_load_jquery');
add_action('init', 'init_pwa_admin_rewrite_rules' );
add_action('init', 'pwa_admin_url_redirect_conditions' );
add_action('login_enqueue_scripts','check_login_status',20);

	if(isset($getPwaOptions['pwa_logout']))
	{
	add_action('admin_init', 'pwa_logout_user_after_settings_save');
	add_action('admin_init', 'pwa_logout_user_after_settings_save');
	}
}
if(!function_exists('check_login_status')):
	function check_login_status()
	{
		$getPwaOptions = get_pwa_setting_options();
		$current_uri = pwa_get_current_page_url($_SERVER);
		$newadminurl = site_url($getPwaOptions['pwa_rewrite_text']);
		 if ( is_user_logged_in() && $current_uri==$newadminurl) 
		 {
				wp_redirect(admin_url()); die();
			} else {
				//echo 'slient';
			}
		
		
		}
endif;

if(!function_exists('pwa_logout_user_after_settings_save')):
function pwa_logout_user_after_settings_save()
{
	$getPwaOptions=get_pwa_setting_options();
    if(isset($_GET['settings-updated']) && $_GET['settings-updated'] && isset($_GET['page']) && $_GET['page']=='pwa-settings')
    {
    flush_rewrite_rules();
	}
	
  if(isset($_GET['settings-updated']) && $_GET['settings-updated'] && isset($_GET['page']) && $_GET['page']=='pwa-settings' && isset($getPwaOptions['pwa_logout']) && $getPwaOptions['pwa_logout']==1)
   {
     $URL=str_replace('&amp;','&',wp_logout_url());
      if(isset($getPwaOptions['pwa_rewrite_text']) && isset($getPwaOptions['pwa_logout']) && $getPwaOptions['pwa_logout']==1 && $getPwaOptions['pwa_rewrite_text']!=''){
      wp_redirect(site_url('/'.$getPwaOptions['pwa_rewrite_text']));
     }else
     {
		 //silent
		 }
     //wp_redirect($URL);
   }
}
endif;
/** Create a new rewrite rule for change to wp-admin url */
if(!function_exists('init_pwa_admin_rewrite_rules')):
function init_pwa_admin_rewrite_rules() {
	$getPwaOptions=get_pwa_setting_options();
    if(isset($getPwaOptions['pwa_active']) && (isset($getPwaOptions['pwa_rewrite_text']) && $getPwaOptions['pwa_rewrite_text']!='')){
	$newurl=strip_tags($getPwaOptions['pwa_rewrite_text']);
    add_rewrite_rule( $newurl.'/?$', 'wp-login.php', 'top' );
    add_rewrite_rule( $newurl.'/register/?$', 'wp-login.php?action=register', 'top' );
    add_rewrite_rule( $newurl.'/lostpassword/?$', 'wp-login.php?action=lostpassword', 'top' );
    
    }
}
endif;
/** 
 * Update Login, Register & Forgot password link as per new admin url
 * */
if(!function_exists('pwa_load_jquery')):
function pwa_load_jquery()
{
wp_enqueue_script("jquery"); 
}
endif;

if( !function_exists( 'pwa_admin_url_redirect_conditions') ):
    
function pwa_admin_url_redirect_conditions() {
    
	$getPwaOptions=get_pwa_setting_options();
	
	$pwaActualURLAry =array
	                       (
                           site_url('/wp-login.php'),
                           site_url('/wp-login.php/'),
                           site_url('/wp-login'),
                           site_url('/wp-login/'),
                           site_url('/wp-admin'),
                           site_url('/wp-admin/'),
                           );
    $request_url = pwa_get_current_page_url($_SERVER);
    $newUrl = explode('?',$request_url);
//	print_r($pwaActualURLAry); echo $newUrl[0];exit;
	
 if(! is_user_logged_in() && in_array($newUrl[0],$pwaActualURLAry) ) {
     
     if(wp_doing_ajax() && $newUrl[0]==site_url('/wp-admin/admin-ajax.php')) {
     return true;
     }
     
/** is forgot password link */
if( isset($_GET['login']) && isset($_GET['action']) && $_GET['action']=='rp' && $_GET['login']!='')
{
$username = sanitize_text_field($_GET['login']);
if(username_exists($username))
{
//silent
}else{ wp_redirect(home_url('/'),301); //exit;
}
}elseif(isset($_GET['action']) && $_GET['action']=='rp')
{
	//silent
	}
elseif(isset($_GET['action']) && isset($_GET['error']) && $_GET['action']=='lostpassword' && $_GET['error']=='invalidkey')
{
	wp_redirect( home_url( '/' ),301 );//exit;
	}
elseif(isset($_GET['action']) && $_GET['action']=='resetpass')
{
// silent 
	}
	else{

	wp_redirect(home_url('/'),301);//exit;
	   }


		//exit;
		}
		else if(isset($getPwaOptions['pwa_restrict']) && $getPwaOptions['pwa_restrict']==1 && is_user_logged_in())
		{
			global $current_user;
	        $user_roles = $current_user->roles;
	        $user_ID = $current_user->ID;
	        $user_role = array_shift($user_roles);
	        
	        if(isset($getPwaOptions['pwa_allow_custom_users']) && $getPwaOptions['pwa_allow_custom_users']!='')
	        {
				$userids=explode(',' ,$getPwaOptions['pwa_allow_custom_users']);
				
				if(is_array($userids))
				{
					$userids=explode(',' ,$getPwaOptions['pwa_allow_custom_users']);
					}else
					{
						$userids[]=$getPwaOptions['pwa_allow_custom_users'];
						}
				}else
				{
					$userids=array();
					}
	        
			if($user_role=='administrator' || in_array($user_ID,$userids))
			{
				//silent is gold
				}else
				{
					
					show_admin_bar(false); // disble admin_bar for guest user
					 
					wp_redirect(home_url('/'));//exit;
					}
			}else
			{
				//silent is gold
				}
	
}
endif;
/** Get the current url*/
if(!function_exists('pwa_current_path_protocol')):
function pwa_current_path_protocol($s, $use_forwarded_host=false)
{
    $pwahttp = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
    $pwasprotocal = strtolower($s['SERVER_PROTOCOL']);
    $pwa_protocol = substr($pwasprotocal, 0, strpos($pwasprotocal, '/')) . (($pwahttp) ? 's' : '');
    $port = $s['SERVER_PORT'];
    $port = ((!$pwahttp && $port=='80') || ($pwahttp && $port=='443')) ? '' : ':'.$port;
    $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
    $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
    return $pwa_protocol . '://' . $host;
}
endif;

if( !function_exists( 'pwa_get_current_page_url' ) ):
 function pwa_get_current_page_url( $s, $use_forwarded_host=false ) {
     
    $requesturl = preg_replace('/(\/+)/','/',$s['REQUEST_URI']); // remove more then 1 slash from url
     
    $url = pwa_current_path_protocol($s, $use_forwarded_host) . $requesturl;
    
    return $url;
 }
endif;

add_action( 'login_enqueue_scripts', 'pwa_update_login_page_logo' );
/* Change Wordpress Default Logo */
if(!function_exists('pwa_update_login_page_logo')):
	function pwa_update_login_page_logo() 
	{
		wp_enqueue_script( 'pwa-login',  plugin_dir_url( __FILE__ ) . 'js/pwa-login.js?v=1' );
		$newadmin = 'nwp'.get_option("pwa_rewrite_text");
		$bg = get_option("pwa_login_page_bg_color");
		$color = get_option("pwa_login_page_color");
		$logo = get_option("pwa_logo_path");
		$su = site_url();
		wp_localize_script( 'pwa-login', 'pwaawp_object',
				array( 
					'u' => $newadmin,
					's' => $su,
					'l' => $logo,
					'b' => $bg,
					'c' => $color,
				)
			);

	}
endif;

function pwa_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'pwa_login_logo_url' );

/*************************************************************
  Hooks to overide option value before save it into database 
* ************************************************************/
function pwa_update_field_rewrite_text( $new_value, $old_value ) {
$new_value =  str_replace('/','-',trim(stripslashes(strip_tags($new_value))));
return $new_value;
}
add_filter( 'pre_update_option_pwa_rewrite_text', 'pwa_update_field_rewrite_text', 10, 2 );


/**
 * Filter password reset request email's body.
 *
 * @param string $message
 * @param string $key
 * @param string $user_login
 * @return string
 */
function pwa_reset_password_message( $message, $key, $user_login ) {
	$site_name  = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	
	$getPwaOptions=get_pwa_setting_options();
    if(isset($getPwaOptions['pwa_active']) && (isset($getPwaOptions['pwa_rewrite_text']) && $getPwaOptions['pwa_rewrite_text']!='')){
        
        $adminurl = $getPwaOptions["pwa_rewrite_text"]."/?action=rp&key=$key&login=" . rawurlencode( $user_login );
        
   
    
	$reset_link = network_site_url( $adminurl, 'login' );

	// Create new message
	
$message = __( 'Hi ' . $user_login, 'wpexpertsin' ) . "\n";

$message .= __( '
Someone has requested a password reset for the following account  ' . $user_login.sprintf( __( ' on  %s' ), network_home_url( '/' ) ), 'wpexpertsin' ) . "\n";


$message .= sprintf( __( '
Username: %s', 'wpexpertsin' ), $user_login ) ."\n";

$message .= __( "
If you didn't make this request, just ignore this email. If you'd like to proceed:", 'wpexpertsin' ) . "\n";

$message .= __( '
To reset your password, visit the following address:', 'wpexpertsin' ) . "\n";

$message .= $reset_link . "\n";

return $message;
 }else {
        
       return $message;
    }
    
}

add_filter( 'retrieve_password_message', 'pwa_reset_password_message', 20, 3 );
