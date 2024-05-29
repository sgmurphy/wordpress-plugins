<?php
namespace POCHIPP;

if ( ! defined( 'ABSPATH' ) ) exit;

function get_custom_style() {
	$amazon_btn_color   = \POCHIPP::get_setting( 'amazon_btn_color' );
	$rakuten_btn_color  = \POCHIPP::get_setting( 'rakuten_btn_color' );
	$yahoo_btn_color    = \POCHIPP::get_setting( 'yahoo_btn_color' );
	$mercari_btn_color  = \POCHIPP::get_setting( 'mercari_btn_color' );
	$custom_btn_color   = \POCHIPP::get_setting( 'custom_btn_color' );
	$custom_btn_color_2 = \POCHIPP::get_setting( 'custom_btn_color_2' );
	$inline_btn_color   = \POCHIPP::get_setting( 'inline_btn_color' );

	// インラインボタン
	$inline_btn_txt_color = '#fff';
	$inline_btn_bg_color  = 'var(--pchpp-color-inline)';
	$inline_btn_shadow    = '0 1px 4px -1px rgba(0, 0, 0, 0.2)';
	$inline_btn_radius    = '0px';
	$inline_btn_width     = 'auto';

	if ( 'outline' === \POCHIPP::get_setting( 'inline_btn_style' ) ) {
		$inline_btn_txt_color = 'var(--pchpp-color-inline)';
		$inline_btn_bg_color  = 'none';
		$inline_btn_shadow    = 'inset 0 0 0 1px currentColor, 0 1px 4px -1px rgba(0, 0, 0, 0.2)';
	}

	if ( 'on' === \POCHIPP::get_setting( 'inline_btn_radius' ) ) {
		$inline_btn_radius = '40px';
	}

	$inline_width_setting = \POCHIPP::get_setting( 'inline_btn_width' );
	if ( 'fix' === $inline_width_setting ) {
		$inline_btn_width = '12em';
	} elseif ( 'small_fix' === $inline_width_setting ) {
		$inline_btn_width = '9em';
	} elseif ( 'wide_fix' === $inline_width_setting ) {
		$inline_btn_width = '15em';
	}

	$style = ':root{' .
		"--pchpp-color-inline: {$inline_btn_color};" .
		"--pchpp-color-custom: {$custom_btn_color};" .
		"--pchpp-color-custom-2: {$custom_btn_color_2};" .
		"--pchpp-color-amazon: {$amazon_btn_color};" .
		"--pchpp-color-rakuten: {$rakuten_btn_color};" .
		"--pchpp-color-yahoo: {$yahoo_btn_color};" .
		"--pchpp-color-mercari: {$mercari_btn_color};" .
		"--pchpp-inline-bg-color: {$inline_btn_bg_color};" .
		"--pchpp-inline-txt-color: {$inline_btn_txt_color};" .
		"--pchpp-inline-shadow: {$inline_btn_shadow};" .
		"--pchpp-inline-radius: {$inline_btn_radius};" .
		"--pchpp-inline-width: {$inline_btn_width};" .
	'}';
	return $style;
}


/**
 * Output code
 */
add_action( 'wp_head', function() {

	echo '<!-- Pochipp -->' . PHP_EOL;

	// CSS for Custom buttons
	echo '<style id="pchpp_custom_style">' . \POCHIPP\get_custom_style() . '</style>' . PHP_EOL; // phpcs:ignore

	// for Ajax
	$script  = 'window.pchppVars = {};';
	$script .= 'window.pchppVars.ajaxUrl = "' . esc_js( admin_url( 'admin-ajax.php' ) ) . '";';
	$script .= 'window.pchppVars.ajaxNonce = "' . esc_js( wp_create_nonce( \POCHIPP::NONCE_KEY ) ) . '";';

	echo '<script id="pchpp_vars">' . $script . '</script>' . PHP_EOL; // phpcs:ignore

	// ウィジェットプレビューではこれ以降出力しない
	if ( defined( 'IFRAME_REQUEST' ) && IFRAME_REQUEST ) return;

	// LinkSwitch
	$linkswitch_code = \POCHIPP::get_setting( 'yahoo_linkswitch' );
	if ( is_numeric( $linkswitch_code ) ) {
		echo '<script type="text/javascript" language="javascript">' .
			'var vc_pid = "' . esc_html( $linkswitch_code ) . '";' .
		'</script>' . PHP_EOL;
		wp_enqueue_script( 'pochipp-vcdal', '//aml.valuecommerce.com/vcdal.js', [], \POCHIPP::$version, true );
	} else {
		echo $linkswitch_code . PHP_EOL; // phpcs:ignore
	};

	echo '<!-- / Pochipp -->' . PHP_EOL;
} );


