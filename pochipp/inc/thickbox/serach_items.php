<?php
/**
 * 商品検索部分の中身
 */
// phpcs:disable WordPress.WP.GlobalVariablesOverride.Prohibited

// iframeのURLから受け取るパラメータ
$tab     = \POCHIPP::get_sanitized_data( $_GET, 'tab', 'text', \POCHIPP::TABKEYS['amazon'] );
$cid     = \POCHIPP::get_sanitized_data( $_GET, 'blockid', 'text', '' );
$postid  = \POCHIPP::get_sanitized_data( $_GET, 'postid', 'int', 0 );
$at      = \POCHIPP::get_sanitized_data( $_GET, 'at', 'text', '' );
$only    = \POCHIPP::get_sanitized_data( $_GET, 'only', 'text', '' );
$keyword = \POCHIPP::get_sanitized_data( $_GET, 'keyword', 'text', '' );

// 各タブにおける共通パーツ
$pochipp_url  = esc_url( POCHIPP_URL . 'assets/img/search-solid.svg' );
$common_parts = <<<HTML
<div class="pchpp-tb__keywords">
	<input id="keywords" type="text" name="keywords" placeholder="キーワードを入力してください" value="{$keyword}">
	<button id="submit" class="button" type="submit" >
		<img src="{$pochipp_url}" alt="" width="20" height="20" >
	</button>
</div>
HTML;
?>
<script type="text/javascript">
	window.pochippIframeVars = {
		adminUrl: "<?php echo esc_js( admin_url() ); ?>", // 管理画面URL
		ajaxUrl: "<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>", // Ajax用URL
		tabKey: "<?php echo esc_js( $tab ); ?>", // 現在のタブ種別
		blockId: "<?php echo esc_js( $cid ); ?>", // ブロックID
		calledAt: "<?php echo esc_js( $at ); ?>", // どこから呼び出されたか
		only: "<?php echo esc_js( $only ); ?>", // 限定検索かどうか
	};
</script>
<div id="pochipp_tb_content" class="pchpp-tb -<?php echo esc_attr( $tab ); ?> wp-core-ui">
	<?php media_upload_header(); // タブ呼び出し ?>
	<div class="pchpp-tb__body">
		<div id="search_area" class="pchpp-tb__search">
			<form id="search_form" method="GET" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
				<?php
					// Amazonタブ
					if ( \POCHIPP::TABKEYS['amazon'] === $tab ) :
					include __DIR__ . '/form_amazon.php';
					endif;

					// 楽天タブ
					if ( \POCHIPP::TABKEYS['rakuten'] === $tab ) :
					include __DIR__ . '/form_rakuten.php';
					endif;

					// Yahooタブ
					if ( \POCHIPP::TABKEYS['yahoo'] === $tab ) :
					include __DIR__ . '/form_yahoo.php';
					endif;

					// 登録済み商品タブ
					if ( \POCHIPP::TABKEYS['registerd'] === $tab ) :
					include __DIR__ . '/form_registerd.php';
					endif;
				?>
			</form>
		</div>
		<div id="result_area" class="pchpp-tb__result">
			<!-- 検索結果がここに描画される -->
		</div>
		<div id="loading_image">
			<img src="<?php echo esc_url( POCHIPP_URL ); ?>assets/img/loading_b.gif" alt="" width="80">
		</div>
	</div>
</div>
