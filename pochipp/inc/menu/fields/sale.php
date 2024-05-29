<?php
namespace POCHIPP;

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="pchpp-setting__section_help">
	<div class="__helpLink">
		セール情報の設定方法は<a href="https://pochipp.com/302/" target="_blank" rel="noopener noreferrer" class="dashicons-before dashicons-book-alt">こちらのページ</a>で解説しています。
	</div>
</div>

<h3 class="pchpp-setting__h3">
	セールの自動取得
	<?php if ( ! has_action( 'pochipp_pro_sale_infobar' ) ) echo '・セール時のお知らせバー設定'; ?>
</h3>
<div class="pchpp-setting__div">
	<dl class="pchpp-setting__dl">
		<dd>
		<?php if ( has_action( 'pochipp_pro_auto_sale_info' ) ) : ?>
			<?php do_action( 'pochipp_pro_auto_sale_info' ); ?>
		<?php else : ?>
					この機能は<a href="https://pochipp.com/pochipp-pro/" target="_blank"
										rel="noopener noreferrer">Pro版</a>のみご利用いただけます。
		<?php endif; ?>
		</dd>
	</dl>
</div>

<?php if ( has_action( 'pochipp_pro_sale_infobar' ) ) do_action( 'pochipp_pro_sale_infobar' ); ?>

<h3 class="pchpp-setting__h3">Amazonセール情報</h3>
<!-- <p class="pchpp-setting__p"></p> -->
<div class="pchpp-setting__div">
	<?php if ( has_action( 'pochipp_setting_amazon_sale' ) ) : ?>
		<?php do_action( 'pochipp_setting_amazon_sale' ); ?>
	<?php else : ?>
			<dl class="pchpp-setting__dl">
				<dt>セール情報</dt>
				<dd>
					<div class="pchpp-setting__row -time">
						<span class="__row_label">表示 :</span>
						<?php
							\POCHIPP::output_text_field( [
								'key' => 'amazon_sale_text',
							] );
						?>
					</div>
					<div class="pchpp-setting__row -time">
						<span class="__row_label">期間 :</span>
						<?php
							\POCHIPP::output_datepicker( [
								'key' => 'amazon_sale_',
							] );
						?>
					</div>
					<!-- <br> -->
					<!-- <p class="pchpp-setting__desc">
					  <code>Y/m/d G:i</code>の形式で入力してください。 例 : <code>2020/01/05 10:00</code>, <code>2020/11/25 20:00</code>
				  </p> -->
				</dd>
			</dl>
	<?php endif; ?>
	<dl class="pchpp-setting__dl">
		<dt>セール中に隠すボタン</dt>
		<dd class="-flex">
		<?php
		\POCHIPP::output_checkbox( [
			'key'   => 'hide_rakuten_at_amazon_sale',
			'label' => '楽天ボタン',
		] );
		\POCHIPP::output_checkbox( [
			'key'   => 'hide_yahoo_at_amazon_sale',
			'label' => 'Yahooボタン',
		] );
		\POCHIPP::output_checkbox( [
			'key'   => 'hide_mercari_at_amazon_sale',
			'label' => 'メルカリボタン',
		] );
		\POCHIPP::output_checkbox( [
			'key'   => 'hide_custom_at_amazon_sale',
			'label' => 'カスタムボタン',
		] );
		?>
		</dd>
	</dl>
</div>

<h3 class="pchpp-setting__h3">楽天セール情報</h3>
<div class="pchpp-setting__div">
	<?php if ( has_action( 'pochipp_setting_rakuten_sale' ) ) : ?>
		<?php do_action( 'pochipp_setting_rakuten_sale' ); ?>
	<?php else : ?>
			<dl class="pchpp-setting__dl">
				<dt>セール情報</dt>
				<dd>
					<div class="pchpp-setting__row -time">
						<span class="__row_label">表示 :</span>
						<?php
							\POCHIPP::output_text_field( [
								'key' => 'rakuten_sale_text',
							] );
						?>
					</div>
					<div class="pchpp-setting__row -time">
						<span class="__row_label">期間 :</span>
						<?php
							\POCHIPP::output_datepicker( [
								'key' => 'rakuten_sale_',
							] );
						?>
					</div>
					<!-- <p class="pchpp-setting__desc">
					  <code>Y/m/d G:i</code>の形式で入力してください。 例 : <code>2020/01/05 10:00</code>, <code>2020/11/25 20:00</code>
				  </p> -->
				</dd>
			</dl>
	<?php endif; ?>
	<dl class="pchpp-setting__dl">
		<dt>定期的なキャンペーン</dt>
		<dd>
			<div class="pchpp-setting__row -periodic">
				<?php
					\POCHIPP::output_checkbox( [
						'key'   => 'show_rakuten_5campaign',
						'label' => '「<b>5と0のつく日キャンペーン</b>」を表示する',
					] );
				?>
			</div>
			<div class="pchpp-setting__row -periodic">
				<span class="__row_label">表示 :</span>
				<?php
					\POCHIPP::output_text_field( [
						'key'   => 'rakuten_5campaign_text',
						'label' => '表示テキスト',
					] );
				?>
			</div>
		</dd>
	</dl>
	<dl class="pchpp-setting__dl">
		<dt>セール中に隠すボタン</dt>
		<dd class="-flex">
		<?php
		\POCHIPP::output_checkbox( [
			'key'   => 'hide_amazon_at_rakuten_sale',
			'label' => 'Amazonボタン',
		] );
		\POCHIPP::output_checkbox( [
			'key'   => 'hide_yahoo_at_rakuten_sale',
			'label' => 'Yahooボタン',
		] );
		\POCHIPP::output_checkbox( [
			'key'   => 'hide_mercari_at_rakuten_sale',
			'label' => 'メルカリボタン',
		] );
		\POCHIPP::output_checkbox( [
			'key'   => 'hide_custom_at_rakuten_sale',
			'label' => 'カスタムボタン',
		] );
		?>
		</dd>
	</dl>
