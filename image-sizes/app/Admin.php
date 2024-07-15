<?php
namespace Codexpert\ThumbPress\App;

use Codexpert\Plugin\Base;
use Codexpert\ThumbPress\Helper;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Admin
 * @author Codexpert <hi@codexpert.io>
 */
class Admin extends Base {

	public $plugin;

	public $slug;

	public $name;

	public $server;

	public $version;

	public $admin_url;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->server	= $this->plugin['server'];
		$this->version	= $this->plugin['Version'];
	}

	/**
	 * Check for action scheduler tables before activation
	 */
	public function check_action_scheduler_tables() {

		$table_report = thumbpress_check_action_tables();

		// check for missing tables
		if( in_array( true, $table_report ) ) :

			// check store table
			if( $table_report['store_table_missing'] ) :
				delete_option( 'schema-ActionScheduler_StoreSchema' );

				$action_store_db 	= new \ActionScheduler_DBStore();
				$action_store_db->init();
			endif;

			// check log table
			if( $table_report['log_table_missing'] ) :
				delete_option( 'schema-ActionScheduler_LoggerSchema' );

				$action_log_db 		= new \ActionScheduler_DBLogger();
				$action_log_db->init();
			endif;

		endif;
	}

	/**
	 * Internationalization
	 */
	public function i18n() {
		load_plugin_textdomain( 'image-sizes', false, THUMBPRESS_DIR . '/languages/' );
	}

	public function upgrade() {
		
		if( $this->version == get_option( "{$this->slug}_db-version" ) ) return;
		update_option( "{$this->slug}_db-version", $this->version );
		
		delete_option( 'codexpert-blog-json' );
	}

	/**
	 * Enqueue JavaScripts and stylesheets
	 */
	public function enqueue_scripts() {
		$min = defined( 'THUMBPRESS_DEBUG' ) && THUMBPRESS_DEBUG ? '' : '.min';
		
		wp_enqueue_style( $this->slug, plugins_url( "/assets/css/admin.css", THUMBPRESS ), '', time(), 'all' );
		// wp_enqueue_style( $this->slug . '-slick', plugins_url( "/assets/slick/slick.css", THUMBPRESS ), '', $this->version, 'all' );
		wp_enqueue_style( $this->slug . 'dashboard', plugins_url( "/assets/css/settings/dashboard.css", THUMBPRESS ), '', time(), 'all' );
		wp_enqueue_style( $this->slug . 'google-font', "https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap");
		wp_enqueue_style( $this->slug . 'font-awesome', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css");
		
		// slider
		// wp_enqueue_style( $this->slug . 'flickty-css', 'https://unpkg.com/flickity@2/dist/flickity.min.css', '', $this->version, 'all' );
		
		// wp_enqueue_script($this->slug . "-slick", plugins_url("/assets/slick/slick.min.js", THUMBPRESS), ['jquery'], $this->version, true);
		wp_enqueue_script($this->slug, plugins_url("/assets/js/admin{$min}.js", THUMBPRESS), ['jquery'], time(), true);
		
		// wp_enqueue_style( "{$this->slug}-react", plugins_url( 'build/index.css', THUMBPRESS ) );
		wp_enqueue_script( "{$this->slug}-react", plugins_url( 'build/index.js', THUMBPRESS ), [ 'wp-element' ], '1.0.0', true );
		
		// slider
		// wp_enqueue_script( $this->slug . 'bridge-js', 'https://cdn.jsdelivr.net/npm/jquery-bridget@3.0.1/jquery-bridget.min.js', ['jquery'], time(), true );
		// wp_enqueue_script( $this->slug . 'flickty-js', 'https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js', ['jquery'], time(), true );
		
		wp_enqueue_script('wp-pointer');
		wp_enqueue_style('wp-pointer');

		$localized = array(
			'ajaxurl'		=> admin_url( 'admin-ajax.php' ),
			'nonce'			=> wp_create_nonce( $this->slug ),
			'asseturl'		=> THUMBPRESS_ASSET,
			'regen'			=> __( 'Regenerate', 'image-sizes' ),
			'regening'		=> __( 'Regenerating..', 'image-sizes' ),
			'analyze'		=> __( 'Analyze', 'image-sizes' ),
			'analyzing'		=> __( 'Analyzing..', 'image-sizes' ),
			'analyzed'		=> __( 'Analyzed', 'image-sizes' ),
			'optimize'		=> __( 'Compress', 'image-sizes' ),
			'optimizing'	=> __( 'Compressing..', 'image-sizes' ),
			'optimized'		=> __( 'Compressed', 'image-sizes' ),
			'confirm'		=> esc_html__( 'Are you sure you want to delete this? The data and its associated files will be completely erased. This action cannot be undone!', 'image-sizes' ),
			'confirm_all'	=> esc_html__( 'Are you sure you want to delete these? The data and their associated files will be completely erased. This action cannot be undone!', 'image-sizes' ),
			// 'is_welcome'	=> $this->get_pointers(),
			'live_chat'		=> get_option( 'thumbpress_live_chat_enabled' ) == 1,
			'tp_page'		=> isset( $_GET['page'] ) && false !== strpos( $_GET['page'], 'thumbpress' ),
			'name'			=> get_userdata( get_current_user_id() )->display_name,
			'email'			=> get_userdata( get_current_user_id() )->user_email,
			'converting'	=> __( 'Converting', 'image-sizes' ),
		);
		wp_localize_script( $this->slug, 'THUMBPRESS', apply_filters( "{$this->slug}-localized", $localized ) );
	}

	public function action_links( $links ) {
		$this->admin_url = admin_url( 'admin.php' );

		$new_links = [
			'settings'	=> sprintf( '<a href="%1$s">' . __( 'Settings', 'image-sizes' ) . '</a>', add_query_arg( 'page', 'thumbpress', $this->admin_url ) )
		];
		
		return array_merge( $new_links, $links );
	}

	public function plugin_row_meta( $plugin_meta, $plugin_file ) {
		
		if ( $this->plugin['basename'] === $plugin_file ) {
			$plugin_meta['help'] = '<a href="https://help.codexpert.io/" target="_blank" class="cx-help">' . __( 'Help', 'image-sizes' ) . '</a>';
		}

		return $plugin_meta;
	}

	public function footer_text( $text ) {
		if( get_current_screen()->parent_base != $this->slug ) return $text;

		/* translators: %1$s is the plugin name, %2$s is the link to leave a review, %3$s is the rating stars */
		return sprintf( __( 'If you like <strong>%1$s</strong>, please <a href="%2$s" target="_blank">leave us a %3$s rating</a> on WordPress.org! It\'d motivate and inspire us to make the plugin even better!', 'image-sizes' ), $this->name, "https://wordpress.org/support/plugin/{$this->slug}/reviews/?filter=5#new-post", '⭐⭐⭐⭐⭐' );
	}

	public function modal() {
		echo '
		<div id="image-sizes-modal" style="display: none">
			<img id="image-sizes-modal-loader" src="' . esc_attr( THUMBPRESS_ASSET . '/img/loader.gif' ) . '" />
		</div>';
	}

	// public function popup_for_feedback() {
	// 	echo '
	// 	<div id="feedback-modal" style="display:none;" class="feedback-modal">
	// 		<div class="feedback-content">
	// 			<span class="close-button">&times;</span>
	// 			<h2>Share Your Feedback</h2>
	// 			<form id="feedback-form">
	// 				<textarea id="feedback-text" placeholder="Type your feedback here..." required style="width:100%; height:100px; margin-bottom: 10px;"></textarea>
	// 				<button type="submit" class="button button-primary">Submit Feedback</button>
	// 			</form>
	// 		</div>
	// 	</div>';
	// }

	public function popup_for_feedback() {
		$get_reasons 	= get_reasons();
		$user 			= wp_get_current_user();
	    if ( $user->exists() ) {
	        $admin_email 	= $user->user_email;
	        $name 			= $user->display_name; 
	    }
		
		echo '<div id="feedback-modal" class="feedback-modal plugin-unhappy-survey-overlay">
				<div class="feedback-content plugin-unhappy-survey-modal">
					<span class="close-button">&times;</span>
					<form method="post" class="plugin-unhappy-survey-form">
						<input type="hidden" name="action" value="handle_unhappy_survey">
						<input type="hidden" name="plugin_name" value="image-sizes">
						<input type="hidden" name="email" value="'. esc_attr( $admin_email ) .'">
						<input type="hidden" name="full_name" value="'. esc_attr( $name ) .'">
						<div class="plugin-header">
							<h3 class="heading">' . sprintf(__('We are sorry to hear that our plugin didn\'t fully meet your expectations.', 'thumbpress')) . '</h3>
							<p class="heading">' . __('Could you spare a moment to provide your valuable insights on how we can make it better?<br> It means a lot to us.', 'thumbpress') . '</p>
						</div>
						<div class="plugin-dsm-body">
							<div class="plugin-unhappy-reasons">';
								foreach ( $get_reasons as $key => $label ) {
									echo '<div class="plugin-unhappy-reason reason">
										<label for="' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label>
										<input type="checkbox" name="ureason[]" value="' . esc_attr( $label ) . '" id="' . esc_attr( $key ) . '">
									</div>';
								}
			echo '</div>
						<div class="plugin-dsm-reason-details">
							<textarea class="plugin-dsm-reason-details-input" name="explanation" rows="5" placeholder="' . esc_html__('Please Explain', 'thumbpress') . '"></textarea>
						</div>
					</div>
					<div class="plugin-dsm-footer footer">
						<div style="display: flex; justify-content: space-between;">
							<button class="button plugin-dsm-btn plugin-dsm-close">' . __('Skip', 'thumbpress') . '</button>
							<button class="button button-primary plugin-dsm-btn plugin-dsm-submit" type="submit">' . __('Submit', 'thumbpress') . '</button>
						</div>
					</div>
				</form>
			</div>
		</div>';
	}



	public function admin_notices() {

		if ( !defined( 'THUMBPRESS_PRO' ) && current_user_can( 'manage_options' ) ) {
			$current_screen    			= get_current_screen()->base;
			$current_time      			= wp_date('U');
			$install_date      			= get_option( 'image-sizes_install_time' );
			$user_id           			= get_current_user_id();
			$month_date        			= strtotime( '30 April 2024' );
			$display_count     			= (int) get_user_meta( $user_id, 'thumbpress_notice_display_count_' . $current_screen, true );
			$combined_display_count 	= (int) get_user_meta( $user_id, 'thumbpress_notice_display_count_combined', true );
			$seven_days_after_install 	= strtotime( '+7 days', $install_date );
			$notice_dismissed 			= get_option( 'thumbpress_notice_dismissed_' . $current_screen, false );
			$notice_dismissed2 			= get_option( 'thumbpress_notice_dismissed_week', false );
			$days_since_install 		= ( $current_time - $install_date ) / DAY_IN_SECONDS;
			$days_since_install 		= floor( $days_since_install );


			// if ( $install_date < $month_date && ( $current_screen == 'dashboard' && !$notice_dismissed ) ) {
			// 	if ( $display_count < 2 ) {
			// 		printf(
			// 			'<div id="image-sizes-hide-banner-dashboard" class="notice notice-success is-dismissible image-sizes-admin_notice">
			// 			<p>You are a long-time user of ThumbPress and we always value users like you the most.<br>
			// 			Last month we revamped the version of ThumbPress and brought all the image and thumbnail management solutions you need in one plugin.<br>
			// 			Now we would love to hear about the experience of loyal users like you about the new ThumbPress so far because we value your opinions and suggestions.<br>
			// 			Could you please take a minute to share your thoughts with us about ThumbPress? We would highly appreciate your time and feedback.</p>
			// 			<form class="image-sizes-banner" method="post">
			// 			<input type="hidden" value="%s" name="thumbpress_nonce">
			// 			<button type="button" class="notice-dismiss image-sizes-notice" data-target="dashboard">Dismiss</button>
			// 			</form>
			// 			</div>',
			// 			 wp_create_nonce()
			// 		);
			// 		update_user_meta( $user_id, 'thumbpress_notice_display_count_dashboard', $display_count + 1 );
			// 	}
			// }

			// if  ( $current_screen == 'toplevel_page_thumbpress' && !$notice_dismissed ) {
			// 	printf(
			// 		'<div id="image-sizes-hide-banner-toplevel" class="notice notice-success is-dismissible image-sizes-admin_notice">
			// 		<p>You are a long-time user of ThumbPress and we always value users like you the most.<br>
			// 		Last month we revamped the version of ThumbPress and brought all the image and thumbnail management solutions you need in one plugin.<br>
			// 		Now we would love to hear about the experience of loyal users like you about the new ThumbPress so far because we value your opinions and suggestions.<br>
			// 		Could you please take a minute to share your thoughts with us about ThumbPress? We would highly appreciate your time and feedback.</p>
			// 		<form class="image-sizes-banner" method="post">
			// 		<input type="hidden" value="%s" name="thumbpress_nonce">
			// 		<button type="button" class="notice-dismiss image-sizes-notice" data-target="toplevel_page_thumbpress">Dismiss</button>
			// 		</form>
			// 		</div>',
			// 		wp_create_nonce()
			// 	);
			// }

			if ( $current_time > $seven_days_after_install && ( $current_screen == 'dashboard' || $current_screen == 'toplevel_page_thumbpress' ) && !$notice_dismissed2 ) {
					if ( $combined_display_count < 3 ) {

					printf(
						'<div id="image-sizes-after-aweek" class="notice notice-success is-dismissible image-sizes-admin_notice">
							<div class="main-div">
								<img id="img-style" src="%s" alt="ThumbPress Icon">
								<div>
									<div class="contents">
										<p>It’s been <span class="bold">%d days</span> since you started using ThumbPress - that’s awesome 🎉 <br> Could you please do us a BIG favor by giving it a <span class="bold">5-star</span> rating? It means a lot to us 🤗</p>
									</div>
									<form class="image-sizes-banner" method="post">
										<input type="hidden" value="%s" name="thumbpress_nonce">
										<button type="button" class="notice-dismiss image-sizes-notice" data-target="after_aweek_thumbpress">Dismiss</button>
										<button type="button" class="image-sizes-response positive" data-response="positive" data-target="after_aweek_thumbpress">Review ThumbPress</button>
										<button type="button button-primary" class="image-sizes-response negative" data-response="negative" data-target="after_aweek_thumbpress">No, there are areas to improve </button>
									</form>
								</div>
							</div>
						</div>',
						plugins_url('../assets/img/icon.png', __FILE__),
						$days_since_install,
						wp_create_nonce(),
					);
						update_user_meta( $user_id, 'thumbpress_notice_display_count_combined', $combined_display_count + 1 );
				}
			}
		}
		
		if ( 
			current_user_can( 'manage_options' )

			&& ( get_option( "{$this->slug}_setup_done" ) != 1 )
			&& ( get_option( "{$this->slug}_dismiss" ) != 1 ) ) {
			?>
			<div data-meta_key='cx-setup-notice' class="notice notice-warning image_sizes-dismiss cx-notice cx-shadow is-dismissible">			
				<h3>
					<?php _e( 'Congratulations! You\'re almost there.. 🥳', 'image-sizes' ); ?>
				</h3>
				<p>
					<?php printf( __( 'Thanks for installing <strong>ThumbPress</strong>. To start managing your images and thumbnails, please complete the setup wizard.', 'image-sizes' ) ); ?>
				</p>
				<p>
					<a class="button button-primary" href="<?php echo add_query_arg( 'page', "{$this->slug}_setup", admin_url( 'admin.php' ) ); ?>">
						<?php _e( 'Run Setup Wizard', 'image-sizes' ); ?>
					</a>
				</p>
			</div>
			<?php
		}
	}

	public function show_new_button( $section ){
		// Helper::pri( 'Hello' );
		
	}

	// /**
	//  * Returns all WP pointers
	//  *
	//  * @return array
	//  */
	// public function get_pointers() {
	// 	if ( ! defined( 'THUMBPRESS_PRO' ) ) {
	// 		$current_time 	= wp_date( 'U' );
	// 		$notice_meta 	= get_option( 'thumbpress_pro_notice_recurring_every_1_month', true );

	// 		if ( $current_time >= $notice_meta ) {
	// 			$pointers = array(
	// 				'target' 	=> '#toplevel_page_thumbpress',
	// 				'edge' 		=> 'left',
	// 				'align' 	=> 'right',
	// 				'content' 	=> sprintf(
	// 					__( '<h3>%1s %2s</h3>
	// 						<p class="image_sizes-para">🎉 %3s %4s, %5s %6s 
	// 						</b> 
	// 						<a class="image_sizes-notice_ahref" href="%7s">
	// 						<button >%8s</button>
	// 						</a>
	// 						</p>', 'images-sizes' ),
	// 					__( 'ThumbPress Pro', 'images-sizes' ),
	// 					__( 'Grand Launch', 'images-sizes' ),
	// 					__( '25%', 'images-sizes' ),
	// 					__( 'OFF Yearly', 'images-sizes' ),
	// 					__( '50%', 'images-sizes' ),
	// 					__( 'OFF Lifetime - Limited-time Only!', 'images-sizes' ),
	// 					admin_url( 'admin.php?page=thumbpress' ),
	// 					__( 'Upgrade Now', 'images-sizes' )
	// 				),
	// 				'action' 	=> 'image_sizes-pointer-dismiss',
	// 			);

	// 			return $pointers;
	// 		}
	// 	}		
	// }
}