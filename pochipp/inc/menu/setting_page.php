<?php
namespace POCHIPP;

if ( ! defined( 'ABSPATH' ) ) exit;

$SETTING_TABS = apply_filters( 'pochipp_setting_tabs', [
	'basic'     => '基本設定',
	'amazon'    => 'Amazon',
	'rakuten'   => '楽天市場',
	'yahoo'     => 'Yahooショッピング',
	'mercari'   => 'メルカリ',
	'moshimo'   => 'もしも',
	'sale'      => 'セール情報',
] );
if ( \POCHIPP::$use_licence ) {
	$SETTING_TABS['licence'] = 'ライセンス';
}
$now_tab = \POCHIPP::get_sanitized_data( $_GET, 'tab', 'text', 'basic' );

// メッセージ
$green_message = '';
if ( isset( $_REQUEST['settings-updated'] ) && $_REQUEST['settings-updated'] ) {
	$green_message = '設定を保存しました。';
}

// オンボーディング: 一度見た or 投稿ブロックが存在する場合は表示しない
$show_onboarding = \POCHIPP::get_setting( 'show_onboarding' );
if ( $show_onboarding && ! isset( $_REQUEST['settings-updated'] ) ) {
	$args      = [
		'post_type'      => [ 'pochipps' ],
		'no_found_rows'  => true,
		'posts_per_page' => -1,
	];
	$the_query = new \WP_Query( $args );
	if ( count( $the_query->posts ) === 0 ) {
		include __DIR__ . '/onboarding.php';
	}

	// 1度表示すると表示しないようにする
	\POCHIPP::update_setting( [ 'show_onboarding' => '0' ] );
}

?>
<div id="pochipp_setting" class="wrap pchpp-setting">
	<hr class="wp-header-end">
	<?php if ( $green_message ) : ?>
		<div class="notice updated is-dismissible"><p><?php echo esc_html( $green_message ); ?></p></div>
	<?php endif; ?>
	<header class="pchpp-setting__header">
		<h1 class="pchpp-setting__title">
			<img src="<?php echo esc_url( POCHIPP_URL ); ?>assets/img/pochipp-logo.png" alt="ポチップ設定" width="200" height="50">
		</h1>
		<button class="pchpp-setting__menubtn">
			<span class="dashicons dashicons-menu-alt"></span>
		</button>
		<div class="pchpp-setting__tabs">
			<div class="__tabs__wrap">
				<?php
					foreach ( $SETTING_TABS as $key => $val ) :
					$setting_url = admin_url( 'edit.php?post_type=pochipps&page=pochipp_settings' );
					$tab_url     = $setting_url . '&tab=' . $key;
					$nav_class   = ( $now_tab === $key ) ? '__tab is-active' : '__tab';

					echo '<a href="' . esc_url( $tab_url ) . '" class="' . esc_attr( $nav_class ) . '" data-key="' . esc_attr( $key ) . '">' . esc_html( $val ) . '</a>';
					endforeach;
				?>
			</div>
		</div>
	</header>

	<div class="pchpp-setting__body">
		<form method="POST" action="options.php">
			<?php
				foreach ( $SETTING_TABS as $key => $val ) :
				$tab_class = ( $now_tab === $key ) ? 'tab-contents is-active' : 'tab-contents';

				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo '<div id="' . $key . '" class="' . $tab_class . '">';
				do_settings_sections( \POCHIPP::MENU_PAGE_PREFIX . '_' . $key );
				submit_button( '', 'primary large', 'submit_' . $key );
				echo '</div>';
				endforeach;
				settings_fields( \POCHIPP::SETTING_GROUP );
			?>
		</form>
	</div>
</div>