add_action( 'admin_head', function() {

	// CSS for Custom buttons
	echo '<style id="pchpp_custom_style">' . \POCHIPP\get_custom_style() . '</style>' . PHP_EOL; // phpcs:ignore

	// for Ajax
	$script  = 'window.pchppVars = {};';
	$script .= 'window.pchppVars.adminUrl = "' . esc_js( admin_url() ) . '";';
	$script .= 'window.pchppVars.ajaxUrl = "' . esc_js( admin_url( 'admin-ajax.php' ) ) . '";';
	$script .= 'window.pchppVars.ajaxNonce = "' . esc_js( wp_create_nonce( \POCHIPP::NONCE_KEY ) ) . '";';

	// for Block
	$script .= 'window.pchppVars.btnStyle = "' . esc_js( \POCHIPP::get_setting( 'btn_style' ) ) . '";';
	$script .= 'window.pchppVars.btnRadius = "' . esc_js( \POCHIPP::get_setting( 'btn_radius' ) ) . '";';
	$script .= 'window.pchppVars.imgPosition = "' . esc_js( \POCHIPP::get_setting( 'img_position' ) ) . '";';
	$script .= 'window.pchppVars.boxLayoutPC = "' . esc_js( \POCHIPP::get_setting( 'box_layout_pc' ) ) . '";';
	$script .= 'window.pchppVars.boxLayoutMB = "' . esc_js( \POCHIPP::get_setting( 'box_layout_mb' ) ) . '";';
	$script .= 'window.pchppVars.displayPrice = "' . esc_js( \POCHIPP::get_setting( 'display_price' ) ) . '";';
	$script .= 'window.pchppVars.hasAffi = {' .
		'amazon: "' . esc_js( \POCHIPP::$has_affi['amazon'] ) . '",' .
		'rakuten: "' . esc_js( \POCHIPP::$has_affi['rakuten'] ) . '",' .
		'yahoo: "' . esc_js( \POCHIPP::$has_affi['yahoo'] ) . '",' .
		'mercari: "' . esc_js( \POCHIPP::$has_affi['mercari'] ) . '",' .
	'};';

	echo '<script id="pchpp_admin_vars">' . $script . '</script>' . PHP_EOL; // phpcs:ignore

} );

/**
 * Review Link
 */
add_action( 'wp', '\POCHIPP\set_review_url' );
function set_review_url() {
	if ( ! class_exists( 'Pochipp_Pro' ) ) {
		add_filter( 'pochipp_show_review_url', '__return_false' );
	}
}

/**
 * Sale
 */
