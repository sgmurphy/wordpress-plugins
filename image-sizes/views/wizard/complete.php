<?php
use Codexpert\ThumbPress\Helper;

$plugins = [];
$all_plugins = get_plugins();

if ( array_key_exists( 'woocommerce/woocommerce.php', $all_plugins ) ) {
	if( ! array_key_exists( 'woolementor/woolementor.php', $all_plugins ) ){
		$plugins['woolementor']  = [
			'label'	=> __( 'CoDesigner (formerly Woolementor)', 'image-sizes' ),
			'desc'	=> sprintf( __( 'The Best Elementor Addon to Customize WooCommerce. Helps <a href="%s" target="_blank">boost your sales</a> significantly.', 'image-sizes' ), add_query_arg( [ 'utm_campaign' => 'image-sizes_wizard' ], 'https://codexpert.io/codesigner/' ) ),
		];
	}
	if( ! array_key_exists( 'wc-affiliate/wc-affiliate.php', $all_plugins ) ){
		$plugins['wc-affiliate']  = [
			'label'	=> __( 'WC Affiliate', 'image-sizes' ),
			'desc'	=> sprintf( __( 'The most feature-rich yet affordable <a href="%s" target="_blank">WooCommerce Affiliate</a> Plugin.', 'image-sizes' ), add_query_arg( [ 'utm_campaign' => 'image-sizes_wizard' ], 'https://codexpert.io/wc-affiliate/' ) )
		];
	}
	
}

if ( array_key_exists( 'elementor/elementor.php', $all_plugins ) ) {
	if( ! array_key_exists( 'restrict-elementor-widgets/restrict-elementor-widgets.php', $all_plugins ) ){
		$plugins['restrict-elementor-widgets']  = [
			'label'	=> __( 'Restrict Elementor Widgets', 'image-sizes' ),
			'desc'	=> sprintf( __( 'Hide your Elementor widgets, columns or sections based on <a href="%s" target="_blank">different conditions</a>.', 'image-sizes' ), add_query_arg( [ 'utm_campaign' => 'image-sizes_wizard' ], 'https://codexpert.io/product/restrict-elementor-widgets/' ) )
		];
	}	
}

if( ! array_key_exists( 'coschool/coschool.php', $all_plugins ) ){
	$plugins['coschool']  = [
		'label'	=> __( 'CoSchool', 'image-sizes' ),
		'desc'	=> sprintf( __( 'A New & Different WordPress <a href="%s" target="_blank">LMS Plugin</a> to sell your courses online.', 'image-sizes' ), add_query_arg( [ 'utm_campaign' => 'image-sizes_wizard' ], 'https://codexpert.io/coschool/' ) )
	];
}

echo '
<div class="step-three">
	<h1 class="cx-almost">' . __( 'Installation Complete! 👏', 'image-sizes' ) . '</h1>
	<p class="cx-wizard-sub">' . __( 'Congrats! You have successfully eliminated the unnecessary thumbnails from your website. 😎', 'image-sizes' ) . '</p>';
	if( count( $plugins ) > 0 ) {
		echo '<p class="cx-wizard-sub">'. __( 'Install our top plugins to make your website even better. You can always try them by returning to installation wizard later.', 'image-sizes' ) . '</p>
			<h2 class="cx-products">' . __( 'Supercharge your site with these plugins 🚀', 'image-sizes' ) . '</h2>';
	}

	foreach( $plugins as $plugin => $plugin_array ) {
  		?>
  		<p>
  			<input type="checkbox" class="cx-suggestion-checkbox" id="<?php esc_attr_e( $plugin ); ?>" name="<?php esc_attr_e( $plugin ); ?>" value="<?php esc_attr_e( $plugin ); ?>" />
  			<label class="cx-suggestion-label" for="<?php esc_attr_e( $plugin ); ?>"><?php esc_html_e( $plugin_array['label']  ) ?></label>
  			<sub class="cx-suggestion-sub"><?php _e( $plugin_array['desc'] ); ?> </sub>
  		</p>
  		<?php
	}

	echo '<h2 class="cx-products">' . __( 'And.. 👋', 'image-sizes' ) . '</h2>';
	
	printf( '
		<p>
			<input type="checkbox" class="cx-suggestion-checkbox" id="cx-allow-credit" name="cx-footer_credit" %3$s />
			<label class="cx-suggestion-label" for="cx-allow-credit">%1$s</label>
			<sub class="cx-suggestion-sub">%2$s</sub>
		</p>',
		__( 'Show appreciation for our work with footer credit', 'image-sizes' ),
		__( 'It\'s optional, but we recommend you keep this checked and help spread the word.', 'image-sizes' ),
		( Helper::get_option( 'image-sizes_tools', 'footer_credit' ) == 'yes' ? 'checked' : '' )
	);
 
echo '
</div>

<input type="hidden" name="cx-complete" value="1" />

<div id="loader_div" class="loader_div"></div>';
?>

<script type="text/javascript">
jQuery(document).ready(function($){
	$('#complete-btn').on('click', function(event) {        
		$(".loader_div").show();   
	});
});
</script>