<?php
namespace POCHIPP;

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="pchpp-setting__section_help">
	<p>
		※ ご利用前に楽天の公式ドキュメントをご確認ください。<br>
		<a href="https://webservice.faq.rakuten.net/hc/ja/categories/900000158383-%E3%81%94%E5%88%A9%E7%94%A8%E3%83%AB%E3%83%BC%E3%83%AB" target="_blank" rel="noopener noreferrer">Rakuten Devekipers ご利用ルール契約</a>
	</p>
	<div class="__helpLink">
		アプリIDやアフィリエイトIDの設定方法は<a href="https://pochipp.com/180/" target="_blank" rel="noopener noreferrer" class="dashicons-before dashicons-book-alt">こちらのページ</a>で解説しています。
	</div>
</div>

<h3 class="pchpp-setting__h3">検索設定</h3>
<p class="pchpp-setting__p">
	楽天APIを使って商品検索をするためには、<a href="https://webservice.rakuten.co.jp/" target="_blank" rel="noopener noreferrer">Rakuten Developers</a>から発行可能な「アプリID」の設定が必要です。
</p>
<div class="pchpp-setting__div rakuten-appid">
	<dl class="pchpp-setting__dl">
		<dt>アプリID<br>( デベロッパーID )</dt>
		<dd>
			<?php
				\POCHIPP::output_text_field([
					'key'   => 'rakuten_app_id',
				]);
			?>
			<span class="errMessage"></span>
		</dd>
	</dl>
</div>


<h3 class="pchpp-setting__h3">アフィリエイト設定</h3>
<p class="pchpp-setting__p">
	楽天の「アフィリエイトID」を設定することで、商品リンクがアフィリエイトリンクに自動変換されます。
	<br>
	<a href="https://webservice.rakuten.co.jp/account_affiliate_id/" target="_blank" rel="noopener noreferrer">アフィリエイトIDの確認ページ</a>からIDを調べて登録してください。
</p>
<div class="pchpp-setting__div rakuten-affiliate">
	<dl class="pchpp-setting__dl">
		<dt>アフィリエイトID</dt>
		<dd>
			<?php
				\POCHIPP::output_text_field([
					'key'   => 'rakuten_affiliate_id',
				]);
			?>
			<span class="errMessage"></span>
		</dd>
	</dl>
</div>