</div>

<h3 class="pchpp-setting__h3">Yahooセール情報</h3>
<div class="pchpp-setting__div">
	<?php if ( has_action( 'pochipp_setting_yahoo_sale' ) ) : ?>
		<?php do_action( 'pochipp_setting_yahoo_sale' ); ?>
	<?php else : ?>
			<dl class="pchpp-setting__dl">
				<dt>セール情報</dt>
				<dd>
					<div class="pchpp-setting__row -time">
						<span class="__row_label">表示 :</span>
						<?php
							\POCHIPP::output_text_field( [
								'key' => 'yahoo_sale_text',
							] );
						?>
					</div>
					<div class="pchpp-setting__row -time">
						<span class="__row_label">期間 :</span>
						<?php
							\POCHIPP::output_datepicker( [
								'key' => 'yahoo_sale_',
							] );
						?>
					</div>
					<!-- <p class="pchpp-setting__desc">
					  <code>Y/m/d G:i</code>の形式で入力してください。 例 : <code>2020/01/05 10:00</code>, <code>2020/11/25 20:00</code>
				  </p> -->
				</dd>
			</dl>
	<?php endif; ?>
	<dl class="pchpp-setting__dl">
		<dt>定期的なキャンペーン</dt>
		<dd>
			<div class="pchpp-setting__row -periodic">
				<?php
					\POCHIPP::output_checkbox( [
						'key'   => 'show_yahoo_5campaign',
						'label' => '「<b>5のつく日キャンペーン</b>」を表示する',
					] );
				?>
			</div>
			<div class="pchpp-setting__row -periodic">
				<span class="__row_label">表示 :</span>
				<?php
					\POCHIPP::output_text_field( [
						'key'   => 'yahoo_5campaign_text',
						'label' => '表示テキスト',
					] );
				?>
			</div>
		</dd>
	</dl>
	<dl class="pchpp-setting__dl">
		<dt>セール中に隠すボタン</dt>
		<dd class="-flex">
		<?php
		\POCHIPP::output_checkbox( [
			'key'   => 'hide_amazon_at_yahoo_sale',
			'label' => 'Amazonボタン',
		] );
		\POCHIPP::output_checkbox( [
			'key'   => 'hide_rakuten_at_yahoo_sale',
			'label' => '楽天ボタン',
		] );
		\POCHIPP::output_checkbox( [
			'key'   => 'hide_mercari_at_yahoo_sale',
			'label' => 'メルカリボタン',
		] );
		\POCHIPP::output_checkbox( [
			'key'   => 'hide_custom_at_yahoo_sale',
			'label' => 'カスタムボタン',
		] );
		?>
		</dd>
	</dl>
</div>

<h3 class="pchpp-setting__h3">メルカリセール情報</h3>
<!-- <p class="pchpp-setting__p"></p> -->
<div class="pchpp-setting__div">
	<?php if ( has_action( 'pochipp_setting_mercari_sale' ) ) : ?>
		<?php do_action( 'pochipp_setting_mercari_sale' ); ?>
	<?php else : ?>
			<dl class="pchpp-setting__dl">
				<dt>セール情報</dt>
				<dd>
					<div class="pchpp-setting__row -time">
						<span class="__row_label">表示 :</span>
						<?php
						\POCHIPP::output_text_field( [
							'key' => 'mercari_sale_text',
						] );
						?>
					</div>
					<div class="pchpp-setting__row -time">
						<span class="__row_label">期間 :</span>
						<?php
							\POCHIPP::output_datepicker( [
								'key' => 'mercari_sale_',
							] );
						?>
					</div>
				</dd>
			</dl>
	<?php endif; ?>
	<dl class="pchpp-setting__dl">
		<dt>セール中に隠すボタン</dt>
		<dd class="-flex">
		<?php
		\POCHIPP::output_checkbox( [
			'key'   => 'hide_amazon_at_mercari_sale',
			'label' => 'Amazonボタン',
		] );
		\POCHIPP::output_checkbox( [
			'key'   => 'hide_rakuten_at_mercari_sale',
			'label' => '楽天ボタン',
		] );
		\POCHIPP::output_checkbox( [
			'key'   => 'hide_yahoo_at_mercari_sale',
			'label' => 'Yahooボタン',
		] );
		\POCHIPP::output_checkbox( [
			'key'   => 'hide_custom_at_mercari_sale',
			'label' => 'カスタムボタン',
		] );
		?>
		</dd>
	</dl>
</div>

<h3 class="pchpp-setting__h3">カスタムボタンセール情報</h3>
<div class="pchpp-setting__div">
	<p>
		カスタムボタンのセール情報は「<a href="<?php echo admin_url( 'edit.php?post_type=pochipps' ); ?>">ポチップ管理</a>」より、各商品ごとに設定を行えます。
	</p>
</div>

<h3 class="pchpp-setting__h3">セール情報の表示エフェクト</h3>
<div class="pchpp-setting__div">
	<dl class="pchpp-setting__dl">
		<!-- <dt>アクセント</dt> -->
		<dd>
		<?php
		\POCHIPP::output_radio( [
			'key'     => 'sale_text_effect',
			'choices' => [
				'none'  => 'なし',
				'flash' => '点滅',
			],
		] );
		?>
		</dd>
	</dl>
</div>