add_action( 'wp', '\POCHIPP\set_sale_text' );
function set_sale_text() {

	// セール情報をセット
	if ( has_action( 'pro_output_sale' ) ) {
		do_action( 'pro_output_sale' );
	} else {
		\POCHIPP\set_sale_data();
	}
	\POCHIPP\set_campaign_data();

	// Amazon
	if ( \POCHIPP::$sale_text['amazon'] ) {
		add_filter( 'pochipp_amazon_sale_text', function() {
			return \POCHIPP::$sale_text['amazon'];
		});

		// セール中に他のボタンを隠すかどうか
		if ( \POCHIPP::get_setting( 'hide_rakuten_at_amazon_sale' ) ) {
			add_filter( 'pochipp_show_rakuten_btn', '__return_false' );
		}
		if ( \POCHIPP::get_setting( 'hide_yahoo_at_amazon_sale' ) ) {
			add_filter( 'pochipp_show_yahoo_btn', '__return_false' );
		}
		if ( \POCHIPP::get_setting( 'hide_mercari_at_amazon_sale' ) ) {
			add_filter( 'pochipp_show_mercari_btn', '__return_false' );
		}
		if ( \POCHIPP::get_setting( 'hide_custom_at_amazon_sale' ) ) {
			add_filter( 'pochipp_show_custom_btn', '__return_false' );
			add_filter( 'pochipp_show_custom_btn_2', '__return_false' );
		}
	}

	// 楽天
	if ( \POCHIPP::$sale_text['rakuten'] ) {
		add_filter( 'pochipp_rakuten_sale_text', function() {
			return \POCHIPP::$sale_text['rakuten'];
		});

		// セール中に他のボタンを隠すかどうか
		if ( \POCHIPP::get_setting( 'hide_amazon_at_rakuten_sale' ) ) {
			add_filter( 'pochipp_show_amazon_btn', '__return_false' );
		}
		if ( \POCHIPP::get_setting( 'hide_yahoo_at_rakuten_sale' ) ) {
			add_filter( 'pochipp_show_yahoo_btn', '__return_false' );
		}
		if ( \POCHIPP::get_setting( 'hide_mercari_at_rakuten_sale' ) ) {
			add_filter( 'pochipp_show_mercari_btn', '__return_false' );
		}
		if ( \POCHIPP::get_setting( 'hide_custom_at_rakuten_sale' ) ) {
			add_filter( 'pochipp_show_custom_btn', '__return_false' );
			add_filter( 'pochipp_show_custom_btn_2', '__return_false' );
		}
	}

	// Yahoo
	if ( \POCHIPP::$sale_text['yahoo'] ) {
		add_filter( 'pochipp_yahoo_sale_text', function() {
			return \POCHIPP::$sale_text['yahoo'];
		});

		// セール中に他のボタンを隠すかどうか
		if ( \POCHIPP::get_setting( 'hide_amazon_at_yahoo_sale' ) ) {
			add_filter( 'pochipp_show_amazon_btn', '__return_false' );
		}
		if ( \POCHIPP::get_setting( 'hide_rakuten_at_yahoo_sale' ) ) {
			add_filter( 'pochipp_show_rakuten_btn', '__return_false' );
		}
		if ( \POCHIPP::get_setting( 'hide_mercari_at_yahoo_sale' ) ) {
			add_filter( 'pochipp_show_mercari_btn', '__return_false' );
		}
		if ( \POCHIPP::get_setting( 'hide_custom_at_yahoo_sale' ) ) {
			add_filter( 'pochipp_show_custom_btn', '__return_false' );
			add_filter( 'pochipp_show_custom_btn_2', '__return_false' );
		}
	}

	// メルカリ
	if ( \POCHIPP::$sale_text['mercari'] ) {
		add_filter( 'pochipp_mercari_sale_text', function() {
			return \POCHIPP::$sale_text['mercari'];
		});

		// セール中に他のボタンを隠すかどうか
		if ( \POCHIPP::get_setting( 'hide_amazon_at_mercari_sale' ) ) {
			add_filter( 'pochipp_show_amazon_btn', '__return_false' );
		}
		if ( \POCHIPP::get_setting( 'hide_rakuten_at_mercari_sale' ) ) {
			add_filter( 'pochipp_show_rakuten_btn', '__return_false' );
		}
		if ( \POCHIPP::get_setting( 'hide_yahoo_at_mercari_sale' ) ) {
			add_filter( 'pochipp_show_yahoo_btn', '__return_false' );
		}
		if ( \POCHIPP::get_setting( 'hide_custom_at_mercari_sale' ) ) {
			add_filter( 'pochipp_show_custom_btn', '__return_false' );
			add_filter( 'pochipp_show_custom_btn_2', '__return_false' );
		}
	}
}


/**
 * セール情報をスクリプトで渡す
 */
add_action( 'wp_footer', function() {

	// ウィジェットプレビューではこれ以降出力しない
	if ( defined( 'IFRAME_REQUEST' ) && IFRAME_REQUEST ) return;

	$amazon_sale_data  = [
		'start' => \POCHIPP::get_setting( 'amazon_sale_startline' ),
		'end'   => \POCHIPP::get_setting( 'amazon_sale_deadline' ),
		'text'  => \POCHIPP::get_setting( 'amazon_sale_text' ),
	];
	$rakuten_sale_data = [
		'start' => \POCHIPP::get_setting( 'rakuten_sale_startline' ),
		'end'   => \POCHIPP::get_setting( 'rakuten_sale_deadline' ),
		'text'  => \POCHIPP::get_setting( 'rakuten_sale_text' ),
	];
	$yahoo_sale_data   = [
		'start' => \POCHIPP::get_setting( 'yahoo_sale_startline' ),
		'end'   => \POCHIPP::get_setting( 'yahoo_sale_deadline' ),
		'text'  => \POCHIPP::get_setting( 'yahoo_sale_text' ),
	];
	$mercari_sale_data = [
		'start' => \POCHIPP::get_setting( 'mercari_sale_startline' ),
		'end'   => \POCHIPP::get_setting( 'mercari_sale_deadline' ),
		'text'  => \POCHIPP::get_setting( 'mercari_sale_text' ),
	];
	?>
<script>
var pochippSaleData = {
	amazon:<?php echo wp_json_encode( $amazon_sale_data, JSON_UNESCAPED_UNICODE ); ?>,
	rakuten:<?php echo wp_json_encode( $rakuten_sale_data, JSON_UNESCAPED_UNICODE ); ?>,
	yahoo:<?php echo wp_json_encode( $yahoo_sale_data, JSON_UNESCAPED_UNICODE ); ?>,
	mercari:<?php echo wp_json_encode( $mercari_sale_data, JSON_UNESCAPED_UNICODE ); ?>,
};
</script>
	<?php
}, 5 );
