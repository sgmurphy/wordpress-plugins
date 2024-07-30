<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Secure_Copy_Content_Protection
 * @subpackage Secure_Copy_Content_Protection/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Secure_Copy_Content_Protection
 * @subpackage Secure_Copy_Content_Protection/admin
 * @author     Security Team <info@ays-pro.com>
 */
class Secure_Copy_Content_Protection_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;
	private $results_obj;
	private $settings_obj;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		
		add_filter('set-screen-option', array(__CLASS__, 'set_screen'), 10, 3);

        $per_page_array = array(
            'sccp_results_per_page'
        );
        foreach($per_page_array as $option_name){
            add_filter('set_screen_option_'.$option_name, array(__CLASS__, 'set_screen'), 10, 3);
        }

	}

	/**
	 * Register the styles for the admin menu area.
	 *
	 * @since    1.5.0
	 */
	public function admin_menu_styles() {
		echo "
        <style>
        	.ays_menu_badge_new{
                padding: 2px 2px !important;
            }

        	.ays_menu_badge{
                color: #fff;
                display: inline-block;
                font-size: 10px;
                line-height: 14px;
                text-align: center;
                background: #ca4a1f;
                margin-left: 5px;
                border-radius: 20px;
                padding: 2px 5px;
            }            

            #adminmenu a.toplevel_page_secure-copy-content-protection div.wp-menu-image img {
                padding: 0;
                opacity: .6;
                width: 32px;
                transition: all .3s ease-in;
            }

            #adminmenu a.toplevel_page_secure-copy-content-protection + ul.wp-submenu.wp-submenu-wrap li:last-child a {
                color: #68A615;
            }
        </style>
        ";
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook_suffix ) {

		wp_enqueue_style($this->plugin_name . '-admin', plugin_dir_url(__FILE__) . 'css/admin.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name . '-sweetalert2', plugin_dir_url(__FILE__) . 'css/sweetalert2.min.css', array(), $this->version, 'all');		

		wp_enqueue_style($this->plugin_name . "-banner", plugin_dir_url(__FILE__) . 'css/secure-copy-content-protection-banner.css', array(), $this->version, 'all');

		if (false === strpos($hook_suffix, $this->plugin_name)) {
			return;
		}
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Secure_Copy_Content_Protection_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Secure_Copy_Content_Protection_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// You need styling for the datepicker. For simplicity I've linked to the jQuery UI CSS on a CDN.
        wp_register_style( 'jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css' );
        wp_enqueue_style( 'jquery-ui' );

		wp_enqueue_style('wp-color-picker');		
		wp_enqueue_style($this->plugin_name.'-select2', plugin_dir_url(__FILE__) . 'css/select2.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name . "-codemirror", plugin_dir_url( __FILE__ ) . 'css/codemirror.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name.'-bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name . '-sweetalert2', plugin_dir_url(__FILE__) . 'css/sweetalert2.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name.'-jquery-datetimepicker', plugin_dir_url(__FILE__) . 'css/jquery-ui-timepicker-addon.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name.'-dataTables-bootstrap4', plugin_dir_url(__FILE__) . 'css/dataTables.bootstrap4.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/secure-copy-content-protection-admin.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name . "-font-awesome", plugin_dir_url( __FILE__ ) . 'css/fontawesome.min.css', array(), $this->version, 'all');	
		wp_enqueue_style('animate.css', plugin_dir_url(__FILE__) . 'css/animate.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook_suffix ) {
		global $wp_version;

        $version1 = $wp_version;
        $operator = '>=';
        $version2 = '5.5';
        $versionCompare = $this->versionCompare($version1, $operator, $version2);
        if ($versionCompare) {	
            wp_enqueue_script( $this->plugin_name.'-wp-load-scripts', plugin_dir_url(__FILE__) . 'js/ays-wp-load-scripts.js', array(), $this->version, true);
        }

        wp_enqueue_script( $this->plugin_name . "-banner", plugin_dir_url(__FILE__) . 'js/secure-copy-content-protection-banner.js', array('jquery'), $this->version, true);

        $sccp_banner_date = $this->ays_sccp_update_banner_time();
        wp_localize_script($this->plugin_name . '-banner', 'sccpBannerLangObj', array(
            'sccpBannerDate'  	 => $sccp_banner_date,
            'somethingWentWrong' => __( "Maybe something went wrong.", $this->plugin_name ),
            'errorMsg'           => __( "Error", $this->plugin_name )
        ) );	

		if (false !== strpos($hook_suffix, "plugins.php")){			
			wp_enqueue_script($this->plugin_name . '-sweetalert2', plugin_dir_url(__FILE__) . 'js/sweetalert2.all.min.js', array('jquery'), $this->version, true);
			wp_enqueue_script($this->plugin_name . '-admin', plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery'), $this->version, true);
			wp_localize_script($this->plugin_name . '-admin', 'sccp_admin_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
		}

		if (false === strpos($hook_suffix, $this->plugin_name)) {
			return;
		}

		global $wp_roles;
		$ays_users_roles = $wp_roles->roles;

		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_media();

		wp_enqueue_script( $this->plugin_name.'-wp-color-picker-alpha', plugin_dir_url(__FILE__) . 'js/wp-color-picker-alpha.min.js', array('wp-color-picker'), $this->version, true);
		wp_enqueue_script( $this->plugin_name.'-select2', plugin_dir_url(__FILE__) . 'js/select2.min.js', array('jquery'), $this->version, true);		
		wp_enqueue_script( $this->plugin_name.'-dataTables', plugin_dir_url(__FILE__) . 'js/jquery.dataTables.min.js', array('jquery'), $this->version, true);
		wp_enqueue_script( $this->plugin_name.'-dataTables-bootstrap4', plugin_dir_url(__FILE__) . 'js/dataTables.bootstrap4.min.js', array('jquery'), $this->version, true);
		wp_enqueue_script($this->plugin_name . '-sweetalert2', plugin_dir_url(__FILE__) . 'js/sweetalert2.all.min.js', array('jquery'), $this->version, true);		
		wp_enqueue_script('cpy_content_protection_popper', plugin_dir_url(__FILE__) . 'js/popper.min.js', array('jquery'), $this->version, true);
		wp_enqueue_script('cpy_content_protection_bootstrap', plugin_dir_url(__FILE__) . 'js/bootstrap.min.js', array('jquery'), $this->version, true);
		wp_enqueue_script( $this->plugin_name."-jquery.datetimepicker.js", plugin_dir_url( __FILE__ ) . 'js/jquery-ui-timepicker-addon.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/secure-copy-content-protection-admin.js', array('jquery', 'wp-color-picker'), $this->version, true);
		wp_localize_script($this->plugin_name, 'sccp', array(
			'ajax'           	=> admin_url('admin-ajax.php'),
			'loader_message' 	=> __('Just a moment...', $this->plugin_name),
			'loader_url'     	=> SCCP_ADMIN_URL . '/images/rocket.svg',
			'bc_user_role'    	=> $ays_users_roles,
            "emptyEmailError"               => __( 'Email field is empty', $this->plugin_name),
            "invalidEmailError"             => __( 'Invalid Email address', $this->plugin_name),
            'selectUser'                    => __( 'Select user', $this->plugin_name),
            'pleaseEnterMore'               => __( "Please enter 1 or more characters", $this->plugin_name ),
            'searching'                     => __( "Searching...", $this->plugin_name ),
            'activated'                     => __( "Activated", $this->plugin_name ),
            'errorMsg'                      => __( "Error", $this->plugin_name ),
            'loadResource'                  => __( "Can't load resource.", $this->plugin_name ),
            'somethingWentWrong'            => __( "Maybe something went wrong.", $this->plugin_name ),            
            'greateJob'                     => __( 'Great job', $this->plugin_name),
            'formMoreDetailed'              => __( 'For more detailed configuration visit', $this->plugin_name),
            'greate'                        => __( 'Great!', $this->plugin_name),
		));

		$color_picker_strings = array(
			'clear'            => __( 'Clear', $this->plugin_name ),
			'clearAriaLabel'   => __( 'Clear color', $this->plugin_name ),
			'defaultString'    => __( 'Default', $this->plugin_name ),
			'defaultAriaLabel' => __( 'Select default color', $this->plugin_name ),
			'pick'             => __( 'Select Color', $this->plugin_name ),
			'defaultLabel'     => __( 'Color value', $this->plugin_name ),
		);
		wp_localize_script( $this->plugin_name.'-wp-color-picker-alpha', 'wpColorPickerL10n', $color_picker_strings );

		wp_localize_script($this->plugin_name, 'sccpLangObj', array(
            // 'sccpBannerDate'  => $sccp_banner_date,
            'nameField'       => __( 'Name field', $this->plugin_name ),
            'title'           => __( 'Tick the checkbox to show the Name field', $this->plugin_name ),
            'descField'       => __( 'Description field', $this->plugin_name ),
            'descTitle'       => __( 'Tick the checkbox to show the Description field', $this->plugin_name ),
            'adminUrl'        => SCCP_ADMIN_URL,
        ) );		
		
		wp_enqueue_script( $this->plugin_name."-xlsx.core.min.js", plugin_dir_url( __FILE__ ) . 'js/xlsx.core.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name."-fileSaver.js", plugin_dir_url( __FILE__ ) . 'js/FileSaver.js', array( 'jquery' ), $this->version, true );	
		wp_enqueue_script( $this->plugin_name."-jhxlsx.js", plugin_dir_url( __FILE__ ) . 'js/jhxlsx.js', array( 'jquery' ), $this->version, true );

		wp_enqueue_script( $this->plugin_name."-codemirror", plugin_dir_url( __FILE__ ) . 'js/codemirror.min.js', array( 'jquery' ), $this->version, true );

	}

	function codemirror_enqueue_scripts($hook) {
		if (strpos($hook, $this->plugin_name) !== false) {
			if(function_exists('wp_enqueue_code_editor')){
	            $cm_settings['codeEditor'] = wp_enqueue_code_editor(array(
	                'type' => 'text/css',
	                'codemirror' => array(
	                    'inputStyle' => 'contenteditable',
	                    'theme' => 'cobalt',
	                )
	            ));
	        
		        wp_localize_script('wp-theme-plugin-editor', 'cm_settings', $cm_settings);
		       
		        wp_enqueue_script('wp-theme-plugin-editor');
	            wp_enqueue_style('wp-codemirror');
	            
	        }
		}
        
	}

	function versionCompare($version1, $operator, $version2) {
   
        $_fv = intval ( trim ( str_replace ( '.', '', $version1 ) ) );
        $_sv = intval ( trim ( str_replace ( '.', '', $version2 ) ) );
       
        if (strlen ( $_fv ) > strlen ( $_sv )) {
            $_sv = str_pad ( $_sv, strlen ( $_fv ), 0 );
        }
       
        if (strlen ( $_fv ) < strlen ( $_sv )) {
            $_fv = str_pad ( $_fv, strlen ( $_sv ), 0 );
        }
       
        return version_compare ( ( string ) $_fv, ( string ) $_sv, $operator );
    }

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {
		$hook_sccp = add_menu_page(
			'Copy Protection', 
			'Copy Protection', 
			'manage_options', $this->plugin_name, 
			array(
			$this,
			'display_plugin_setup_page'
		), SCCP_ADMIN_URL . '/images/icons/icon-sccp-128x128.svg', 6);
		add_action( "load-$hook_sccp", array( $this, 'add_tabs' ));

		$hook_subscribe_to_view = add_submenu_page( $this->plugin_name,
            __('Subscribe to view', $this->plugin_name),
            __('Subscribe to view', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-subscribe-to-view',
            array($this, 'display_plugin_sccp_subscribe_to_view_page') 
        );
		add_action( "load-$hook_subscribe_to_view", array( $this, 'add_tabs' ));

        global $wpdb;
        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}ays_sccp_reports WHERE `unread` = 1";
        $unread_results_count = $wpdb->get_var($sql);
        $results_text = __('Results', $this->plugin_name);
        $menu_item = ($unread_results_count == 0) ? $results_text : $results_text . '<span class="ays_menu_badge ays_results_bage">' . $unread_results_count . '</span>';
		$hook_results = add_submenu_page( $this->plugin_name,
			$results_text,
            $menu_item,
            'manage_options',
            $this->plugin_name . '-results-to-view',
            array($this, 'display_plugin_sccp_results_to_view_page') 
        );
        add_action("load-$hook_results", array($this, 'screen_option_results'));
		add_action( "load-$hook_results", array( $this, 'add_tabs' ));

		$hook_settings = add_submenu_page( $this->plugin_name,
            __('General Settings', $this->plugin_name),
            __('General Settings', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-settings',
            array($this, 'display_plugin_sccp_settings_page') 
        );
        add_action("load-$hook_settings", array($this, 'screen_option_settings'));
		add_action( "load-$hook_settings", array( $this, 'add_tabs' ));

		$hook_featured_plugins = add_submenu_page( $this->plugin_name,
            __('Our Products', $this->plugin_name),
            __('Our Products', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-featured-plugins',
            array($this, 'display_plugin_sccp_featured_plugins_page') 
        );
		add_action( "load-$hook_featured_plugins", array( $this, 'add_tabs' ));

		$hook_pro_features = add_submenu_page(
			$this->plugin_name,
			__('PRO Features', $this->plugin_name),
			__('PRO Features', $this->plugin_name),
			'manage_options',
			$this->plugin_name . '-pro-features',
			array($this, 'display_plugin_sccp_pro_features_page')
		);
		add_action( "load-$hook_pro_features", array( $this, 'add_tabs' ));
	}

	public function add_tabs() {
		$screen = get_current_screen();
	
		if ( ! $screen) {
			return;
		}
	
		$screen->add_help_tab(
			array(
				'id'      => 'sccp_help_tab',
				'title'   => __( 'General Information:
					'),
				'content' =>
					'<h2>' . __( 'SCCP Information', $this->plugin_name) . '</h2>' .
					'<p>' .
						__( 'Copy Content Protection is a must-have WordPress plugin which prevents the risk of plagiarism on your website. After the activation of the plugin the Copy and Paste, right-click option, inspect elements (F12 key), content-selection, copy the image, save image as features will be automatically disabled. In addition, the user has an option to enable or disable the features via the checkbox.',  $this->plugin_name ).'</p>'
			)
		);
	
		$screen->set_help_sidebar(
			'<p><strong>' . __( 'For more information:', $this->plugin_name) . '</strong></p>' .
			'<p>
				<a href="https://www.youtube.com/watch?v=whYBGV703SM" target="_blank">' . __( 'Youtube video tutorials' , $this->plugin_name ) . '</a>
			</p>' .
			'<p>
				<a href="https://ays-pro.com/wordpress-copy-content-protection-user-manual" target="_blank">' . __( 'Documentation', $this->plugin_name ) . '</a>
			</p>' .
			'<p>
				<a href="https://ays-pro.com/wordpress/secure-copy-content-protection" target="_blank">' . __( 'Copy Protection plugin Premium version', $this->plugin_name ) . '</a>
			</p>'
		);
	}

	public function ays_sccp_get_user_roles_by_userId($id){
        $user_meta = get_userdata($id);
        return $user_meta->roles;
	}

	public function ays_sccp_results_export_xlsx($results){
        
		global $wpdb;
		error_reporting(0);        

        $results_array = array();
		$results_headers = array(
            array( 'text' => "Shortcode ID" ),
            array( 'text' => "User Email" ),
            array( 'text' => "User Name" ),
            array( 'text' => "User IP" ),
            array( 'text' => "Date" ),
            array( 'text' => "WP User" ),
            array( 'text' => "User Roles" ),
            array( 'text' => "City, Country" )
		);

        $results_array[] = $results_headers;
        foreach ($results as $key => $result){
        	
        	$user_roles = $this->ays_sccp_get_user_roles_by_userId($result['user_id']);

        	$role = "";
        	if ( $user_roles && !is_null( $user_roles ) && is_array($user_roles) ) {
        		$role = count($user_roles) > 1 ? implode(", ", $user_roles) : implode("", $user_roles);
        	}
        	
            $result['user_id'] = $result['user_id'] > 0 ? get_user_by('ID', $result['user_id'])->display_name : "Guest";
            $res_array = array(
                array( 'text' => $result['subscribe_id'] ),
                array( 'text' => $result['subscribe_email'] ),
                array( 'text' => $result['user_name'] ),
                array( 'text' => $result['user_ip'] ),
                array( 'text' => $result['vote_date'] ),
                array( 'text' => $result['user_id'] ),
                array( 'text' => $role ),
                array( 'text' => $result['user_address'] )
            );            
      
            $results_array[] = $res_array;
        }
        
		$response = array(
			'status' => true,
			'data'   => $results_array,
			"type"   => 'xlsx'
		);
		return $response;
    }

    public function ays_sccp_results_export_csv($results){
    	global $wpdb;
		error_reporting(0);

		$url = plugin_dir_url(__FILE__) . "partials/results/";
    	$path = plugin_dir_path(__FILE__) . "partials/results/";

		$file_url          	= $url . 'exported_sccp/exported_sccp.csv';
		$file_path          = $path . 'exported_sccp/exported_sccp.csv';
		$export_file        = fopen($file_path, 'wa');

		//BOM characters usage in PHP:
		fputs($export_file, chr(0xEF) . chr(0xBB) . chr(0xBF));

		if (!$export_file) {
			echo json_encode(array(
				'status' => false
			));
			wp_die();
		}

		$export_file_fields = array('Shortcode ID', 'User Email', 'User Name', 'User IP', 'Date', 'WP User', 'User Roles', 'City, Country');
		fputcsv($export_file, $export_file_fields);

		$results_array_csv = array();
		
		foreach ($results as $f_value) {

			$user_roles = $this->ays_sccp_get_user_roles_by_userId($f_value['user_id']);
        	$role = "";
        	if ( $user_roles && !is_null( $user_roles ) && is_array($user_roles) ) {
        		$role = count($user_roles) > 1 ? implode(", ", $user_roles) : implode("", $user_roles);
        	}
        	array_splice($f_value,5,0,$role);
        	
			 $f_value['user_id'] = $f_value['user_id'] > 0 ? get_user_by('ID', $f_value['user_id'])->display_name : "Guest";
			 $results_array_csv = $f_value;
			
			fputcsv($export_file, $results_array_csv);
		}
		
		fclose($export_file);

		$response = array(
			'status' => true,
			'file' 	 => $file_url,
			"type"   => 'csv'
		);

		return $response;
    }

    public function ays_sccp_results_export_json($results){
        
		global $wpdb;
		error_reporting(0);
        $results_array = array();
        foreach ($results as $key => $result){

            $user_roles = $this->ays_sccp_get_user_roles_by_userId($result['user_id']);
        	$role = "";
        	if ( $user_roles && !is_null( $user_roles ) && is_array($user_roles) ) {
        		$role = count($user_roles) > 1 ? implode(", ", $user_roles) : implode("", $user_roles);
        	}
        	
            $user_id = $result['user_id'] > 0 ? get_user_by('ID', $result['user_id'])->display_name : "Guest";
            $res_array = array(
                'subscribe_id'	  => $result['subscribe_id'],
                'subscribe_email' => $result['subscribe_email'],
                'subscribe_email' => $result['user_name'],
                'user_ip' 		  => $result['user_ip'],
                'vote_date' 	  => $result['vote_date'],
                'user_id' 		  => $user_id,
                'user_roles' 	  => $role,
                'user_address'    => $result['user_address']            
            );

            $results_array[] = $res_array;
        }
        
		$response = array(
			'status' => true,
			'data'   => $results_array,
			"type"   => 'json'
		);
		return $response;
    } 

	public function ays_sccp_results_export_file(){
    	global $wpdb;
		error_reporting(0);

		if ( current_user_can('administrator') ) {
			$reports_table = esc_sql($wpdb->prefix . "ays_sccp_reports");

			$type = isset($_REQUEST['type']) ? sanitize_text_field( $_REQUEST['type'] ) : '';

			$shortcode_ids = "SELECT DISTINCT subscribe_id FROM {$reports_table}";
			$short_id = (isset($_REQUEST['sccp_id']) && $_REQUEST['sccp_id'] != null) ? implode(',', array_map('intval', $_REQUEST['sccp_id'])) : esc_sql($shortcode_ids);
			$date_from = isset($_REQUEST['date_from']) && $_REQUEST['date_from'] != '' ? esc_sql($_REQUEST['date_from'])  : esc_sql('2000-01-01');
			$date_to = isset($_REQUEST['date_to']) && $_REQUEST['date_to'] != '' ? esc_sql($_REQUEST['date_to'])  : esc_sql(current_time('Y-m-d'));
			
			$formfields = array();
			if ( ! empty( $short_id ) && $short_id != "") {
				$sql = "SELECT subscribe_id, subscribe_email, user_name, user_ip, vote_date, user_id, user_address 
						FROM {$reports_table}
						WHERE subscribe_id IN ($short_id) 
						AND vote_date BETWEEN '$date_from' AND '$date_to 23:59:59'";

				$formfields = $wpdb->get_results($sql, 'ARRAY_A');
			}

			switch($type){
				case 'csv':
					$export_data = $this->ays_sccp_results_export_csv($formfields);
				break;
				case 'xlsx':
					$export_data = $this->ays_sccp_results_export_xlsx($formfields);
				break;
				case 'json':
					$export_data = $this->ays_sccp_results_export_json($formfields);
				break;
			}

			ob_end_clean();
			$ob_get_clean = ob_get_clean();
			echo json_encode($export_data);
			wp_die();
		}else{
			ob_end_clean();
	        $ob_get_clean = ob_get_clean();
	        echo json_encode(array(
				'status' => false
			));
	        wp_die();
		}

    }

    // EXPORT FILTERS AV
    public function ays_sccp_show_filters(){
        error_reporting(0);
        global $wpdb;

        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'ays_sccp_show_filters' && current_user_can('administrator')) {
        	$reports_table = esc_sql($wpdb->prefix . "ays_sccp_reports");          

			$shortcode_ids = $wpdb->get_results("SELECT DISTINCT subscribe_id FROM {$reports_table}", "ARRAY_A");

            $sql = "SELECT COUNT(subscribe_id) FROM {$reports_table} ORDER BY subscribe_id DESC";
            $short_count = $wpdb->get_var($sql);

            ob_end_clean();
	        $ob_get_clean = ob_get_clean();
            echo json_encode(array(
                "shortcode" => $shortcode_ids,
                "count" => $short_count
            ));
            wp_die();
        } else {
        	ob_end_clean();
	        $ob_get_clean = ob_get_clean();
        	echo json_encode(array(
                "shortcode" => array(),
                "count" => 0
            ));
            wp_die();
        }
    }

    public function ays_sccp_results_export_filter(){
        global $wpdb;
        error_reporting(0);
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'ays_sccp_results_export_filter') {
			$reports_table = esc_sql($wpdb->prefix . "ays_sccp_reports");

			if ( current_user_can('administrator') ) {
				$shortcode_ids = "SELECT DISTINCT subscribe_id FROM {$reports_table}";
				$short_id = (isset($_REQUEST['sccp_id']) && $_REQUEST['sccp_id'] != null) ? implode(',', array_map('intval', $_REQUEST['sccp_id'])) : esc_sql($shortcode_ids);

				$date_from = isset($_REQUEST['date_from']) && $_REQUEST['date_from'] != '' ? esc_sql($_REQUEST['date_from']) : esc_sql('2000-01-01');
				$date_to = isset($_REQUEST['date_to']) && $_REQUEST['date_to'] != '' ? esc_sql($_REQUEST['date_to']) : esc_sql(current_time('Y-m-d'));

				$sql = "SELECT COUNT(subscribe_id) AS qanak FROM {$reports_table}
				WHERE subscribe_id IN ($short_id)
				AND vote_date BETWEEN '$date_from' AND '$date_to 23:59:59'";
				$results = $wpdb->get_var($sql);

				ob_end_clean();
				$ob_get_clean = ob_get_clean();
				$res = array(
					'results' => $results
				);
				echo json_encode($res);
				wp_die();
		 	}else{
				ob_end_clean();
				$ob_get_clean = ob_get_clean();
				echo json_encode(array(
					'status'  => false,
					'results' => 0
				));
				wp_die();
		 	}
		}else{
			ob_end_clean();
			$ob_get_clean = ob_get_clean();
			echo json_encode(array(
				'status'  => false,
				'results' => 0
			));
			wp_die();
	 	}
    }

    public static function set_screen($status, $option, $value){
        return $value;
    }
	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */

	public function add_action_links( $links ) {
		/*
		*  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
		*/
		$settings_link = array(
			'<a href="' . admin_url('options-general.php?page=' . $this->plugin_name) . '">' . __('Settings', $this->plugin_name) . '</a>',
			'<a href="https://ays-demo.com/secure-copy-content-protection-free-demo/" target="_blank">' . __('Demo', $this->plugin_name) . '</a>',
            '<a href="https://ays-pro.com/wordpress/secure-copy-content-protection?utm_source=dashboard-sccp&utm_medium=free-sccp&utm_campaign=buy-now-sccp" class="ays-sccp-upgrade-plugin-btn" target="_blank" style="color:#01A32A; font-weight:bold;">' . __('Upgrade 30% Sale', $this->plugin_name) . '</a>',
		);

		return array_merge($settings_link, $links);

	}

 	public function add_plugin_row_meta($meta, $file) {
		if ($file == SCCP_BASENAME) {
			$meta[] = '<a href="https://wordpress.org/support/plugin/secure-copy-content-protection/" target="_blank">' . esc_html__( 'Free Support', $this->plugin_name ) . '</a>';
		}

		return $meta;
	}


	public function display_plugin_setup_page() {
		$this->settings_obj = new Sccp_Settings_Actions($this->plugin_name);
		require_once('partials/secure-copy-content-protection-admin-display.php');
	}

	public function screen_option_settings() {
        $this->settings_obj = new Sccp_Settings_Actions($this->plugin_name);
    }

	public function display_plugin_sccp_settings_page(){
        include_once('partials/settings/secure-copy-content-protection-settings.php');
    }		

	public function display_plugin_sccp_featured_plugins_page(){
        include_once('partials/features/secure-copy-content-protection-featured-display.php');
    }

    public function display_plugin_sccp_pro_features_page() {
		include_once('partials/features/secure-copy-content-protection-pro-features.php');
	}

	public function display_plugin_sccp_subscribe_to_view_page() {
		include_once('partials/subscribe/secure-copy-content-protection-subscribe-display.php');
    }

	public function display_plugin_sccp_results_to_view_page() {
		include_once('partials/results/secure-copy-content-protection-results-display.php');
    }

	public function deactivate_sccp_option() {		

		if( is_user_logged_in() ) {
            $request_value = esc_sql( sanitize_text_field( $_REQUEST['upgrade_plugin'] ) );
            $upgrade_option = get_option('sccp_upgrade_plugin','');
            if($upgrade_option === ''){
                add_option('sccp_upgrade_plugin', $request_value);
            }else{
                update_option('sccp_upgrade_plugin', $request_value);
            }
            ob_end_clean();
            $ob_get_clean = ob_get_clean();
            echo json_encode(array(
                'option' => get_option('sccp_upgrade_plugin', '')
            ));
            wp_die();
        } else {
            ob_end_clean();
            $ob_get_clean = ob_get_clean();
            echo json_encode(array(
                'option' => ''
            ));
            wp_die();
        }
	}

	public function screen_option_results() {
		$option = 'per_page';
		$args   = array(
			'label'   => __('Results', $this->plugin_name),
			'default' => 7,
			'option'  => 'sccp_results_per_page',
		);

		add_screen_option($option, $args);
		$this->results_obj = new Sccp_Results_List_Table($this->plugin_name);
		$this->settings_obj = new Sccp_Settings_Actions($this->plugin_name);

	}

	// Mailchimp - Get mailchimp lists
    public function ays_get_mailchimp_lists($username, $api_key){
        error_reporting(0);
        if($username == ""){
            return array(
                'total_items' => 0
            );
        }
        if($api_key == ""){
            return array(
                'total_items' => 0
            );
        }
        
        $api_prefix = explode("-",$api_key);
        $api_prefix = isset($api_prefix[1]) && $api_prefix[1] != "" ? $api_prefix[1] : '';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://".$api_prefix.".api.mailchimp.com/3.0/lists/?count=100",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_USERPWD => "$username:$api_key",
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
      		//echo "cURL Error #:" . $err;
        } else {
            return json_decode($response, true);
        }
    }
    public function sccp_admin_footer($a){
        if(isset($_REQUEST['page'])){
            if(false !== strpos($_REQUEST['page'], $this->plugin_name)){
                ?>
                <div class="ays-sccp-footer-support-box">
                    <span class="ays-sccp-footer-link-row"><a href="https://wordpress.org/support/plugin/secure-copy-content-protection/" target="_blank"><?php echo __( "Support", $this->plugin_name); ?></a></span>
                    <span class="ays-sccp-footer-slash-row">/</span>
                    <span class="ays-sccp-footer-link-row"><a href="https://ays-pro.com/wordpress-copy-content-protection-user-manual" target="_blank"><?php echo __( "Docs", $this->plugin_name); ?></a></span>
                    <span class="ays-sccp-footer-slash-row">/</span>
                    <span class="ays-sccp-footer-link-row"><a href="https://ays-demo.com/copy-protection-plugin-survey/" target="_blank"><?php echo __( "Suggest a Feature", $this->plugin_name); ?></a></span>
                </div>
                <p style="font-size:13px;text-align:center;font-style:italic;">
                    <span style="margin-left:0px;margin-right:10px;" class="ays_heart_beat"><i class="ays_fa ays_fa_heart animated"></i></span>
                    <span><?php echo __( "If you love our plugin, please do big favor and rate us on", $this->plugin_name); ?></span> 
                    <a target="_blank" href='https://wordpress.org/support/plugin/secure-copy-content-protection/reviews/?rate=5#new-post'>WordPress.org</a>
                    <a target="_blank" class="ays-rated-link" href='https://wordpress.org/support/plugin/secure-copy-content-protection/reviews/'>
                        <span class="ays-dashicons ays-dashicons-star-empty"></span>
                        <span class="ays-dashicons ays-dashicons-star-empty"></span>
                        <span class="ays-dashicons ays-dashicons-star-empty"></span>
                        <span class="ays-dashicons ays-dashicons-star-empty"></span>
                        <span class="ays-dashicons ays-dashicons-star-empty"></span>
                    </a>
                    <span class="ays_heart_beat"><i class="ays_fa ays_fa_heart animated"></i></span>
                </p>
            <?php
            }
        }
    }

	// Mailchimp update list
	public static function ays_add_mailchimp_update_list($username, $api_key, $list_id, $args){
		if($username == "" || $api_key == ""){
			return false;
		}

		if( $list_id == '' ){
			return false;
		}

		if( ! isset( $args['double_optin'] ) || ! array_key_exists( 'double_optin', $args ) ){
			return false;
		}

		$list_data = self::ays_get_mailchimp_list( $username, $api_key, $list_id );

		if( empty( $list_data ) ){
			return false;
		}

		$double_optin = isset( $args['double_optin'] ) && $args['double_optin'] == 'on' ? true : false;

		$fields = array(
			"name" => $list_data['name'],
			"contact" => $list_data['contact'],
			"permission_reminder" => $list_data['permission_reminder'],
			"use_archive_bar" => $list_data['use_archive_bar'],
			"campaign_defaults" => $list_data['campaign_defaults'],
			"email_type_option" => $list_data['email_type_option'],
			"double_optin" => $double_optin,
		);

		$api_prefix = explode("-",$api_key)[1];

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://".$api_prefix.".api.mailchimp.com/3.0/lists/".$list_id."/",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_USERPWD => "$username:$api_key",
			CURLOPT_CUSTOMREQUEST => "PATCH",
			CURLOPT_POSTFIELDS => json_encode($fields),
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
				"cache-control: no-cache"
			),
		));

		$response = curl_exec($curl);

		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			return "cURL Error #: " . $err;
		} else {
			return json_decode( $response, true );
		}
	}

	// Mailchimp - Get mailchimp list
	public static function ays_get_mailchimp_list($username, $api_key, $list_id){
		error_reporting(0);
		if($username == ""){
			return array();
		}
		if($api_key == ""){
			return array();
		}
		if($list_id == ""){
			return array();
		}

		$api_prefix = explode("-",$api_key)[1];

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://".$api_prefix.".api.mailchimp.com/3.0/lists/".$list_id,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_USERPWD => "$username:$api_key",
			CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
				"cache-control: no-cache"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
//            echo "cURL Error #:" . $err;
		} else {
			return json_decode($response, true);
		}
	}
	
	public function ays_sccp_reports_user_search() {
        error_reporting(0);
        global $wpdb;

        $search = isset($_REQUEST['search']) && $_REQUEST['search'] != '' ? $_REQUEST['search'] : null;
        $checked = isset($_REQUEST['val']) && $_REQUEST['val'] !='' ? $_REQUEST['val'] : null;
        $users_sql = "SELECT user_id
                       FROM {$wpdb->prefix}ays_sccp_reports
                       GROUP BY user_id";
        $users = $wpdb->get_results($users_sql,"ARRAY_A");
        $args = array();
        $arg = '';

        if($search !== null){
             $arg .= $search;
             $arg .= '*';
             $args['search'] = $arg;
        }
        $guest = false;
        foreach ($users as $key => $value ) {
            $args['include'][] = $value['user_id'];
            if ( $value['user_id'] == '0' && strpos('guest', strtolower($search)) !== false ) {
            	$guest = true;
            }
        }

        $reports_users = get_users($args);
        $response = array(
            'results' => array()
        );
        if(empty($args)){
            $reports_users = '';
        }

        foreach ($reports_users as $key => $user) {
            if ($checked !== null) {
                if (in_array($user->ID, $checked)) {
                    continue;
                }else{
                    $response['results'][] = array(
                        'id' => $user->ID,
                        'text' => $user->data->display_name
                    );
                }
            }else{
                $response['results'][] = array(
                    'id' => $user->ID,
                    'text' => $user->data->display_name,
                );
            }
        }
        if ($guest) {
        	$response['results'][] = array(
                'id' => 0,
                'text' => 'Guest',
            );
        }        

        ob_end_clean();
        echo json_encode($response);
        wp_die();
    }

    public function ays_sccp_dismiss_button(){

        $data = array(
            'status' => false,
        );

        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'ays_sccp_dismiss_button') { 
            if( (isset( $_REQUEST['_ajax_nonce'] ) && wp_verify_nonce( $_REQUEST['_ajax_nonce'], SCCP_NAME . '-sale-banner' )) && current_user_can( 'manage_options' )){
                update_option('ays_sccp_sale_btn', 1);
                update_option('ays_sccp_sale_date', current_time( 'mysql' ));
                $data['status'] = true;
            }
        }

        ob_end_clean();
        $ob_get_clean = ob_get_clean();
        echo json_encode($data);
        wp_die();

    }

    public function ays_sccp_update_banner_time(){

        $date = time() + ( 3 * 24 * 60 * 60 ) + (int) ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS);
        // $date = time() + ( 60 ) + (int) ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS); // for testing | 1 min
        $next_3_days = date('M d, Y H:i:s', $date);

        $ays_sccp_banner_time = get_option('ays_sccp_banner_time');

        if ( !$ays_sccp_banner_time || is_null( $ays_sccp_banner_time ) ) {
            update_option('ays_sccp_banner_time', $next_3_days ); 
        }

        $get_ays_sccp_banner_time = get_option('ays_sccp_banner_time');

        $val = 60*60*24*0.5; // half day
        // $val = 60; // for testing | 1 min

        $current_date = current_time( 'mysql' );
        $date_diff = strtotime($current_date) - intval(strtotime($get_ays_sccp_banner_time));

        $days_diff = $date_diff / $val;
        if(intval($days_diff) > 0 ){
            update_option('ays_sccp_banner_time', $next_3_days);
        }

        return $get_ays_sccp_banner_time;
    }

    public function ays_sccp_generate_message_vars_html( $sccp_message_vars ) {
        $content = array();
        $var_counter = 0; 

        $content[] = '<div class="ays-sccp-message-vars-box">';
            $content[] = '<div class="ays-sccp-message-vars-icon">';
                $content[] = '<div>';
                    $content[] = '<i class="ays_fa ays_fa_link"></i>';
                $content[] = '</div>';
                $content[] = '<div>';
                    $content[] = '<span>'. __("Message Variables" , $this->plugin_name) .'</span>';
                    $content[] = '<a class="ays_help" data-toggle="tooltip" data-html="true" title="'. __("Insert your preferred message variable into the editor by clicking." , $this->plugin_name) .'">';
                        $content[] = '<i class="ays_fa ays_fa_info_circle"></i>';
                    $content[] = '</a>';
                $content[] = '</div>';
            $content[] = '</div>';
            $content[] = '<div class="ays-sccp-message-vars-data">';
                foreach($sccp_message_vars as $var => $var_name){
                    $var_counter++;
                    $content[] = '<label class="ays-sccp-message-vars-each-data-label">';
                        $content[] = '<input type="radio" class="ays-sccp-message-vars-each-data-checker" hidden id="ays_sccp_message_var_count_'. $var_counter .'" name="ays_sccp_message_var_count">';
                        $content[] = '<div class="ays-sccp-message-vars-each-data">';
                            $content[] = '<input type="hidden" class="ays-sccp-message-vars-each-var" value="'. $var .'">';
                            $content[] = '<span>'. $var_name .'</span>';
                        $content[] = '</div>';
                    $content[] = '</label>';
                }
            $content[] = '</div>';
        $content[] = '</div>';

        $content = implode( '', $content );

        return $content;
    }

    /**
     * Determine if the plugin/addon installations are allowed.
     *
     * @since 1.3.9
     *
     * @param string $type Should be `plugin` or `addon`.
     *
     * @return bool
     */
    public static function ays_sccp_can_install( $type ) {

        return self::ays_sccp_can_do( 'install', $type );
    }

    /**
     * Determine if the plugin/addon activations are allowed.
     *
     * @since 1.3.9
     *
     * @param string $type Should be `plugin` or `addon`.
     *
     * @return bool
     */
    public static function ays_sccp_can_activate( $type ) {

        return self::ays_sccp_can_do( 'activate', $type );
    }

    /**
     * Determine if the plugin/addon installations/activations are allowed.
     *
     * @since 1.3.9
     *
     * @param string $what Should be 'activate' or 'install'.
     * @param string $type Should be `plugin` or `addon`.
     *
     * @return bool
     */
    public static function ays_sccp_can_do( $what, $type ) {

        if ( ! in_array( $what, array( 'install', 'activate' ), true ) ) {
            return false;
        }

        if ( ! in_array( $type, array( 'plugin', 'addon' ), true ) ) {
            return false;
        }

        $capability = $what . '_plugins';

        if ( ! current_user_can( $capability ) ) {
            return false;
        }

        // Determine whether file modifications are allowed and it is activation permissions checking.
        if ( $what === 'install' && ! wp_is_file_mod_allowed( 'ays_sccp_can_install' ) ) {
            return false;
        }

        // All plugin checks are done.
        if ( $type === 'plugin' ) {
            return true;
        }
        return false;
    }

    /**
     * Activate plugin.
     *
     * @since 1.0.0
     * @since 1.3.9 Updated the permissions checking.
     */
    public function ays_sccp_activate_plugin() {

        // Run a security check.
        check_ajax_referer( $this->plugin_name . '-install-plugin-nonce', sanitize_key( $_REQUEST['_ajax_nonce'] ) );

        // Check for permissions.
        if ( ! current_user_can( 'activate_plugins' ) ) {
            wp_send_json_error( esc_html__( 'Plugin activation is disabled for you on this site.', $this->plugin_name ) );
        }

        $type = 'addon';

        if ( isset( $_POST['plugin'] ) ) {

            if ( ! empty( $_POST['type'] ) ) {
                $type = sanitize_key( $_POST['type'] );
            }

            $plugin   = sanitize_text_field( wp_unslash( $_POST['plugin'] ) );
            $activate = activate_plugins( $plugin );

            if ( ! is_wp_error( $activate ) ) {
                if ( $type === 'plugin' ) {
                    wp_send_json_success( esc_html__( 'Plugin activated.', $this->plugin_name ) );
                } else {
                        ( esc_html__( 'Addon activated.', $this->plugin_name ) );
                }
            }
        }

        if ( $type === 'plugin' ) {
            wp_send_json_error( esc_html__( 'Could not activate the plugin. Please activate it on the Plugins page.', $this->plugin_name ) );
        }

        wp_send_json_error( esc_html__( 'Could not activate the addon. Please activate it on the Plugins page.', $this->plugin_name ) );
    }

    /**
     * Install addon.
     *
     * @since 1.0.0
     * @since 1.3.9 Updated the permissions checking.
     */
    public function ays_sccp_install_plugin() {

        // Run a security check.
        check_ajax_referer( $this->plugin_name . '-install-plugin-nonce', sanitize_key( $_REQUEST['_ajax_nonce'] ) );

        $generic_error = esc_html__( 'There was an error while performing your request.', $this->plugin_name );
        $type          = ! empty( $_POST['type'] ) ? sanitize_key( $_POST['type'] ) : '';

        // Check if new installations are allowed.
        if ( ! self::ays_sccp_can_install( $type ) ) {
            wp_send_json_error( $generic_error );
        }

        $error = $type === 'plugin'
            ? esc_html__( 'Could not install the plugin. Please download and install it manually.', $this->plugin_name )
            : "";

        $plugin_url = ! empty( $_POST['plugin'] ) ? esc_url_raw( wp_unslash( $_POST['plugin'] ) ) : '';

        if ( empty( $plugin_url ) ) {
            wp_send_json_error( $error );
        }

        // Prepare variables.
        $url = esc_url_raw(
            add_query_arg(
                [
                    'page' => 'secure-copy-content-protection-featured-plugins',
                ],
                admin_url( 'admin.php' )
            )
        );

        ob_start();
        $creds = request_filesystem_credentials( $url, '', false, false, null );

        // Hide the filesystem credentials form.
        ob_end_clean();

        // Check for file system permissions.
        if ( $creds === false ) {
            wp_send_json_error( $error );
        }
        
        if ( ! WP_Filesystem( $creds ) ) {
            wp_send_json_error( $error );
        }

        /*
         * We do not need any extra credentials if we have gotten this far, so let's install the plugin.
         */
        require_once SCCP_DIR . 'includes/admin/class-secure-copy-content-protection-upgrader.php';
        require_once SCCP_DIR . 'includes/admin/class-secure-copy-content-protection-install-skin.php';
        require_once SCCP_DIR . 'includes/admin/class-secure-copy-content-protection-skin.php';


        // Do not allow WordPress to search/download translations, as this will break JS output.
        remove_action( 'upgrader_process_complete', array( 'Language_Pack_Upgrader', 'async_upgrade' ), 20 );

        // Create the plugin upgrader with our custom skin.
        $installer = new SecureCopyContentProtection\Helpers\SecureCopyContentProtectionPluginSilentUpgrader( new Secure_Copy_Content_Protection_Install_Skin() );

        // Error check.
        if ( ! method_exists( $installer, 'install' ) ) {
            wp_send_json_error( $error );
        }

        $installer->install( $plugin_url );

        // Flush the cache and return the newly installed plugin basename.
        wp_cache_flush();

        $plugin_basename = $installer->plugin_info();

        if ( empty( $plugin_basename ) ) {
            wp_send_json_error( $error );
        }

        $result = array(
            'msg'          => $generic_error,
            'is_activated' => false,
            'basename'     => $plugin_basename,
        );

        // Check for permissions.
        if ( ! current_user_can( 'activate_plugins' ) ) {
            $result['msg'] = $type === 'plugin' ? esc_html__( 'Plugin installed.', $this->plugin_name ) : "";

            wp_send_json_success( $result );
        }

        // Activate the plugin silently.
        $activated = activate_plugin( $plugin_basename );
        remove_action( 'activated_plugin', array( 'gallery_p_gallery_activation_redirect_method', 'poll_maker_activation_redirect_method' ), 100 );

        if ( ! is_wp_error( $activated ) ) {

            $result['is_activated'] = true;
            $result['msg']          = $type === 'plugin' ? esc_html__( 'Plugin installed and activated.', $this->plugin_name ) : esc_html__( 'Addon installed and activated.', $this->plugin_name );

            wp_send_json_success( $result );
        }

        // Fallback error just in case.
        wp_send_json_error( $result );
    }

    /**
     * List of AM plugins that we propose to install.
     *
     * @since 1.3.9
     *
     * @return array
     */
    protected function sccp_get_am_plugins() {
        if ( !isset( $_SESSION ) ) {
            session_start();
        }

        $images_url = SCCP_ADMIN_URL . '/images/icons/';

        $plugin_slug = array(
            'quiz-maker',
            'survey-maker',
            'poll-maker',
            'ays-popup-box',
            'gallery-photo-gallery',
            'personal-dictionary',
            'chart-builder',
            'easy-form',
        );

        $plugin_url_arr = array();
        foreach ($plugin_slug as $key => $slug) {
            if ( isset( $_SESSION['ays_sccp_our_product_links'] ) && !empty( $_SESSION['ays_sccp_our_product_links'] ) 
                && isset( $_SESSION['ays_sccp_our_product_links'][$slug] ) && !empty( $_SESSION['ays_sccp_our_product_links'][$slug] ) ) {
                $plugin_url = (isset( $_SESSION['ays_sccp_our_product_links'][$slug] ) && $_SESSION['ays_sccp_our_product_links'][$slug] != "") ? esc_url( $_SESSION['ays_sccp_our_product_links'][$slug] ) : "";
            } else {
                $latest_version = $this->ays_sccp_get_latest_plugin_version($slug);
                $plugin_url = 'https://downloads.wordpress.org/plugin/'. $slug .'.zip';
                if ( $latest_version != '' ) {
                    $plugin_url = 'https://downloads.wordpress.org/plugin/'. $slug .'.'. $latest_version .'.zip';
                    $_SESSION['ays_sccp_our_product_links'][$slug] = $plugin_url;
                }
            }

            $plugin_url_arr[$slug] = $plugin_url;
        }

        $plugins_array = array(
           'quiz-maker/quiz-maker.php'        => array(
                'icon'        => $images_url . 'icon-quiz-128x128.png',
                'name'        => __( 'Quiz Maker', $this->plugin_name ),
                'desc'        => __( 'With our Quiz Maker plugin it’s easy to make a quiz in a short time.', $this->plugin_name ),
                'desc_hidden' => __( 'You to add images to your quiz, order unlimited questions. Also you can style your quiz to satisfy your visitors.', $this->plugin_name ),
                'wporg'       => 'https://wordpress.org/plugins/quiz-maker/',
                'buy_now'     => 'https://ays-pro.com/wordpress/quiz-maker/',
                'url'         => $plugin_url_arr['quiz-maker'],
            ),
            'survey-maker/survey-maker.php'        => array(
                'icon'        => $images_url . 'icon-survey-128x128.png',
                'name'        => __( 'Survey Maker', $this->plugin_name ),
                'desc'        => __( 'Make amazing online surveys and get real-time feedback quickly and easily.', $this->plugin_name ),
                'desc_hidden' => __( 'Learn what your website visitors want, need, and expect with the help of Survey Maker. Build surveys without limiting your needs.', $this->plugin_name ),
                'wporg'       => 'https://wordpress.org/plugins/survey-maker/',
                'buy_now'     => 'https://ays-pro.com/wordpress/survey-maker',
                'url'         => $plugin_url_arr['survey-maker'],
            ),
            'poll-maker/poll-maker-ays.php'        => array(
                'icon'        => $images_url . 'icon-poll-128x128.png',
                'name'        => __( 'Poll Maker', $this->plugin_name ),
                'desc'        => __( 'Create amazing online polls for your WordPress website super easily.', $this->plugin_name ),
                'desc_hidden' => __( 'Build up various types of polls in a minute and get instant feedback on any topic or product.', $this->plugin_name ),
                'wporg'       => 'https://wordpress.org/plugins/poll-maker/',
                'buy_now'     => 'https://ays-pro.com/wordpress/poll-maker/',
                'url'         => $plugin_url_arr['poll-maker'],
            ),
            'ays-popup-box/ays-pb.php'        => array(
                'icon'        => $images_url . 'icon-popup-128x128.png',
                'name'        => __( 'Popup Box', $this->plugin_name ),
                'desc'        => __( 'Popup everything you want! Create informative and promotional popups all in one plugin.', $this->plugin_name ),
                'desc_hidden' => __( 'Attract your visitors and convert them into email subscribers and paying customers.', $this->plugin_name ),
                'wporg'       => 'https://wordpress.org/plugins/ays-popup-box/',
                'buy_now'     => 'https://ays-pro.com/wordpress/popup-box/',
                'url'         => $plugin_url_arr['ays-popup-box'],
            ),
            'gallery-photo-gallery/gallery-photo-gallery.php'        => array(
                'icon'        => $images_url . 'icon-gallery-128x128.png',
                'name'        => __( 'Gallery Photo Gallery', $this->plugin_name ),
                'desc'        => __( 'Create unlimited galleries and include unlimited images in those galleries.', $this->plugin_name ),
                'desc_hidden' => __( 'Represent images in an attractive way. Attract people with your own single and multiple free galleries from your photo library.', $this->plugin_name ),
                'wporg'       => 'https://wordpress.org/plugins/gallery-photo-gallery/',
                'buy_now'     => 'https://ays-pro.com/wordpress/photo-gallery/',
                'url'         => $plugin_url_arr['gallery-photo-gallery'],
            ),
            'personal-dictionary/personal-dictionary.php'        => array(
                'icon'        => $images_url . 'pd-logo-128x128.png',
                'name'        => __( 'Personal Dictionary', $this->plugin_name ),
                'desc'        => __( 'Allow your students to create personal dictionary, study and memorize the words.', $this->plugin_name ),
                'desc_hidden' => __( 'Allow your users to create their own digital dictionaries and learn new words and terms as fastest as possible.', $this->plugin_name ),
                'wporg'       => 'https://wordpress.org/plugins/personal-dictionary/',
                'buy_now'     => 'https://ays-pro.com/wordpress/personal-dictionary/',
                'url'         => $plugin_url_arr['personal-dictionary'],
            ),
            'chart-builder/chart-builder.php'        => array(
                'icon'        => $images_url . 'chartify-150x150.png',
                'name'        => __( 'Chart Builder', $this->plugin_name ),
                'desc'        => __( 'Chart Builder plugin allows you to create beautiful charts', $this->plugin_name ),
                'desc_hidden' => __( ' and graphs easily and quickly.', $this->plugin_name ),
                'wporg'       => 'https://wordpress.org/plugins/chart-builder/',
                'buy_now'     => 'https://ays-pro.com/wordpress/chart-builder/',
                'url'         => $plugin_url_arr['chart-builder'],
            ),
            'easy-form/easy-form.php'        => array(
                'icon'        => $images_url . 'easyform-150x150.png',
                'name'        => __( 'Easy Form', 'chart-builder' ),
                'desc'        => __( 'Choose the best WordPress form builder plugin. ', 'chart-builder' ),
                'desc_hidden' => __( 'Create contact forms, payment forms, surveys, and many more custom forms. Build forms easily with us.', 'chart-builder' ),
                'wporg'       => 'https://wordpress.org/plugins/easy-form/',
                'buy_now'     => 'https://ays-pro.com/wordpress/easy-form',
                'url'         => $plugin_url_arr['easy-form'],
            ),
        );

        return $plugins_array;
    }

    protected function ays_sccp_get_latest_plugin_version( $slug ){

        if ( is_null( $slug ) || empty($slug) ) {
            return "";
        }

        $version_latest = "";

        if ( ! function_exists( 'plugins_api' ) ) {
              require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
        }

        // set the arguments to get latest info from repository via API ##
        $args = array(
            'slug' => $slug,
            'fields' => array(
                'version' => true,
            )
        );

        /** Prepare our query */
        $call_api = plugins_api( 'plugin_information', $args );

        /** Check for Errors & Display the results */
        if ( is_wp_error( $call_api ) ) {
            $api_error = $call_api->get_error_message();
        } else {

            //echo $call_api; // everything ##
            if ( ! empty( $call_api->version ) ) {
                $version_latest = $call_api->version;
            }
        }

        return $version_latest;
    }

    /**
     * Get AM plugin data to display in the Addons section of About tab.
     *
     * @since 6.4.0.4
     *
     * @param string $plugin      Plugin slug.
     * @param array  $details     Plugin details.
     * @param array  $all_plugins List of all plugins.
     *
     * @return array
     */
    protected function sccp_get_plugin_data( $plugin, $details, $all_plugins ) {

        $have_pro = ( ! empty( $details['pro'] ) && ! empty( $details['pro']['plug'] ) );
        $show_pro = false;

        $plugin_data = array();

        if ( $have_pro ) {
            if ( array_key_exists( $plugin, $all_plugins ) ) {
                if ( is_plugin_active( $plugin ) ) {
                    $show_pro = true;
                }
            }
            if ( array_key_exists( $details['pro']['plug'], $all_plugins ) ) {
                $show_pro = true;
            }
            if ( $show_pro ) {
                $plugin  = $details['pro']['plug'];
                $details = $details['pro'];
            }
        }

        if ( array_key_exists( $plugin, $all_plugins ) ) {
            if ( is_plugin_active( $plugin ) ) {
                // Status text/status.
                $plugin_data['status_class'] = 'status-active';
                $plugin_data['status_text']  = esc_html__( 'Active', $this->plugin_name );
                // Button text/status.
                $plugin_data['action_class'] = $plugin_data['status_class'] . ' ays-sccp-card__btn-info disabled';
                $plugin_data['action_text']  = esc_html__( 'Activated', $this->plugin_name );
                $plugin_data['plugin_src']   = esc_attr( $plugin );
            } else {
                // Status text/status.
                $plugin_data['status_class'] = 'status-installed';
                $plugin_data['status_text']  = esc_html__( 'Inactive', $this->plugin_name );
                // Button text/status.
                $plugin_data['action_class'] = $plugin_data['status_class'] . ' ays-sccp-card__btn-info';
                $plugin_data['action_text']  = esc_html__( 'Activate', $this->plugin_name );
                $plugin_data['plugin_src']   = esc_attr( $plugin );
            }
        } else {
            // Doesn't exist, install.
            // Status text/status.
            $plugin_data['status_class'] = 'status-missing';

            if ( isset( $details['act'] ) && 'go-to-url' === $details['act'] ) {
                $plugin_data['status_class'] = 'status-go-to-url';
            }
            $plugin_data['status_text'] = esc_html__( 'Not Installed', $this->plugin_name );
            // Button text/status.
            $plugin_data['action_class'] = $plugin_data['status_class'] . ' ays-sccp-card__btn-info';
            $plugin_data['action_text']  = esc_html__( 'Install Plugin', $this->plugin_name );
            $plugin_data['plugin_src']   = esc_url( $details['url'] );
        }

        $plugin_data['details'] = $details;

        return $plugin_data;
    }

    /**
     * Display the Addons section of About tab.
     *
     * @since 1.3.9
     */
    public function sccp_output_about_addons() {

        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $all_plugins          = get_plugins();
        $am_plugins           = $this->sccp_get_am_plugins();
        $can_install_plugins  = self::ays_sccp_can_install( 'plugin' );
        $can_activate_plugins = self::ays_sccp_can_activate( 'plugin' );

        $content = '';
        $content.= '<div class="ays-sccp-cards-block">';
        foreach ( $am_plugins as $plugin => $details ){

            $plugin_data = $this->sccp_get_plugin_data( $plugin, $details, $all_plugins );
            $plugin_ready_to_activate = $can_activate_plugins
                && isset( $plugin_data['status_class'] )
                && $plugin_data['status_class'] === 'status-installed';
            $plugin_not_activated     = ! isset( $plugin_data['status_class'] )
                || $plugin_data['status_class'] !== 'status-active';

            $plugin_action_class = ( isset( $plugin_data['action_class'] ) && esc_attr( $plugin_data['action_class'] ) != "" ) ? esc_attr( $plugin_data['action_class'] ) : "";

            $plugin_action_class_disbaled = "";
            if ( strpos($plugin_action_class, 'status-active') !== false ) {
                $plugin_action_class_disbaled = "disbaled='true'";
            }

            $content .= '
                <div class="ays-sccp-card">
                    <div class="ays-sccp-card__content flexible">
                        <div class="ays-sccp-card__content-img-box">
                            <img class="ays-sccp-card__img" src="'. esc_url( $plugin_data['details']['icon'] ) .'" alt="'. esc_attr( $plugin_data['details']['name'] ) .'">
                        </div>
                        <div class="ays-sccp-card__text-block">
                            <h5 class="ays-sccp-card__title">'. esc_html( $plugin_data['details']['name'] ) .'</h5>
                            <p class="ays-sccp-card__text">'. wp_kses_post( $plugin_data['details']['desc'] ) .'
                                <span class="ays-sccp-card__text-hidden">
                                    '. wp_kses_post( $plugin_data['details']['desc_hidden'] ) .'
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="ays-sccp-card__footer">';
                        if ( $can_install_plugins || $plugin_ready_to_activate || ! $details['wporg'] ) {
                            $content .= '<button class="'. esc_attr( $plugin_data['action_class'] ) .'" data-plugin="'. esc_attr( $plugin_data['plugin_src'] ) .'" data-type="plugin" '. $plugin_action_class_disbaled .'>
                                '. wp_kses_post( $plugin_data['action_text'] ) .'
                            </button>';
                        }
                        elseif ( $plugin_not_activated ) {
                            $content .= '<a href="'. esc_url( $details['wporg'] ) .'" target="_blank" rel="noopener noreferrer">
                                '. esc_html_e( 'WordPress.org', $this->plugin_name ) .'
                                <span aria-hidden="true" class="dashicons dashicons-external"></span>
                            </a>';
                        }
            $content .='
                        <a target="_blank" href="'. esc_url( $plugin_data['details']['buy_now'] ) .'" class="ays-sccp-card__btn-primary">'. __('Buy Now', $this->plugin_name) .'</a>
                    </div>
                </div>';
        }
        $install_plugin_nonce = wp_create_nonce( $this->plugin_name . '-install-plugin-nonce' );
        $content.= '<input type="hidden" id="ays_sccp_ajax_install_plugin_nonce" name="ays_sccp_ajax_install_plugin_nonce" value="'. $install_plugin_nonce .'">';
        $content.= '</div>';

        echo $content;
    }

}